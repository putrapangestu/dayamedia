<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Http\Requests\Master\Module\CreateModuleRequest;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Module;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Traits\UploadTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ModuleController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateModuleRequest $request)
    {
        $data = $request->validated();

        if ($request->title) {
            $data['slug'] = str_replace(' ', '-', strtolower($data['title']));

            $moduleCount = Module::where('slug', $data['slug'])->first();
            if ($moduleCount) {
                $data['slug'] .= '-'.date('dmYHis');
            }
        }

        $book = Book::find($request->book_id);

        if ($book?->status != 'open') {
            return redirect()->back()->with('error', 'Tidak bisa menambahkan modul, karena buku ini tidak dalam status open');
        }

        $module = Module::create($data);

        return redirect()->route('admin.book.show', $module->book_id)->with('success', 'Modul berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $module = Module::with('book')->findOrFail($id);
        $users = User::role('member')->get();

        return view('admin.pages.module.edit', compact('module', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CreateModuleRequest $request, string $id)
    {
        // Find Module by ID
        $module = Module::findOrFail($id);

        // Validate Request
        $data = $request->validated();

        if ($request->title) {
            $data['slug'] = str_replace(' ', '-', strtolower($data['title']));

            $moduleCount = Module::where('slug', $data['slug'])->first();
            if ($moduleCount) {
                $data['slug'] .= '-'.date('dmYHis');
            }
        }

        if ($request->hasFile('file')) {
            $data['file_path'] = $this->upload('module/'.$module->id.'/file', $request->file('file'));
        }

        if ($request->hasFile('turnitin_file')) {
            $data['file_path_turnitin'] = $this->upload('module/'.$module->id.'/turnitin-file', $request->file('turnitin_file'));
        }

        DB::beginTransaction();
        try {
            $checkUpdate = false;
            if ($request->user_id && ! $request->deadline) {
                $module->update($data);
                $checkUpdate = true;

                $countModuleDontHaveAuthor = Module::where('book_id', $module->book_id)
                    ->where('user_id', null)
                    ->get();

                BookAuthor::where('module_id', $id)->delete();

                BookAuthor::create([
                    'module_id' => $id,
                    'user_id' => $request->user_id,
                    'book_id' => $module->book_id,
                ]);

                if (($countModuleDontHaveAuthor->count() - 1) <= 0) {
                    // $payloadUpdateModule['deadline'] = Carbon::now()->addDays($module->days);

                    $book = Book::with('modules')->where('id', $module->book_id)->first();

                    if ($book) {
                        // $transactionDetail = TransactionDetail::with('transaction')->whereRelation('transaction', 'status', 'paid')->whereIn('module_id', $moduleId)->get();
                        $bookAuthors = BookAuthor::where('book_id', $module->book_id)->get();

                        foreach ($bookAuthors as $item) {
                            $checkModule = Module::find($item->module_id);
                            if ($checkModule) {
                                $payloadUpdateModule = [
                                    'user_id' => $item->user_id,
                                ];
                                if (! $module->deadline) {
                                    $payloadUpdateModule['deadline'] = Carbon::now()->addDays($checkModule->days);
                                }
                                $checkModule->update($payloadUpdateModule);
                            }
                        }

                        $book->update([
                            'status' => Book::STATUS_EDITING,
                        ]);
                    }
                }
            }

            if (! $checkUpdate) {
                $module->update($data);
                $author = BookAuthor::where('module_id', $id)->first();
                if ($author?->user_id && isset($data['user_id'])) {
                    $author->update(['user_id' => $data['user_id']]);
                } elseif ($author?->user_id && ! $data['user_id']) {
                    $author->delete();
                    $module->update(['user_id' => null]);
                }
            }
            DB::commit();

            return redirect()->route('admin.book.show', $module->book_id)->with('success', 'Modul berhasil diupdate');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find Module by ID
        $module = Module::findOrFail($id);

        // Delete Module
        // BookAuthor::where('module_id', $id)->delete();
        $module->delete();

        return redirect()->route('admin.book.show', $module->book_id)->with('success', 'Modul berhasil dihapus');
    }

    public function downloadFile(Request $request, string $id)
    {
        $module = Module::findOrFail($id);

        if ($request->type == 'turnitin') {
            $relativePath = $module->file_path_turnitin;
        } else {
            $relativePath = $module->file_path;
        }

        if (! Storage::exists($relativePath)) {
            abort(404);
        }

        return Storage::download($relativePath);
    }
}
