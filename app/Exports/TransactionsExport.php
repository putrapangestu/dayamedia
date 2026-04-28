<?php

namespace App\Exports;

use App\Models\Transaction;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TransactionsExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $status;

    protected $startDate;

    protected $endDate;

    public function __construct($status = null, $startDate = null, $endDate = null)
    {
        $this->status = $status;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function query()
    {
        return Transaction::with(['user', 'details.module.book'])
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->startDate && $this->endDate, function ($query) {
                return $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
            })
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'Customer',
            'Email',
            'Total Amount',
            'Status',
            'Metode Pembayaran',
            'Produk',
            'Jumlah Item',
            'Catatan',
        ];
    }

    public function map($transaction): array
    {
        $products = $transaction->details->map(function ($detail) {
            $productName = '';
            if ($detail->module) {
                $productName = $detail->module->title.' ('.$detail->module->book->title.')';
            } elseif ($detail->book) {
                $productName = $detail->book->title;
            }

            return $productName;
        })->implode(', ');

        return [
            $transaction->code,
            $transaction->created_at->format('d/m/Y H:i'),
            $transaction->user->full_name,
            $transaction->user->email,
            'Rp. '.number_format($transaction->total_amount, 0, ',', '.'),
            ucfirst($transaction->status),
            ucfirst($transaction->payment_method ?? '-'),
            $products,
            $transaction->details->count(),
            $transaction->note ?? '-',
        ];
    }
}
