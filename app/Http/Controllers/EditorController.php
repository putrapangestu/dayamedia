<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\Editor\CreateEditorRequest;
use App\Http\Requests\Master\Editor\UpdateEditorRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EditorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::role('editor')
            ->with('bookEditors')
            ->when($request->search, function ($query) use ($request) {
                $query->where('full_name', 'like', '%'.$request->search.'%');
            })
            ->when($request->status == 'active', function ($query) {
                $query->whereNotNull('email_verified_at');
            })
            ->when($request->status == 'inactive', function ($query) {
                $query->whereNull('email_verified_at');
            })
            ->when($request->affiliate_level_id, function ($query) use ($request) {
                $query->where('affiliate_level_id', $request->affiliate_level_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.editor.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.editor.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateEditorRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'),
            'phone_number' => $validated['phone_number'] ?? null,
            'referral_code' => Str::random(10),
        ]);

        $user->assignRole('editor');

        return redirect()->route('admin.editor.index')->with('success', 'Editor berhasil ditambahkan.');
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
    public function edit(User $editor)
    {
        return view('admin.pages.editor.edit', compact('editor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEditorRequest $request, string $id)
    {
        $validated = $request->validated();

        $user = User::findOrFail($id);
        $user->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'] ?? null,
        ]);

        return redirect()->route('admin.editor.index')->with('success', 'Editor berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.editor.index')->with('success', 'Editor berhasil dihapus.');
    }
}
