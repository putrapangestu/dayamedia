<?php

namespace App\Http\Controllers;

use App\Models\AffiliateLevel;
use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\BookHistory;
use App\Models\Cart;
use App\Models\Category;
use App\Models\CommissionHistory;
use App\Models\Document;
use App\Models\IndividualBookPackage;
use App\Models\Module;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Withdraw;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LandingController extends Controller
{
    public function index(): View
    {
        $recommendations = Book::with('authors.user', 'category')
            ->where('status', Book::STATUS_PUBLISHED)
            ->inRandomOrder()
            ->limit(5)
            ->get();

        $books = Book::query()
            ->with('authors.user', 'category', 'modules')
            ->where('status', Book::STATUS_OPEN)
            ->where('is_individual', false)
            ->withCount(['modules as available_modules_count' => function ($q) {
                $q->availableForOrder();
            }])
            ->orderBy('available_modules_count', 'desc')
            ->limit(6)
            ->get();

        // Buku terbaru (published)
        $latestBooks = Book::with('authors.user', 'category')
            ->where('status', Book::STATUS_PUBLISHED)
            ->orderBy('year_published', 'desc')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        // Buku terlaris berdasarkan jumlah transaksi
        $bestSellingBooks = Book::with('authors.user', 'category')
            ->where('status', Book::STATUS_PUBLISHED)
            ->withCount(['transactionDetails as transaction_count' => function ($query) {
                $query->whereHas('transaction', function ($q) {
                    $q->where('status', 'paid');
                });
            }])
            ->orderBy('transaction_count', 'desc')
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $individualPackages = IndividualBookPackage::with(['benefits' => function ($q) {
            $q->orderBy('sort_order');
        }])
            ->where('status', 'active')
            ->get();

        return view('landing.pages.home.index', compact('recommendations', 'books', 'latestBooks', 'bestSellingBooks', 'individualPackages'));
    }

    public function catalog(Request $request): View
    {
        $books = Book::query()
            ->with('authors.user', 'category', 'bookEditors.user')
            ->where('status', Book::STATUS_PUBLISHED)
            ->when($request->category_id, function ($query) use ($request) {
                if (is_array($request->category_id)) {
                    $query->whereIn('category_id', $request->category_id);
                } else {
                    $query->where('category_id', $request->category_id);
                }
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search.'%');
            })
            ->when($request->sort, function ($query) use ($request) {
                switch ($request->sort) {
                    case 'latest':
                        // $query->orderBy('created_at', 'desc');
                        $query->orderBy('year_published', 'desc');
                        break;
                    case 'oldest':
                        // $query->orderBy('created_at', 'asc');
                        $query->orderBy('year_published', 'asc');
                        break;
                    case 'published_latest':
                        $query->orderBy('year_published', 'desc');
                        break;
                    case 'published_oldest':
                        $query->orderBy('year_published', 'asc');
                        break;
                    case 'price_low':
                        $query->orderBy('price_digital', 'asc');
                        break;
                    case 'price_high':
                        $query->orderBy('price_digital', 'desc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                }
            }, function ($query) {
                $query->orderBy('year_published', 'desc');
            })
            ->paginate(10)
            ->withQueryString();

        $categories = Category::orderBy('name', 'asc')->get();

        return view('landing.pages.book.index', compact('books', 'categories'));
    }

    public function bookDetail(string $slug): View
    {
        $book = Book::with('authors.user', 'authors.module', 'category', 'bookEditors.user')->where('slug', $slug)->firstOrFail();

        $books = Book::query()->where(['category_id' => $book->category_id, 'status' => Book::STATUS_PUBLISHED, ['id', '!=', $book->id]])->limit(6)->get();
        $hasPurchased = auth()->check()
            ? Transaction::where('user_id', auth()->id())
                ->where('status', 'paid')
                ->whereHas('details', function ($query) use ($book) {
                    $query->where('book_id', $book->id);
                })
                ->exists()
            : false;

        $authors = [];
        $loop = 0;
        foreach ($book->authors as $author) {
            $authors[$loop]['name'] = $author->user->full_name ?? $author->author;
            $authors[$loop]['chapter'] = $author->module?->chapter ?? null;
            $authors[$loop]['created_at'] = $author->created_at;
            $authors[$loop]['updated_at'] = $author->updated_at;
            $loop++;
        }

        $authors = collect($authors)->sort(function ($a, $b) {
            if ($a['chapter'] != $b['chapter']) {
                return $a['chapter'] <=> $b['chapter'];
            }

            return strtotime($a['created_at']) <=> strtotime($b['created_at']);
        })->values();

        return view('landing.pages.book.detail', compact('book', 'books', 'authors', 'hasPurchased'));
    }

    public function collaboration(Request $request): View
    {
        $books = Book::query()
            ->with('authors.user', 'category', 'modules')
            ->whereIn('status', [Book::STATUS_OPEN, Book::STATUS_EDITING])
            ->where('is_individual', false)
            ->withCount(['modules as available_modules_count' => function ($q) {
                $q->availableForOrder();
            }])
            ->when($request->category_id, function ($query) use ($request) {
                if (is_array($request->category_id)) {
                    $query->whereIn('category_id', $request->category_id);
                } else {
                    $query->where('category_id', $request->category_id);
                }
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('title', 'like', '%'.$request->search.'%');
            })
            ->when($request->sort, function ($query) use ($request) {
                switch ($request->sort) {
                    case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;
                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                    case 'price_low':
                        $query->orderBy('price_digital', 'asc');
                        break;
                    case 'price_high':
                        $query->orderBy('price_digital', 'desc');
                        break;
                    case 'quota_high':
                        $query->orderBy('available_modules_count', 'desc');
                        break;
                    case 'quota_low':
                        $query->orderBy('available_modules_count', 'asc');
                        break;
                    default:
                        $query->orderBy('available_modules_count', 'desc')->orderBy('created_at', 'desc');
                }
            }, function ($query) {
                $query->orderBy('available_modules_count', 'desc')->orderBy('created_at', 'desc');
            })
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name', 'asc')->get();

        return view('landing.pages.collaboration.index', compact('books', 'categories'));
    }

    public function collaborationDetail(string $slug): View
    {
        session()->forget(['checkout_items', 'checkout_total']);
        $book = Book::with('authors.user', 'category', 'modules.user', 'modules.transactionDetails.transaction', 'bookEditors')
            ->where('slug', $slug)
            ->where('is_individual', false)
            ->whereIn('status', [Book::STATUS_OPEN, Book::STATUS_EDITING, Book::STATUS_PUBLISHED])
            ->firstOrFail();

        // Counting active modules and authors
        $countActiveModules = $book->modules->where('is_active', true)->count();
        $countAuthorUploads = $book->modules->where('is_active', true)->where('user_id', '!=', null)->where('file_path', '!=', null)->count();
        $countAuthors = $book->modules->filter(fn ($module) => $module->order_lock_status !== 'available')->count();

        $checkEditing = $book?->bookEditors?->file_status == 'approved' ? true : false;
        $similarBooks = Book::with('authors.user', 'modules')
            ->where('is_individual', false)
            ->whereIn('status', [Book::STATUS_OPEN, Book::STATUS_EDITING])
            ->where('id', '!=', $book->id)
            ->inRandomOrder()
            ->limit(6)
            ->get();

        return view('landing.pages.collaboration.detail', compact('book', 'countActiveModules', 'countAuthors', 'countAuthorUploads', 'checkEditing', 'similarBooks'));
    }

    public function publications(Request $request): View
    {
        $books = Book::query()
            ->with('authors.user', 'category')
            ->where('status', Book::STATUS_PUBLISHED)
            ->latest('published_at')
            ->paginate(50)
            ->withQueryString();

        return view('landing.pages.publications.index', compact('books'));
    }

    public function member(): View
    {
        $now = Carbon::now();
        $user = auth()->user();
        $transactions = Transaction::with('user', 'details.book', 'details.module.book', 'individualBookPackage')
            ->where(function ($query) {
                $query->whereHas('details.module.book')
                    ->orWhereHas('details.book')
                    ->orWhereNotNull('individual_book_package_id');
            })
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        $bookColaborators = Module::where('user_id', $user->id)
            ->whereHas('book', function ($query) {
                $query->where('is_individual', false);
            })
            ->with('book')
            ->paginate(10);

        $transactionCount = $transactions->total();
        $referrals = User::where('use_referral_code', '!=', null)
            ->where('use_referral_code', $user->referral_code)
            ->paginate(10);

        $referralCount = $referrals->count();
        $collaborationCount = $bookColaborators->count();

        $referralUserIds = $user->referral_code
            ? User::whereNotNull('use_referral_code')->where('use_referral_code', $user->referral_code)->pluck('id')
            : collect();
        $affiliateRevenueTotalMonth = Transaction::whereIn('user_id', $referralUserIds)
            ->where('status', 'paid')
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('total_price');

        $commissionHistories = CommissionHistory::where('user_id', $user->id)
            ->with('transaction.user.affiliateLevel')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $withdrawals = Withdraw::where('user_id', $user->id)
            ->paginate(10);

        $bookHistories = BookHistory::with('book.category', 'book.authors.user')->where('user_id', $user->id)
            ->paginate(10);

        $affiliateLevels = AffiliateLevel::all();

        $commissionTotalMonth = CommissionHistory::where('user_id', $user->id)
            ->whereMonth('created_at', $now->month)
            ->whereYear('created_at', $now->year)
            ->sum('amount');

        $documents = Document::query()
            ->where(function ($q) use ($user) {
                $q->whereDoesntHave('users')
                    ->orWhereHas('users', function ($q2) use ($user) {
                        $q2->where('users.id', $user->id);
                    });
            })
            ->latest()
            ->paginate(10);

        return view('landing.pages.account.index', compact(
            'user',
            'transactions',
            'transactionCount',
            'referralCount',
            'collaborationCount',
            'bookColaborators',
            'referrals',
            'commissionHistories',
            'withdrawals',
            'now',
            'bookHistories',
            'affiliateLevels',
            'commissionTotalMonth',
            'affiliateRevenueTotalMonth',
            'documents',
        ));
    }

    public function cart(): View
    {
        session()->forget(['checkout_items', 'checkout_total']);
        $carts = Cart::query()
            ->whereHas('book')
            ->with('book.authors.user', 'book.category')
            ->where('user_id', auth()->id())
            ->get();

        return view('landing.pages.cart.index', compact('carts'));
    }

    public function checkout(): View|RedirectResponse
    {
        if (! session()->has('checkout_items')) {
            return redirect()->route('cart')->with('error', 'Tidak ada item untuk checkout');
        }

        // Hapus promo code lama saat membuka halaman checkout
        session()->forget(['promo_code', 'promo_percentage', 'discount_amount']);

        $items = session('checkout_items');
        $subtotal = session('checkout_total');
        $promoCode = null;
        $discountAmount = 0;

        // Hitung biaya admin (nominal)
        $adminFee = getAdminFeeTransaction();

        // Total akhir
        $total = $subtotal + $adminFee;

        return view('landing.pages.checkout.index', compact('items', 'subtotal', 'total', 'promoCode', 'discountAmount', 'adminFee'));
        // return view('landing.pages.checkout.index');
    }

    public function readBook(string $slug)
    {
        $user = auth()->user();
        $book = Book::with('authors.user', 'category', 'modules.user', 'bookEditors.user')->where('slug', $slug)->firstOrFail();

        if (! $user) {
            return redirect()->route('login');
        }

        $hasPurchased = Transaction::where('user_id', $user->id)
            ->where('status', 'paid')
            ->whereHas('details', function ($query) use ($book) {
                $query->where('book_id', $book->id);
            })
            ->exists();

        $isChapterAuthor = Module::where('book_id', $book->id)
            ->where('user_id', $user->id)
            ->exists()
            || BookAuthor::where('book_id', $book->id)
                ->where('user_id', $user->id)
                ->exists();

        if (! $hasPurchased && ! $isChapterAuthor) {
            return redirect()->route('bookDetail', $slug)->with('error', 'Anda harus membeli buku ini terlebih dahulu untuk membaca kontennya.');
        }

        if ($isChapterAuthor) {
            $historyExists = BookHistory::where('book_id', $book->id)
                ->where('user_id', $user->id)
                ->exists();
            if (! $historyExists) {
                BookHistory::create([
                    'book_id' => $book->id,
                    'user_id' => $user->id,
                    'expired_at' => null,
                ]);
            }
        }

        $activeModules = $book->modules->filter(fn ($module) => $module->is_active)->sortBy('chapter')->values();

        return view('landing.pages.book.reader', compact('book', 'activeModules'));
    }

    public function applyPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|max:50',
        ]);

        $promo = \App\Models\Promo::where('code', $request->promo_code)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where('quantity', '>', 0)
            ->first();

        if (! $promo) {
            return response()->json([
                'success' => false,
                'message' => 'Kode promo tidak valid atau telah kadaluarsa',
            ]);
        }

        // Check if user has used this promo before
        $user = auth()->user();
        $usedCount = \App\Models\PromoHistory::where('promo_id', $promo->id)
            ->where('user_id', $user->id)
            ->count();

        if ($usedCount > 0) {
            return response()->json([
                'success' => false,
                'message' => 'Anda sudah menggunakan kode promo ini sebelumnya',
            ]);
        }

        $boundBookIds = $promo->books()->pluck('books.id')->all();
        if (! empty($boundBookIds)) {
            if ($request->boolean('individual_package')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo ini tidak bisa digunakan untuk pembelian paket buku individu.',
                ]);
            }

            $items = collect(session('checkout_items', []));
            $cartBookIds = $items->pluck('book_id')->filter()->unique()->values()->all();
            $moduleIds = $items->pluck('module_id')->filter()->unique()->values()->all();

            if (! empty($moduleIds)) {
                $moduleBookIds = Module::whereIn('id', $moduleIds)
                    ->whereHas('book', function ($query) {
                        $query->where('status', Book::STATUS_PUBLISHED);
                    })
                    ->pluck('book_id')
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();
                $cartBookIds = array_values(array_unique(array_merge($cartBookIds, $moduleBookIds)));
            }

            $eligibleBoundBookIds = $promo->books()
                ->where('books.status', Book::STATUS_PUBLISHED)
                ->pluck('books.id')
                ->all();
            $hasBoundBookInCart = collect($cartBookIds)->intersect($eligibleBoundBookIds)->isNotEmpty();
            if (! $hasBoundBookInCart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Promo ini hanya bisa digunakan untuk buku yang sudah publish.',
                ]);
            }
        }

        $total = (int) $request->input('subtotal', session('checkout_total', 0));
        $discountAmount = (int) round(($total * $promo->percentage) / 100);

        // Simpan kode promo yang valid ke session
        session([
            'promo_code' => $promo->code,
            'promo_percentage' => $promo->percentage,
            'discount_amount' => $discountAmount,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Kode promo berhasil digunakan! Diskon '.$promo->percentage.'%',
            'discount' => $discountAmount,
            'percentage' => $promo->percentage,
        ]);
    }

    public function removePromo(Request $request)
    {
        session()->forget(['promo_code', 'promo_percentage', 'discount_amount']);

        return response()->json([
            'success' => true,
            'message' => 'Kode promo telah dihapus',
        ]);
    }

    public function checkoutSuccess(string $transaction): View
    {
        $transaction = Transaction::with('user', 'details.book.authors.user', 'details.book.category', 'details.module.book', 'individualBookPackage')
            ->where('transaction_code', $transaction)
            ->firstOrFail();
        $bankInfo = getBankInfo();
        $adminFeePercentage = getAdminFeeTransaction();

        $detailsSubtotal = $transaction->details->sum(function ($detail) {
            return ((int) $detail->price_book) * ((int) $detail->quantity);
        });

        $packageSubtotal = max(((int) $transaction->total_price - (int) $transaction->admin_fee) + (int) $transaction->discount_amount, 0);
        $subtotalValue = $transaction->details->isNotEmpty() ? $detailsSubtotal : ($transaction->individualBookPackage ? $packageSubtotal : 0);

        return view('landing.pages.checkout.success', compact('transaction', 'bankInfo', 'adminFeePercentage', 'subtotalValue', 'packageSubtotal'));
    }

    public function about(): View
    {
        return view('landing.pages.about.index');
    }
}
