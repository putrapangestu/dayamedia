<?php

use App\Http\Controllers\AdminBookEditorController;
use App\Http\Controllers\AdminFileReviewController;
use App\Http\Controllers\AdminIndividualBookController;
use App\Http\Controllers\AffiliateOrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BankInfoController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BookEditorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\IndividualBookPackageAdminController;
use App\Http\Controllers\IndividualBookPackageController;
use App\Http\Controllers\IndividualBookUploadController;
use App\Http\Controllers\Landing\AccountController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Master\ModuleController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\RoyaltyController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Transaction\CartController;
use App\Http\Controllers\Transaction\HistoryController;
use App\Http\Controllers\Transaction\TransactionBookController;
use App\Http\Controllers\Transaction\TransactionModuleController;
use App\Http\Controllers\Transaction\WithdrawController;
use App\Http\Controllers\WhatsAppTemplateController;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return view('landing.layouts.app');
});

Route::get('/', [LandingController::class, 'index'])->name('home');
Route::get('/books', [LandingController::class, 'catalog'])->name('catalog');
Route::get('/books/{slug}/read', [LandingController::class, 'readBook'])->name('book.read');
Route::get('/books/{slug}', [LandingController::class, 'bookDetail'])->name('bookDetail');
Route::get('/about', [LandingController::class, 'about'])->name('about');
Route::get('/collaboration-books', [LandingController::class, 'collaboration'])->name('collaboration');
Route::get('/collaboration-books/{slug}', [LandingController::class, 'collaborationDetail'])->name('collaborationDetail');
Route::get('/publications', [LandingController::class, 'publications'])->name('publications');

// Route::get('/sitemap.xml', function () {
//     $urls = [];
//     $urls[] = ['loc' => url('/'), 'lastmod' => now()->toAtomString()];
//     $urls[] = ['loc' => route('catalog'), 'lastmod' => now()->toAtomString()];
//     $urls[] = ['loc' => route('collaboration'), 'lastmod' => now()->toAtomString()];
//     $urls[] = ['loc' => route('publications'), 'lastmod' => now()->toAtomString()];

//     $publishedBooks = \App\Models\Book::where('status', \App\Models\Book::STATUS_PUBLISHED)
//         ->select(['slug', 'updated_at'])
//         ->get();
//     foreach ($publishedBooks as $book) {
//         $urls[] = [
//             'loc' => route('bookDetail', $book->slug),
//             'lastmod' => optional($book->updated_at)->toAtomString() ?? now()->toAtomString(),
//         ];
//     }

//     $collabBooks = \App\Models\Book::whereIn('status', [\App\Models\Book::STATUS_OPEN, \App\Models\Book::STATUS_EDITING])
//         ->select(['slug', 'updated_at'])
//         ->get();
//     foreach ($collabBooks as $book) {
//         $urls[] = [
//             'loc' => route('collaborationDetail', $book->slug),
//             'lastmod' => optional($book->updated_at)->toAtomString() ?? now()->toAtomString(),
//         ];
//     }

//     $xml = new \SimpleXMLElement('<urlset/>');
//     $xml->addAttribute('xmlns', 'http://www.sitemaps.org/schemas/sitemap/0.9');
//     foreach ($urls as $u) {
//         $url = $xml->addChild('url');
//         $url->addChild('loc', htmlspecialchars($u['loc'], ENT_XML1));
//         $url->addChild('lastmod', $u['lastmod']);
//     }

//     return response($xml->asXML(), 200)->header('Content-Type', 'application/xml');
// })->name('sitemap');

// Route on guest middleware
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('login', [AuthController::class, 'login']);
    Route::get('register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [AuthController::class, 'register']);
    Route::get('forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.forgot');
    Route::post('forgot-password', [AuthController::class, 'sendForgotOtp'])->name('password.forgot.send');
    Route::get('reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('reset-password', [AuthController::class, 'resetPasswordWithOtp'])->name('password.reset.post');
    Route::post('reset-password/resend', [AuthController::class, 'resendOtp'])->name('password.reset.resend');
});

Route::get('/individual-books/packages', [IndividualBookPackageController::class, 'index'])->name('individual-books.packages');

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Account Routes
    Route::get('/account', [LandingController::class, 'member'])->name('member');
    Route::put('/account/profile', [AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::post('/account/collaboration/upload/{id}', [AccountController::class, 'uploadCollaborationFile'])->name('account.collaboration.upload');
    Route::put('/account/transaction/upload-payment/{transaction}', [AccountController::class, 'uploadPaymentProof'])->name('account.transaction.upload-payment');

    Route::get('/individual-books/packages/{package}/purchase', [IndividualBookPackageController::class, 'purchase'])->name('individual-books.purchase');
    Route::post('/individual-books/packages/{package}/purchase', [IndividualBookPackageController::class, 'storePurchase'])->name('individual-books.purchase.store');
    Route::get('/individual-books/upload/{transaction}', [IndividualBookUploadController::class, 'showUploadForm'])->name('individual-books.upload');
    Route::post('/individual-books/upload/{transaction}', [IndividualBookUploadController::class, 'submitUpload'])->name('individual-books.upload.store');

    Route::get('/checkout', [LandingController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/apply-promo', [LandingController::class, 'applyPromo'])->name('checkout.apply-promo');
    Route::post('/checkout/remove-promo', [LandingController::class, 'removePromo'])->name('checkout.remove-promo');
    Route::get('/checkout/{transaction}/success', [LandingController::class, 'checkoutSuccess'])->name('checkout.success');

    // Cart Routes
    Route::get('/cart', [LandingController::class, 'cart'])->name('cart');
    Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
    Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::put('/cart/{cart}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cart}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Order Routes
    Route::post('/order/book', [TransactionBookController::class, 'storeApiBook'])->name('order.book.store');
    Route::post('/checkout/process', [CartController::class, 'processCheckout'])->name('checkout.process');

    // Withdraw Routes
    Route::post('/withdraw', [WithdrawController::class, 'store'])->name('withdraw.store');
    // check promo code
    Route::post('/promo/check', [PromoController::class, 'checkPromo'])->name('promo.check');

    // Settings Routes
    Route::get('/settings/admin-fee', [SettingController::class, 'adminFee'])->name('settings.admin-fee');
    Route::post('/settings/admin-fee', [SettingController::class, 'saveAdminFee'])->name('admin.settings.admin-fee.save');
    Route::get('/settings/profile', [SettingController::class, 'profile'])->name('settings.profile');
    Route::get('/settings/documents', [SettingController::class, 'document'])->name('settings.documents');
    Route::get('/settings/create-document', [SettingController::class, 'createDocument'])->name('settings.create-document');
    Route::post('/settings/documents', [SettingController::class, 'storeDocument'])->name('settings.store-document');
    Route::delete('/settings/documents/{document}', [SettingController::class, 'destroyDocument'])->name('settings.documents.destroy');
});

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'showVerificationNotice'])->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [AuthController::class, 'verifyEmail'])->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'sendVerificationEmail'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');

// admin area
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'dashboardAdmin'])->name('home');

    // Member Routes
    Route::resource('member', MemberController::class);
    // Import Routes
    Route::post('member/import', [MemberController::class, 'import'])->name('member.import');
    Route::post('member/import-csv', [MemberController::class, 'importFast'])->name('member.import.csv');

    // Editor Routes
    Route::resource('editor', EditorController::class);

    // Category Routes
    Route::resource('category', CategoryController::class);

    // Book Routes
    Route::resource('book', BookController::class);

    // Individual Book Packages
    Route::resource('individual-book-packages', IndividualBookPackageAdminController::class);

    // Book Editor Admin Routes
    Route::get('book-editor/claims', [AdminBookEditorController::class, 'index'])->name('book-editor.claims');
    Route::get('book-editor/claims/{bookEditor}/edit', [AdminBookEditorController::class, 'edit'])->name('book-editor.claims.edit');
    Route::put('book-editor/claims/{bookEditor}', [AdminBookEditorController::class, 'update'])->name('book-editor.claims.update');
    Route::delete('book-editor/claims/{bookEditor}', [AdminBookEditorController::class, 'destroy'])->name('book-editor.claims.destroy');
    Route::post('book-editor/claims/{bookEditor}/remove', [AdminBookEditorController::class, 'removeEditor'])->name('book-editor.claims.remove');
    Route::post('book-editor/claims/{bookEditor}/transfer', [AdminBookEditorController::class, 'transferEditor'])->name('book-editor.claims.transfer');

    // File Review Admin Routes
    Route::get('book-editor/file-reviews', [AdminFileReviewController::class, 'index'])->name('book-editor.file-reviews');
    Route::get('book-editor/file-reviews/{bookEditor}/edit', [AdminFileReviewController::class, 'edit'])->name('book-editor.file-reviews.edit');
    Route::get('/book-editor/{bookEditor}/download-file', [BookEditorController::class, 'downloadFile'])->name('book-editor.download-file');
    Route::get('/book-editor/{bookEditor}/download-file-turnitin', [BookEditorController::class, 'downloadFileTurnitin'])->name('book-editor.download-file-turnitin');
    Route::get('/book-editor/{bookEditor}/download-file-revisi', [AdminFileReviewController::class, 'downloadFileRevisi'])->name('book-editor.download-file-revisi');
    Route::put('book-editor/file-reviews/{bookEditor}', [AdminFileReviewController::class, 'update'])->name('book-editor.file-reviews.update');

    // Royalty Routes
    Route::get('royalty', [RoyaltyController::class, 'index'])->name('royalty.index');
    Route::get('royalty/settings', [RoyaltyController::class, 'settings'])->name('royalty.settings');
    Route::post('royalty/settings/update', [RoyaltyController::class, 'updateSettings'])->name('royalty.settings.update');
    Route::get('royalty/{royalty}', [RoyaltyController::class, 'show'])->name('royalty.show');
    Route::post('royalty/{royalty}/process-payment', [RoyaltyController::class, 'processPayment'])->name('royalty.process-payment');

    // Bank Information Routes
    Route::get('settings/bank-info', [BankInfoController::class, 'index'])->name('settings.bank-info');
    Route::put('settings/bank-info', [BankInfoController::class, 'update'])->name('settings.bank-info.update');
    Route::get('api/bank-info', [BankInfoController::class, 'show'])->name('api.bank-info');

    // WhatsApp Templates Routes
    Route::get('settings/whatsapp-templates', [WhatsAppTemplateController::class, 'index'])->name('whatsapp-templates.index');
    Route::get('settings/whatsapp-templates/{template}/edit', [WhatsAppTemplateController::class, 'edit'])->name('whatsapp-templates.edit');
    Route::put('settings/whatsapp-templates/{template}', [WhatsAppTemplateController::class, 'update'])->name('whatsapp-templates.update');
    Route::get('settings/whatsapp-templates/{template}/preview', [WhatsAppTemplateController::class, 'preview'])->name('whatsapp-templates.preview');
    Route::post('settings/whatsapp-templates/{template}/send-test', [WhatsAppTemplateController::class, 'sendTest'])->name('whatsapp-templates.send-test');

    // Affiliate Order Routes
    Route::resource('affiliate-order', AffiliateOrderController::class);

    // Promo Routes
    Route::resource('promo', PromoController::class);

    // Module Routes
    Route::resource('module', ModuleController::class);

    // Book Order Routes
    Route::get('book-orders', [TransactionBookController::class, 'index'])->name('book-order.index');
    Route::get('book-order/{transaction}', [TransactionBookController::class, 'show'])->name('book-order.show');
    Route::put('book-order/{transaction}', [TransactionBookController::class, 'update'])->name('book-order.update');

    Route::get('/individual-books', [AdminIndividualBookController::class, 'index'])->name('individual-books.index');
    Route::get('/individual-books/{transaction}', [AdminIndividualBookController::class, 'show'])->name('individual-books.show');
    Route::put('/individual-books/{transaction}/confirm', [AdminIndividualBookController::class, 'confirm'])->name('individual-books.confirm');
    Route::put('/individual-books/{transaction}/reject', [AdminIndividualBookController::class, 'reject'])->name('individual-books.reject');

    // BAB Order View Route
    Route::get('bab-orders', [TransactionModuleController::class, 'index'])->name('bab-order.index');
    Route::get('bab-order/{transaction}', [TransactionModuleController::class, 'show'])->name('bab-order.show');
    Route::put('bab-order/{transaction}', [TransactionModuleController::class, 'update'])->name('bab-order.update');

    Route::get('affiliate', [HistoryController::class, 'indexRoyalti'])->name('affiliate.index');
    Route::get('withdrawl', [WithdrawController::class, 'index'])->name('withdrawl.index');
    Route::put('withdrawl/{withdrawl}', [WithdrawController::class, 'update'])->name('withdrawl.update');
});

// Editor area
Route::prefix('editor')->name('editor.')->middleware(['auth', 'role:editor'])->group(function () {

    Route::get('/', [DashboardController::class, 'dashboardEditor'])->name('home');

    // list book for editor
    Route::get('/book', [BookEditorController::class, 'index'])->name('book.index');
    Route::get('/book/{book}', [BookEditorController::class, 'show'])->name('book.show');

    // Book Editor Routes
    Route::post('/book/{book}/claim', [BookEditorController::class, 'claimBook'])->name('book.claim');
    Route::post('/book-editor/{bookEditor}/upload-file-editor', [BookEditorController::class, 'uploadFileEditor'])->name('book-editor.upload-file-editor');
    Route::post('/book-editor/{bookEditor}/file-approval', [BookEditorController::class, 'updateFileApproval'])->name('book-editor.file-approval');

    // Module Editor Routes
    Route::get('/module/{module}/download', [ModuleController::class, 'downloadFile'])->name('module.download');
});
