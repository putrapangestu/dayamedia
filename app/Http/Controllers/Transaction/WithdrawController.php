<?php

namespace App\Http\Controllers\Transaction;

use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\Withdraw\CreateWithdrawRequest;
use App\Http\Requests\Transaction\Withdraw\UpdateWithdrawRequest;
use App\Models\Withdraw;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WithdrawController extends Controller
{
    use UploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $withdrawls = Withdraw::with('user')
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where(function ($q) use ($request) {
                    $q->whereHas('user', function ($q) use ($request) {
                        $q->where('full_name', 'like', '%' . $request->search . '%')
                            ->orWhere('email', 'like', '%' . $request->search . '%');
                    })
                        ->orWhere('account_number', 'like', '%' . $request->search . '%')
                        ->orWhere('bank', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->start_date, function ($query) use ($request) {
                $query->whereDate('created_at', '>=', $request->start_date);
            })
            ->when($request->end_date, function ($query) use ($request) {
                $query->whereDate('created_at', '<=', $request->end_date);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.pages.withdrawl.index', compact('withdrawls'));
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
    public function store(CreateWithdrawRequest $request)
    {
        $data = $request->validated();
        $user = auth()->user();

        // Check minimum withdrawal amount
        $minWithdrawal = getMinWithdrawal();
        if ($data['amount'] < $minWithdrawal) {
            return redirect()->back()->with('error', 'Jumlah penarikan minimal Rp ' . number_format($minWithdrawal, 0, ',', '.'));
        }

        // Calculate admin fee (nominal)
        $adminFee = getAdminFeeWithdrawal();

        $totalDeduction = $data['amount'] + $adminFee;

        if ($user->balance < $totalDeduction) {
            return redirect()->back()->with('error', 'Saldo tidak mencukupi untuk melakukan penarikan beserta biaya admin (Total: Rp ' . number_format($totalDeduction, 0, ',', '.') . ')');
        }

        $netAmount = $data['amount'];

        $data['user_id'] = $user->id;
        $data['admin_fee'] = $adminFee;
        $data['net_amount'] = $netAmount;
        $data['amount'] = $totalDeduction;

        Withdraw::create($data);

        return redirect()->back()->with('success', 'Penarikan berhasil diajukan. Biaya admin: Rp ' . number_format($adminFee, 0, ',', '.'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWithdrawRequest $request, string $id)
    {
        $data = $request->validated();

        $withdraw = Withdraw::with('user')->findOrFail($id);
        $user = auth()->user();

        DB::beginTransaction();
        try {
            if (isset($data['proof'])) {
                $data['proof'] = $this->upload('withdraw', $data['proof']);
            }

            $data['approved_by'] = $user->id;

            $withdraw->update($data);

            if ($withdraw->status == 'accepted') {
                $withdraw->user->update([
                    'balance' => $withdraw->user->balance - $withdraw->amount,
                ]);
            }

            DB::commit();

            return redirect()->back()->with('success', 'Penarikan berhasil diupdate');
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
        $withdraw = Withdraw::findOrFail($id);
        $withdraw->delete();

        return redirect()->back()->with('success', 'Penarikan berhasil dihapus');
    }
}
