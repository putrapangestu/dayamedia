<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboardAdmin(Request $request)
    {
        $userCount = User::count();
        $bookCount = Book::where('status', Book::STATUS_PUBLISHED)->count();
        $transactionCount = Transaction::where('status', 'pending')->count();
        $withdrawCount = Withdraw::where('status', 'pending')->count();

        $books = Book::with('authors', 'category')
            ->whereRelation('authors', 'user_id', null)
            ->orderBy('created_at', 'asc')
            ->limit(5)
            ->get();

        // Filter selection (default: monthly with current month & year)
        $filterType = $request->input('filter_type', 'monthly');
        $selectedYear = $request->input('year', date('Y'));
        $selectedMonth = $request->input('month', date('n'));

        // Total Omset mengikuti filter
        $transactionSummary = Transaction::where('status', 'paid')
            ->when($filterType === 'monthly', function ($q) use ($selectedYear, $selectedMonth) {
                $q->whereYear('created_at', $selectedYear)
                    ->whereMonth('created_at', $selectedMonth);
            }, function ($q) use ($selectedYear) {
                $q->whereYear('created_at', $selectedYear);
            })
            ->sum('total_price');

        $now = Carbon::create($selectedYear, $selectedMonth, 1);
        $detailBaseQuery = TransactionDetail::query()
            ->whereHas('transaction', function ($q) use ($filterType, $selectedYear, $selectedMonth) {
                $q->where('status', 'paid');
                if ($filterType === 'monthly') {
                    $q->whereYear('created_at', $selectedYear)
                        ->whereMonth('created_at', $selectedMonth);
                } else {
                    $q->whereYear('created_at', $selectedYear);
                }
            });

        $revenueIndividualMonth = Transaction::whereNotNull('individual_book_confirmed_at')
            ->selectRaw('COALESCE(SUM((total_price - COALESCE(admin_fee, 0)) - COALESCE(discount_amount, 0)), 0) as total')
            ->value('total');

        $revenueCollaborationMonth = (clone $detailBaseQuery)
            ->whereNotNull('module_id')
            ->whereRelation('transaction', 'individual_book_confirmed_at', null)
            ->selectRaw('COALESCE(SUM((price_book - COALESCE(price_discount, 0)) * quantity), 0) as total')
            ->value('total');

        $revenueEbookMonth = (clone $detailBaseQuery)
            ->where('type', 'digital')
            ->whereRelation('transaction', 'individual_book_confirmed_at', null)
            ->selectRaw('COALESCE(SUM((price_book - COALESCE(price_discount, 0)) * quantity), 0) as total')
            ->value('total');

        $revenuePhysicalMonth = (clone $detailBaseQuery)
            ->where('type', 'physical')
            ->whereRelation('transaction', 'individual_book_confirmed_at', null)
            ->selectRaw('COALESCE(SUM((price_book - COALESCE(price_discount, 0)) * quantity), 0) as total')
            ->value('total');

        $salaryData = [];
        $salaryLabels = [];

        if ($filterType == 'monthly') {
            // Data per hari dalam bulan yang dipilih
            // $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $selectedMonth, $selectedYear);
            $daysInMonth = Carbon::create($selectedYear, $selectedMonth, 1)->daysInMonth();

            $dailyTransactions = Transaction::selectRaw('DAY(created_at) as day, SUM(total_price) as total')
                ->where('status', 'paid')
                ->whereYear('created_at', $selectedYear)
                ->whereMonth('created_at', $selectedMonth)
                ->groupBy('day')
                ->get();

            for ($day = 1; $day <= $daysInMonth; $day++) {
                $transaction = $dailyTransactions->firstWhere('day', $day);
                $salaryData[] = $transaction ? (int) $transaction->total : 0;
                $salaryLabels[] = [(string) $day];
            }
        } else {
            // Data per bulan dalam tahun yang dipilih (Default)
            $monthlyTransactions = Transaction::selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
                ->where('status', 'paid')
                ->whereYear('created_at', $selectedYear)
                ->groupBy('month')
                ->get();

            for ($month = 1; $month <= 12; $month++) {
                $monthName = date('M', mktime(0, 0, 0, $month, 1));
                $transaction = $monthlyTransactions->firstWhere('month', $month);
                $salaryData[] = $transaction ? (int) $transaction->total : 0;
                $salaryLabels[] = [$monthName];
            }
        }

        $currentHighlightIndex = -1;
        $today = Carbon::now();
        if ($filterType == 'monthly') {
            if ($selectedYear == $today->year && $selectedMonth == $today->month) {
                $currentHighlightIndex = $today->day - 1;
            }
        } else {
            if ($selectedYear == $today->year) {
                $currentHighlightIndex = $today->month - 1;
            }
        }

        return view(
            'admin.pages.home.index',
            compact(
                'userCount', 'bookCount',
                'transactionCount', 'withdrawCount',
                'books', 'transactionSummary',
                'salaryData', 'salaryLabels',
                'filterType', 'selectedYear', 'selectedMonth',
                'revenueIndividualMonth', 'revenueCollaborationMonth',
                'revenueEbookMonth', 'revenuePhysicalMonth',
                'currentHighlightIndex'
            )
        );
    }

    public function dashboardEditor(Request $request)
    {
        $user = auth()->user();

        // Stats
        $claimedBooksCount = \App\Models\BookEditor::where('user_id', $user->id)->count();
        $completedBooksCount = \App\Models\BookEditor::where('user_id', $user->id)
            ->where('status', \App\Models\BookEditor::STATUS_APPROVED)
            ->count();

        // Active Projects
        $activeProjects = \App\Models\BookEditor::with('book.category')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved']) // Assuming 'approved' means active working
            ->latest()
            ->limit(5)
            ->get();

        // Chart Data: Monthly Completed Edits in Current Year
        $selectedYear = date('Y');
        $monthlyCompleted = \App\Models\BookEditor::selectRaw('MONTH(updated_at) as month, COUNT(*) as total')
            ->where('user_id', $user->id)
            ->where('status', \App\Models\BookEditor::STATUS_APPROVED)
            ->whereYear('updated_at', $selectedYear)
            ->groupBy('month')
            ->get();

        $chartData = [];
        $chartLabels = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthName = date('M', mktime(0, 0, 0, $month, 1));
            $data = $monthlyCompleted->firstWhere('month', $month);
            $chartData[] = $data ? (int) $data->total : 0;
            $chartLabels[] = $monthName;
        }

        return view('admin.pages.editor.dashboard', compact(
            'claimedBooksCount', 'completedBooksCount',
            'activeProjects', 'chartData', 'chartLabels'
        ));
    }
}
