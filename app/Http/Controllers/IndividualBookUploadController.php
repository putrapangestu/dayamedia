<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\Module;
use App\Models\Transaction;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IndividualBookUploadController extends Controller
{
    use UploadTrait;

    public function showUploadForm(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->individual_book_status !== 'confirmed') {
            abort(403);
        }

        $categories = Category::orderBy('name')->get();

        $transaction->load('details');
        $book = $transaction->details->first()?->book?->load('modules', 'authors');

        $modules = $book?->modules->first() ?? null;
        $authors = $book?->authors->count() > 0 ? $book?->authors->where('user_id', null)->sortBy('created_at')->values()->toArray() : [];

        return view('landing.pages.individual-books.upload', compact('transaction', 'categories', 'book', 'modules', 'authors'));
    }

    public function submitUpload(Request $request, Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        if ($transaction->individual_book_status !== 'confirmed') {
            abort(403);
        }

        $transactionDetail = $transaction->details->first();

        $module = $transactionDetail?->book?->modules()->first();

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'full_content' => [$module?->file_path ? 'nullable' : 'required', 'file', 'mimes:pdf,doc,docx', 'max:10240'],
            'turnitin_file' => 'nullable|file|mimes:pdf|max:5120',
            'additional_authors' => 'nullable|array',
            'additional_authors.*' => 'nullable|string|max:255',
        ]);

        $fullContentPath = $request->file('full_content') ? $this->upload('individual-books/content', $request->file('full_content')) : null;
        $turnitinPath = $request->file('turnitin_file') ? $this->upload('individual-books/turnitin', $request->file('turnitin_file')) : null;

        DB::beginTransaction();
        try {
            if (! $transactionDetail->book_id) {
                $book = Book::create([
                    'title' => $request->title,
                    'slug' => Str::slug($request->title).'-'.Str::random(6),
                    'description' => $request->description,
                    // 'full_content' => $fullContentPath,
                    'status' => Book::STATUS_EDITING,
                    'category_id' => $request->category_id,
                    'is_individual' => true,
                ]);

                $module = Module::create([
                    'book_id' => $book->id,
                    'title' => $book->title,
                    'slug' => Str::slug('Module 1 - '.$book->title).'-'.Str::random(6),
                    'chapter' => 1,
                    'user_id' => auth()->id(),
                    'price' => 0,
                    'file_path' => $fullContentPath,
                    'file_path_turnitin' => $turnitinPath,
                ]);

                BookAuthor::create([
                    'book_id' => $book->id,
                    'module_id' => $module->id,
                    'user_id' => auth()->id(),
                    'author' => auth()->user()->full_name,
                ]);

                if ($request->has('additional_authors')) {
                    foreach ($request->additional_authors as $authorName) {
                        if (! $authorName) {
                            continue;
                        }
                        BookAuthor::create([
                            'book_id' => $book->id,
                            'module_id' => $module->id,
                            'user_id' => null,
                            'author' => $authorName,
                        ]);
                    }
                }

                $transaction->load('details');

                // Update transaction details book_id
                foreach ($transaction->details as $transactionDetail) {
                    $transactionDetail->book_id = $book->id;
                    $transactionDetail->save();
                }
            } else {
                $book = Book::find($transactionDetail->book_id);

                if ($book?->status === Book::STATUS_PUBLISHED) {
                    throw new \Exception('Buku sudah dipublikasikan, tidak dapat diupload lagi');
                }

                if ($book) {
                    $book->title = $request->title;
                    $book->description = $request->description;
                    $book->category_id = $request->category_id;
                    $book->slug = Str::slug($request->title).'-'.Str::random(6);
                    $book->save();

                    $module = $book->modules->first();

                    if ($module) {
                        $module->title = $book->title;
                        $module->slug = Str::slug('Module 1 - '.$book->title).'-'.Str::random(6);
                        $module->file_path = $fullContentPath ?? $module->file_path;
                        $module->file_path_turnitin = $turnitinPath ?? $module->file_path_turnitin;
                        $module->save();
                    }

                    $submittedAuthors = collect($request->input('additional_authors', []))
                        ->map(fn ($authorName) => trim((string) $authorName))
                        ->filter()
                        ->values();

                    $existingAuthors = $book->authors()
                        ->whereNull('user_id')
                        ->orderBy('created_at')
                        ->get()
                        ->values();

                    foreach ($submittedAuthors as $key => $authorName) {
                        $authorItem = $existingAuthors->get($key);

                        if ($authorItem) {
                            $authorItem->update(['author' => $authorName]);
                        } else {
                            BookAuthor::create([
                                'book_id' => $book->id,
                                'module_id' => $module->id,
                                'user_id' => null,
                                'author' => $authorName,
                            ]);
                        }
                    }

                    $existingAuthors->slice($submittedAuthors->count())->each->delete();
                }
            }

            DB::commit();

            return redirect()->route('member')->with('success', 'Buku berhasil diunggah dan masuk proses editorial');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
