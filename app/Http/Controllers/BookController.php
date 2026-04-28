<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\Book\CreateBookRequest;
use App\Http\Requests\Master\Book\UpdateBookRequest;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Category;
use App\Models\Module;
use App\Models\User;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Find all Books
        $books = Book::query();

        // Filter by Category
        if ($request->has('category_id') && $request->input('category_id') != '') {
            $books = $books->where('category_id', $request->input('category_id'));
        }

        // Filter by Status
        if ($request->has('status') && $request->input('status') != '') {
            $books = $books->where('status', $request->input('status'));
        }

        // Filter by Date
        if ($request->has('date') && $request->input('date') != '') {
            $books = $books->whereDate('created_at', $request->input('date'));
        }

        // Filter by Search
        if ($request->name && $request->name != '') {
            $books = $books->where(function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->name.'%')
                    ->orWhere('code_isbn', 'like', '%'.$request->name.'%');
            });
        }

        // Paginate Results
        $books = $books->with('category')->latest()->paginate(10)->withQueryString();

        // Get categories for filter
        $categories = Category::orderBy('name', 'asc')->get();

        return view('admin.pages.book.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $authors = User::role('member')->get();
        $categories = Category::all();

        return view('admin.pages.book.create', compact('categories', 'authors', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateBookRequest $request)
    {
        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            $validated['cover'] = $this->upload('book/cover', $request->file('cover'));
        }

        if ($request->hasFile('full_content')) {
            $validated['full_content'] = $this->upload('book/full_content', $request->file('full_content'));
        }

        if ($request->hasFile('half_content')) {
            $validated['half_content'] = $this->upload('book/half_content', $request->file('half_content'));
        }

        if ($request->title) {
            $validated['slug'] = str_replace(' ', '-', strtolower($request->title));

            $bookCount = Book::where('slug', $validated['slug'])->count();
            if ($bookCount > 0) {
                $validated['slug'] .= '-'.$bookCount;
            }
        }

        DB::beginTransaction();
        try {
            // Create Book
            $book = Book::create($validated);
            // Attach Authors
            if (isset($validated['author'])) {
                foreach ($validated['author'] as $author) {
                    BookAuthor::create([
                        'book_id' => $book->id,
                        'user_id' => $author,
                    ]);
                }
            }

            DB::commit();

            // Redirect to Book Index
            return redirect()->route('admin.book.index')->with('success', 'Buku berhasil ditambahkan.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal menambahkan buku => '.$th->getMessage())->withInput($request->all());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find Book by ID
        $book = Book::with('authors.user', 'authors.module', 'category', 'modules', 'bookEditors.user')->findOrFail($id);

        $modules = Module::with('user')->where('book_id', $id)->paginate(10);

        $authors = [];
        $loop = 0;
        foreach ($book->authors as $author) {
            $authors[$loop]['name'] = $author->user->full_name ?? $author->author;
            $authors[$loop]['email'] = $author->user?->email ?? null;
            $authors[$loop]['phone_number'] = $author->user?->phone_number ?? null;
            $authors[$loop]['chapter'] = $author->module?->chapter ?? null;
            $authors[$loop]['title'] = $author->module?->title ?? null;
            $authors[$loop]['created_at'] = $author->created_at;
            $authors[$loop]['updated_at'] = $author->updated_at;
            $loop++;
        }

        $authors = collect($authors)->sort(function ($a, $b) {
            if ($a['chapter'] != $b['chapter']) {
                return $a['chapter'] <=> $b['chapter'];
            }
            return strtotime($a['created_at']) <=> strtotime($b['created_at']);
        })->values();

        return view('admin.pages.book.show', compact('book', 'modules', 'authors'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Find Book by ID
        $book = Book::with('authors.user', 'authors.module')->findOrFail($id);
        $bookAuthorIds = $book->authors->pluck('user_id')->filter()->toArray();
        $authors = User::role('member')
            ->orWhereIn('id', $bookAuthorIds)
            ->get();

        $categories = Category::all();

        $authorSelecteds = $book->authors->map(function ($author) {
            return [
                'id' => $author->user_id,
                'name' => $author->user->full_name ?? $author->author,
                'chapter' => $author->module?->chapter ?? null,
                'created_at' => $author->created_at,
            ];
        })->sortBy([
            ['chapter', 'asc'],
            ['created_at', 'asc'],
        ])->values();

        return view('admin.pages.book.edit', compact('book', 'categories', 'authors', 'authorSelecteds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookRequest $request, string $id)
    {
        // Find Book by ID
        $book = Book::with('authors')->findOrFail($id);

        // Validate Request
        $validated = $request->validated();

        if ($request->hasFile('cover')) {
            // Delete old cover if exists
            if ($book->cover) {
                $this->remove($book->cover);
            }
            $validated['cover'] = $this->upload('book/cover', $request->file('cover'));
        }

        if ($request->hasFile('full_content')) {
            // Delete old full_content if exists
            if ($book->full_content) {
                $this->remove($book->full_content);
            }
            $validated['full_content'] = $this->upload('book/full_content', $request->file('full_content'));
        }

        if ($request->hasFile('half_content')) {
            // Delete old half_content if exists
            if ($book->half_content) {
                $this->remove($book->half_content);
            }
            $validated['half_content'] = $this->upload('book/half_content', $request->file('half_content'));
        }

        if ($book->title) {
            $validated['slug'] = str_replace(' ', '-', strtolower($validated['title']));

            $bookCount = Book::where('slug', $validated['slug'])->where('id', '!=', $book->id)->count();
            if ($bookCount > 0) {
                $validated['slug'] .= '-'.$bookCount;
            }
        }

        if (!$book->is_individual) {
            $validatedAuthors = $validated['author'] ?? [];
            foreach ($book->authors as $author) {
                if (! in_array($author->user_id, $validatedAuthors)) {
                    $author->delete();
                } else {
                    $validatedAuthors = array_diff($validatedAuthors, [$author->user_id]);
                }
            }
            $validated['author'] = $validatedAuthors;
        }

        DB::beginTransaction();
        try {
            // Update Book
            $book->update($validated);

            // Attach Authors if not individual
            if (!$book->is_individual && isset($validated['author'])) {
                foreach ($validated['author'] as $author) {
                    BookAuthor::create([
                        'book_id' => $book->id,
                        'user_id' => $author,
                    ]);
                }
            }

            DB::commit();

            // Redirect to Book Index
            return redirect()->route('admin.book.index')->with('success', 'Buku berhasil diupdate.');
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal mengupdate buku => '.$th->getMessage())->withInput($request->all());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find Book by ID
        $book = Book::with('authors')->findOrFail($id);

        // Delete old cover if exists
        if ($book->cover) {
            $this->remove($book->cover);
        }

        // Delete old full_content if exists
        if ($book->full_content) {
            $this->remove($book->full_content);
        }

        // Delete old half_content if exists
        if ($book->half_content) {
            $this->remove($book->half_content);
        }

        // Delete Book Authors
        foreach ($book->authors as $author) {
            $author->delete();
        }

        // Delete Book
        $book->delete();

        // Redirect to Book Index
        return redirect()->route('admin.book.index')->with('success', 'Buku berhasil dihapus.');
    }
}
