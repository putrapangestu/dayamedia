<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\Promo\CreatePromoRequest;
use App\Http\Requests\Master\Promo\UpdatePromoRequest;
use App\Models\Book;
use App\Models\Promo;
use Illuminate\Http\Request;

class PromoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $promos = Promo::query()
            ->withCount('histories')
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->where('name', 'like', '%'.$request->input('search').'%')
                        ->orWhere('code', 'like', '%'.$request->input('search').'%');
                });
            })
            ->when($request->filled('status'), function ($query) use ($request) {
                $now = now();
                switch ($request->status) {
                    case 'active':
                        $query->where('start_date', '<=', $now)
                            ->where('end_date', '>=', $now)
                            ->where('quantity', '>', 0);
                        break;
                    case 'expired':
                        $query->where(function ($q) use ($now) {
                            $q->where('end_date', '<', $now)
                                ->orWhere('quantity', '<=', 0);
                        });
                        break;
                    case 'upcoming':
                        $query->where('start_date', '>', $now);
                        break;
                }
            })
            ->when($request->filled('start_date'), function ($query) use ($request) {
                $query->whereDate('start_date', '>=', $request->start_date);
            })
            ->when($request->filled('end_date'), function ($query) use ($request) {
                $query->whereDate('end_date', '<=', $request->end_date);
            })
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.promo.index', compact('promos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $books = Book::select('id', 'title')->orderBy('title')->get();

        return view('admin.pages.promo.create', compact('books'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreatePromoRequest $request)
    {
        $promo = Promo::create($request->validated());
        $bookIds = collect($request->input('book_ids', []))->filter()->unique()->values()->all();
        $promo->books()->sync($bookIds);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil ditambahkan.');
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
        $promo = Promo::with('books')->findOrFail($id);
        $books = Book::select('id', 'title')->orderBy('title')->get();

        return view('admin.pages.promo.edit', compact('promo', 'books'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePromoRequest $request, string $id)
    {
        $promo = Promo::findOrFail($id);
        $promo->update($request->validated());
        $bookIds = collect($request->input('book_ids', []))->filter()->unique()->values()->all();
        $promo->books()->sync($bookIds);

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promo = Promo::findOrFail($id);
        $promo->delete();

        return redirect()->route('admin.promo.index')->with('success', 'Promo berhasil dihapus.');
    }

    public function checkPromo(Request $request)
    {
        $promo = Promo::where('code', $request->input('code'))->first();

        if (! $promo) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code tidak valid.',
                'data' => null,
            ], 404);
        }

        if ($promo->start_date > now()) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code belum dimulai.',
                'data' => null,
            ], 404);
        }

        if ($promo->end_date < now()) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code sudah berakhir.',
                'data' => null,
            ], 404);
        }

        if ($promo->quantity == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Promo code sudah habis.',
                'data' => null,
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Promo code valid.',
            'data' => $promo,
        ], 200);
    }
}
