<?php

namespace App\Http\Controllers;

use App\Http\Requests\Editor\ReviewTaskEditorRequest;
use App\Models\BookEditor;
use Illuminate\Http\Request;

class AdminFileReviewController extends Controller
{
    /**
     * Display a listing of file submissions for review.
     */
    public function index(Request $request)
    {
        $fileSubmissions = BookEditor::with(['book', 'user'])
            ->whereNotNull('file_submitted_at')
            ->when($request->file_status, function ($query, $status) {
                return $query->where('file_status', $status);
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
                return $query->whereDate('file_submitted_at', $date);
            })
            ->latest('file_submitted_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.book-editor.file-reviews', compact('fileSubmissions'));
    }

    /**
     * Show the form for reviewing a file submission.
     */
    public function edit(string $id)
    {
        $fileSubmission = BookEditor::with(['book', 'user'])->findOrFail($id);

        return view('admin.pages.book-editor.file-review-detail', compact('fileSubmission'));
    }

    /**
     * Update the review status and notes for a file submission.
     */
    public function update(ReviewTaskEditorRequest $request, string $id)
    {
        $request->validated();

        $fileSubmission = BookEditor::findOrFail($id);

        // Handle file upload for revisi
        $fileRevisiPath = $fileSubmission->file_revisi_path;
        if ($request->hasFile('file_revisi')) {
            // Delete old file if exists
            if ($fileRevisiPath && file_exists(public_path('storage/'.$fileRevisiPath))) {
                unlink(public_path('storage/'.$fileRevisiPath));
            }

            // Store new file
            $file = $request->file('file_revisi');
            $filename = 'revisi_'.time().'_'.$file->getClientOriginalName();
            $fileRevisiPath = $file->storeAs('book-editor/revisi', $filename, 'public');
        }

        // Update the submission
        $fileSubmission->update([
            'file_status' => $request->file_status,
            'revision_notes' => $request->revision_notes ?? null,
            'file_revisi_path' => $fileRevisiPath,
            'file_reviewed_at' => now(),
            'file_reviewed_by' => auth()->id(),
        ]);

        return redirect()->route('admin.book-editor.file-reviews')
            ->with('success', 'Status file berhasil diupdate.');
    }

    /**
     * Download file revisi dari admin untuk editor.
     */
    public function downloadFileRevisi(string $id)
    {
        $fileSubmission = BookEditor::findOrFail($id);

        if (! $fileSubmission->file_revisi_path) {
            return redirect()->back()->with('error', 'File revisi tidak tersedia.');
        }

        $filePath = public_path('storage/'.$fileSubmission->file_revisi_path);

        if (! file_exists($filePath)) {
            return redirect()->back()->with('error', 'File revisi tidak ditemukan di server.');
        }

        return response()->download($filePath, basename($fileSubmission->file_revisi_path));
    }
}
