<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookEditor;
use Illuminate\Http\Request;

class AdminBookEditorController extends Controller
{
    /**
     * Display a listing of book editors for admin approval.
     */
    public function index(Request $request)
    {
        $bookEditors = BookEditor::with(['book', 'user'])
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function ($q) use ($search) {
                        $q->where('full_name', 'like', '%'.$search.'%');
                    })
                        ->orWhereHas('book', function ($q) use ($search) {
                            $q->where('title', 'like', '%'.$search.'%');
                        });
                });
            })
            ->when($request->date, function ($query, $date) {
                return $query->whereDate('created_at', $date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.book-editor.admin-index', compact('bookEditors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bookEditor = BookEditor::with(['book', 'user'])->findOrFail($id);

        return view('admin.pages.book-editor.admin-edit', compact('bookEditor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,completed',
            'notes' => 'nullable|string',
        ]);

        $bookEditor = BookEditor::findOrFail($id);
        $bookEditor->update([
            'status' => $request->status,
            'notes' => $request->notes,
        ]);

        // Update book status if approved
        if ($request->status === BookEditor::STATUS_APPROVED) {
            $bookEditor->book->update(['status' => Book::STATUS_EDITING]);
        }

        return redirect()->route('admin.book-editor.claims')->with('success', 'Status editor buku berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $bookEditor = BookEditor::findOrFail($id);
        $bookEditor->delete();

        return redirect()->route('admin.book-editor.claims')->with('success', 'Editor buku berhasil dihapus.');
    }

    /**
     * Remove editor from book and allow reassignment.
     */
    public function removeEditor(Request $request, string $id)
    {
        $bookEditor = BookEditor::findOrFail($id);

        // Add note about removal
        $bookEditor->update([
            'status' => BookEditor::STATUS_REJECTED,
            'notes' => ($bookEditor->notes ? $bookEditor->notes.'\n' : '').'Removed by admin: '.$request->input('reason', 'No reason provided'),
        ]);

        // Soft delete the editor assignment
        $bookEditor->delete();

        return redirect()->back()->with('success', 'Editor berhasil dihapus dari buku ini.');
    }

    /**
     * Transfer editor to another book.
     */
    public function transferEditor(Request $request, string $id)
    {
        $request->validate([
            'new_book_id' => 'required|exists:books,id',
            'reason' => 'nullable|string|max:500',
        ]);

        $bookEditor = BookEditor::findOrFail($id);
        $oldBookTitle = $bookEditor->book->title;

        // Create new assignment
        $newBookEditor = BookEditor::create([
            'book_id' => $request->new_book_id,
            'user_id' => $bookEditor->user_id,
            'status' => BookEditor::STATUS_APPROVED,
            'notes' => 'Transferred from "'.$oldBookTitle.'". Reason: '.$request->input('reason', 'No reason provided'),
        ]);

        // Mark old assignment as rejected
        $bookEditor->update([
            'status' => BookEditor::STATUS_REJECTED,
            'notes' => ($bookEditor->notes ? $bookEditor->notes.'\n' : '').'Transferred to book ID: '.$request->new_book_id.'. Reason: '.$request->input('reason', 'No reason provided'),
        ]);

        // Soft delete the old assignment
        $bookEditor->delete();

        return redirect()->back()->with('success', 'Editor berhasil dipindahkan ke buku lain.');
    }
}
