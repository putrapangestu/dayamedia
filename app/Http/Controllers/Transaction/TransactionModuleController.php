<?php

namespace App\Http\Controllers\Transaction;

use App\Helpers\Transaction\TransactionHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Transaction\VerificationTransaction;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\Module;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class TransactionModuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $transactions = Transaction::whereHas('details', function ($query) {
            $query->where('module_id', '!=', null);
        })->with(['user', 'details.module.book']);

        // Filter by transaction code
        if ($request->filled('transaction_code')) {
            $transactions->where('transaction_code', 'like', '%'.$request->transaction_code.'%');
        }

        // Filter by user name
        if ($request->filled('user_name')) {
            $transactions->whereHas('user', function ($query) use ($request) {
                $query->where('full_name', 'like', '%'.$request->user_name.'%');
            });
        }

        // Filter by status
        if ($request->status == 'waiting') {
            $transactions->where('status', 'pending')->whereNotNull('payment_proof');
        } elseif ($request->filled('status')) {
            $transactions->where('status', $request->status);
        }

        // Filter by date
        if ($request->filled('date')) {
            $transactions->whereDate('created_at', $request->date);
        }

        // Filter by date range
        if ($request->filled('start_date')) {
            $transactions->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $transactions->whereDate('created_at', '<=', $request->end_date);
        }

        // Filter by book name
        if ($request->filled('book_name')) {
            $transactions->whereHas('details.module.book', function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->book_name.'%');
            });
        }

        $transactions = $transactions->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.pages.order.bab-order', compact('transactions'));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['user', 'details.module.book'])->findOrFail($id);

        return view('admin.pages.order.bab-order-show', compact('transaction'));
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
    public function update(VerificationTransaction $request, string $id)
    {
        DB::beginTransaction();
        try {
            $transaction = Transaction::with('details.module', 'user')->findOrFail($id);
            $transaction->update($request->validated());
            $startDeadline = false;

            if ($request->status == 'paid') {
                $detail = $transaction->details->first();

                // add author
                BookAuthor::create([
                    'module_id' => $detail->module_id,
                    'user_id' => $transaction->user_id,
                    'book_id' => $detail->module->book_id,
                ]);

                // activate module
                $module = Module::where('id', $detail->module_id)->first();

                if (! $module) {
                    DB::rollBack();

                    return redirect()->route('admin.bab-order.index')->with('error', 'Module tidak ditemukan.');
                }

                // $payloadUpdateModule = [
                //     'user_id' => $transaction->user_id,
                // ];

                $countModuleDontHaveAuthor = Module::where('book_id', $module->book_id)
                    ->where('user_id', null)
                    ->get();

                if (($countModuleDontHaveAuthor->count() - 1) == 0) {
                    // $payloadUpdateModule['deadline'] = Carbon::now()->addDays($module->days);
                    $book = Book::with('modules')->where('id', $module->book_id)->first();

                    if ($book) {
                        $startDeadline = true;
                        // $transactionDetail = TransactionDetail::with('transaction')->whereRelation('transaction', 'status', 'paid')->whereIn('module_id', $moduleId)->get();

                        // foreach($transactionDetail as $item) {
                        //     $module = Module::find($item->module_id);
                        //     if($module) {
                        //         $module->update([
                        //             'deadline' => Carbon::now()->addDays($module->days),
                        //             'user_id' => $item->transaction->user_id,
                        //         ]);
                        //     }
                        // }

                        $bookAuthors = BookAuthor::where('book_id', $module->book_id)->get();
                        foreach ($bookAuthors as $item) {
                            $module = Module::find($item->module_id);
                            if ($module) {
                                $payloadUpdateModule = [
                                    'user_id' => $item->user_id,
                                ];
                                if (! $module->deadline) {
                                    $payloadUpdateModule['deadline'] = Carbon::now()->addDays($module->days);
                                }
                                $module->update($payloadUpdateModule);
                            }
                        }

                        $book->update([
                            'status' => Book::STATUS_EDITING,
                        ]);
                    }
                }

                if (! $startDeadline) {
                    $module->update([
                        'user_id' => $transaction->user_id,
                    ]);
                }

                // summary balance affiliator
                if ($transaction->user->use_referral_code) {
                    $affiliator = User::with('affiliateLevel')->whereHas('affiliateLevel')->where('referral_code', $transaction->user->use_referral_code)->first();
                    if ($affiliator) {
                        TransactionHelper::calculateCommissionAffiliate($affiliator, $transaction);
                    }
                }
            }

            DB::commit();
            DB::afterCommit(function () use ($transaction, $request) {
                $number = $transaction->user->phone_number;
                $email = $transaction->user->email;
                if ($request->status === 'paid') {
                    $msg = "Pembayaran untuk transaksi {$transaction->transaction_code} telah diverifikasi. Akses BAB tersedia.";
                    try {
                        whatsapp_send($number, $msg, 2);
                    } catch (\Exception $e) {
                        Log::error('WhatsApp send failed', [
                            'to' => $number,
                            'message' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }

                    try {
                        if ($email) {
                            Mail::raw($msg, function ($m) use ($email) {
                                $m->to($email)->subject('Pembayaran Diverifikasi');
                            });
                        }
                    } catch (\Exception $e) {
                        Log::error('Email send failed', [
                            'to' => $email,
                            'subject' => 'Pembayaran Diverifikasi',
                            'content' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                } elseif ($request->status === 'rejected') {
                    $msg = "Pembayaran untuk transaksi {$transaction->transaction_code} ditolak. Mohon upload ulang bukti pembayaran.";
                    try {
                        whatsapp_send($number, $msg, 2);
                    } catch (\Exception $e) {
                        Log::error('WhatsApp send failed', [
                            'to' => $number,
                            'message' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }

                    try {
                        if ($email) {
                            Mail::raw($msg, function ($m) use ($email) {
                                $m->to($email)->subject('Pembayaran Ditolak');
                            });
                        }
                    } catch (\Exception $e) {
                        Log::error('Email send failed', [
                            'to' => $email,
                            'subject' => 'Pembayaran Ditolak',
                            'content' => $msg,
                            'error' => $e->getMessage(),
                        ]);
                    }
                }
            });

            return redirect()->route('admin.bab-order.index')->with('success', 'Status transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('admin.bab-order.index')->with('error', 'Terjadi kesalahan: '.$e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
