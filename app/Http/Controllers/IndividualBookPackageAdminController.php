<?php

namespace App\Http\Controllers;

use App\Models\IndividualBookPackage;
use App\Models\IndividualBookPackageBenefit;
use Illuminate\Http\Request;

class IndividualBookPackageAdminController extends Controller
{
    public function index(Request $request)
    {
        $q = IndividualBookPackage::query();
        if ($request->filled('name')) {
            $q->where('name', 'like', '%'.$request->name.'%');
        }
        if ($request->filled('status')) {
            $q->where('status', $request->status);
        }
        $packages = $q->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pages.individual-book-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.pages.individual-book-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'max_authors_default' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'benefit_name' => 'array',
            'benefit_name.*' => 'nullable|string|max:255',
            'benefit_value' => 'array',
            'benefit_value.*' => 'nullable|string|max:255',
            'benefit_order' => 'array',
            'benefit_order.*' => 'nullable|integer|min:0',
        ]);

        $package = IndividualBookPackage::create([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'] ?? null,
            'max_authors_default' => $data['max_authors_default'],
            'status' => $data['status'],
        ]);

        $names = $data['benefit_name'] ?? [];
        $values = $data['benefit_value'] ?? [];
        $orders = $data['benefit_order'] ?? [];
        foreach ($names as $i => $name) {
            if (! $name) {
                continue;
            }
            IndividualBookPackageBenefit::create([
                'package_id' => $package->id,
                'benefit_name' => $name,
                'benefit_value' => $values[$i] ?? null,
                'sort_order' => (int) ($orders[$i] ?? 0),
            ]);
        }

        return redirect()->route('admin.individual-book-packages.index')->with('success', 'Paket berhasil dibuat');
    }

    public function edit(IndividualBookPackage $individual_book_package)
    {
        $package = $individual_book_package->load(['benefits' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('admin.pages.individual-book-packages.edit', compact('package'));
    }

    public function update(Request $request, IndividualBookPackage $individual_book_package)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'max_authors_default' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
            'benefit_name' => 'array',
            'benefit_name.*' => 'nullable|string|max:255',
            'benefit_value' => 'array',
            'benefit_value.*' => 'nullable|string|max:255',
            'benefit_order' => 'array',
            'benefit_order.*' => 'nullable|integer|min:0',
        ]);

        $individual_book_package->update([
            'name' => $data['name'],
            'price' => $data['price'],
            'description' => $data['description'] ?? null,
            'max_authors_default' => $data['max_authors_default'],
            'status' => $data['status'],
        ]);

        $individual_book_package->benefits()->delete();
        $names = $data['benefit_name'] ?? [];
        $values = $data['benefit_value'] ?? [];
        $orders = $data['benefit_order'] ?? [];
        foreach ($names as $i => $name) {
            if (! $name) {
                continue;
            }
            IndividualBookPackageBenefit::create([
                'package_id' => $individual_book_package->id,
                'benefit_name' => $name,
                'benefit_value' => $values[$i] ?? null,
                'sort_order' => (int) ($orders[$i] ?? 0),
            ]);
        }

        return redirect()->route('admin.individual-book-packages.index')->with('success', 'Paket berhasil diperbarui');
    }

    public function destroy(IndividualBookPackage $individual_book_package)
    {
        $individual_book_package->benefits()->delete();
        $individual_book_package->authorAddons()->delete();
        $individual_book_package->delete();

        return redirect()->route('admin.individual-book-packages.index')->with('success', 'Paket berhasil dihapus');
    }
}
