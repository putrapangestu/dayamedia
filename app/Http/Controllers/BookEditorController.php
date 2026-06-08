<?php

namespace App\Http\Controllers;

use App\Http\Requests\Editor\UploadFileEditorRequest;
use App\Models\Book;
use App\Models\BookEditor;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookEditorController extends Controller
{
    use UploadTrait;

    public function index(Request $request)
    {
        $search = $request->input('search');

        // Get books that don't have editor yet and are in editing status
        $books = Book::with('category', 'modules')
            ->whereDoesntHave('bookEditors')
            ->where('status', Book::STATUS_EDITING)
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(10);

        // Get books that have all modules filled (ready to be claimed)
        $readyBooks = Book::with('category', 'modules')
            ->whereDoesntHave('bookEditors')
            ->where('status', Book::STATUS_EDITING)
            ->whereHas('modules', function ($query) {
                $query->whereNotNull('user_id');
            }, '=', function ($query) {
                $query->selectRaw('count(*)')
                    ->from('modules')
                    ->whereColumn('modules.book_id', 'books.id');
            })
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(10);

        $bookEditors = Book::with(['bookEditors' => function ($query) {
            $query->where('user_id', auth()->id())
                ->whereIn('status', [BookEditor::STATUS_PENDING, BookEditor::STATUS_APPROVED]);
        }, 'modules', 'category'])
            ->whereHas('bookEditors', function ($query) {
                $query->where('user_id', auth()->id())
                    ->whereIn('status', [BookEditor::STATUS_PENDING, BookEditor::STATUS_APPROVED]);
            })
            ->whereIn('status', [Book::STATUS_EDITING, Book::STATUS_PUBLISHED])
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%");
            })
            ->paginate(10);

        return view('admin.pages.book-editor.index', compact('books', 'bookEditors', 'readyBooks'));
    }

    public function show(string $id)
    {
        $book = Book::with('authors', 'category', 'modules.user', 'bookEditors')->findOrFail($id);
        $countModules = $book->modules->count();
        $countActiveModules = $book->modules->where('is_active', true)->count();
        $countAuthorUploads = $book->modules->where('is_active', true)->where('user_id', '!=', null)->where('file_path', '!=', null)->count();

        $checkEditing = ($book?->bookEditors?->file_turnitin && $book?->bookEditors?->file_path) ? true : false;

        return view('admin.pages.book-editor.detail', compact('book', 'countModules', 'countActiveModules', 'countAuthorUploads', 'checkEditing'));
    }

    public function claimBook(string $id)
    {
        $book = Book::with('authors', 'category')->findOrFail($id);

        // Check if user already claimed this book
        $existingClaim = BookEditor::where('user_id', auth()->id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingClaim) {
            return redirect()->back()->with('error', 'Anda sudah mengajukan klaim untuk buku ini');
        }

        BookEditor::create([
            'user_id' => auth()->id(),
            'book_id' => $book->id,
            'status' => BookEditor::STATUS_PENDING,
        ]);

        return redirect()->back()->with('success', 'Pengajuan klaim buku berhasil dikirim. Menunggu persetujuan admin.');
    }

    public function downloadFileTurnitin(string $id)
    {
        $bookEditor = BookEditor::findOrFail($id);

        return response()->download(storage_path('app/'.$bookEditor->file_turnitin));
    }

    public function downloadFile(string $id)
    {
        $bookEditor = BookEditor::findOrFail($id);

        // Check if file path is available
        if (! $bookEditor->file_path) {
            return redirect()->back()->with('error', 'File editor tidak tersedia.');
        }

        $filePath = Storage::path($bookEditor->file_path);
        if (! file_exists($filePath)) {
            return redirect()->back()->with('error', 'File editor tidak ditemukan.');
        }

        return response()->download($filePath);
    }

    public function uploadFileEditor(UploadFileEditorRequest $request, string $id)
    {
        $bookEditor = BookEditor::findOrFail($id);

        // Check if editor is approved to upload
        if ($bookEditor->status !== BookEditor::STATUS_APPROVED) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk mengupload file.');
        }

        $data = [
            'file_path' => $bookEditor->file_path,
            'file_turnitin' => $bookEditor->file_turnitin,
            'file_submitted_at' => now(),
            'file_status' => BookEditor::FILE_STATUS_PENDING,
        ];

        // Store file
        if ($request->hasFile('file_path')) {
            $filePath = $this->upload('book_editors/'.$bookEditor->book_id.'/files', $request->file('file_path'));
            $data['file_path'] = $filePath;
        }

        if ($bookEditor->file_path && $request->hasFile('file_path')) {
            $this->remove($bookEditor->file_path);
        }

        if ($request->hasFile('file_turnitin')) {
            $fileTurnitin = $this->upload('book_editors/'.$bookEditor->book_id.'/files-turnitin', $request->file('file_turnitin'));
            $data['file_turnitin'] = $fileTurnitin;
        }

        if ($bookEditor->file_turnitin && $request->hasFile('file_turnitin')) {
            $this->remove($bookEditor->file_turnitin);
        }

        // Update book editor
        $bookEditor->update($data);

        return redirect()->back()->with('success', 'File editor dan Turnitin berhasil diunggah dan menunggu persetujuan admin.');
    }

    /**
     * Update file approval status.
     */
    public function updateFileApproval(Request $request, string $id)
    {
        $request->validate([
            'file_status' => 'required|in:pending,approved,rejected,revision',
            'revision_notes' => 'nullable|string|max:1000',
        ]);

        $bookEditor = BookEditor::findOrFail($id);

        // Only admin can approve/reject files
        if (! auth()->user()->hasRole('admin')) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk melakukan tindakan ini.');
        }

        $bookEditor->update([
            'file_status' => $request->file_status,
            'revision_notes' => $request->revision_notes,
            'file_reviewed_at' => now(),
        ]);

        $message = match ($request->file_status) {
            'approved' => 'File berhasil disetujui.',
            'rejected' => 'File ditolak.',
            'revision' => 'File perlu revisi.',
            default => 'Status file diperbarui.'
        };

        return redirect()->back()->with('success', $message);
    }
}
