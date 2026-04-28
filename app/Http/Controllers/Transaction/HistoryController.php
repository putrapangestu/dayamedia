<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Models\CommissionHistory;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    public function indexRoyalti(Request $request)
    {
        $histories = CommissionHistory::with('user.affiliateLevel', 'transaction.user')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('full_name', 'like', '%' . $request->search . '%');
                })->orWhereHas('transaction', function ($q) use ($request) {
                    $q->where('transaction_code', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->type, function ($query) use ($request) {
                $query->where('type', $request->type);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.affiliate.index')->with('histories', $histories);
    }
}
