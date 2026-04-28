<?php

namespace App\Http\Controllers;

use App\Http\Requests\Master\Affiliate\CreateAffiliateRequest;
use App\Http\Requests\Master\Affiliate\UpdateAffiliateRequest;
use App\Models\AffiliateLevel;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class AffiliateOrderController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $affiliateOrders = AffiliateLevel::query();

        if ($request->has('search') && $request->search != '') {
            $affiliateOrders->where('name', 'like', '%'.$request->search.'%');
        }

        if ($request->has('status') && $request->status != '') {
            $affiliateOrders->where('status', $request->status);
        }

        $affiliateOrders = $affiliateOrders->paginate(10)->withQueryString();

        return view('admin.pages.affiliate-order.index', compact('affiliateOrders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.affiliate-order.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAffiliateRequest $request)
    {
        if ($request->hasFile('icon')) {
            $icon = $this->upload('affiliate-level/icon', $request->file('icon'));
        } else {
            $icon = null;
        }

        AffiliateLevel::create($request->validated() + ['icon' => $icon]);

        return redirect()->route('admin.affiliate-order.index')->with('success', 'Affiliate Order created successfully');
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
        $affiliateOrder = AffiliateLevel::findOrFail($id);

        return view('admin.pages.affiliate-order.edit', compact('affiliateOrder'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAffiliateRequest $request, string $id)
    {
        $affiliateOrder = AffiliateLevel::findOrFail($id);

        if ($request->hasFile('icon')) {
            // Delete old icon if exists
            if ($affiliateOrder->icon) {
                $this->remove($affiliateOrder->icon);
            }

            $icon = $this->upload('affiliate-level/icon', $request->file('icon'));
        } else {
            $icon = $affiliateOrder->icon;
        }

        $affiliateOrder->update($request->validated() + ['icon' => $icon]);

        return redirect()->route('admin.affiliate-order.index')->with('success', 'Affiliate Order updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $affiliateOrder = AffiliateLevel::findOrFail($id);

        // Delete icon if exists
        if ($affiliateOrder->icon) {
            $this->remove($affiliateOrder->icon);
        }

        $affiliateOrder->delete();

        return redirect()->route('admin.affiliate-order.index')->with('success', 'Affiliate Order deleted successfully');
    }
}
