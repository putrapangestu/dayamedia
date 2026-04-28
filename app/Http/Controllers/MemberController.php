<?php

namespace App\Http\Controllers;

use App\Http\Requests\Global\ImportRequest;
use App\Http\Requests\Master\Member\CreateMemberRequest;
use App\Http\Requests\Master\Member\ImportCsvMemberRequest;
use App\Http\Requests\Master\Member\UpdateMemberRequest;
use App\Imports\MemberImport;
use App\Imports\MemberImportCsv;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $users = User::role('member')
            ->with('affiliateLevel')
            ->when($request->name, function ($query) use ($request) {
                $query->where('full_name', 'like', '%'.$request->name.'%');
            })
            ->when($request->status == 'active', function ($query) {
                $query->whereNotNull('email_verified_at');
            })
            ->when($request->status == 'inactive', function ($query) {
                $query->whereNull('email_verified_at');
            })
            ->when($request->affiliate_level_id, function ($query) use ($request) {
                $query->where('affiliate_level_id', $request->affiliate_level_id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends($request->only(['name', 'status', 'affiliate_level_id']));

        return view('admin.pages.member.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pages.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateMemberRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'password' => bcrypt('password'),
            'job' => $validated['job'],
            'degree' => $validated['degree'],
            'phone_number' => $validated['phone_number'],
            'referral_code' => Str::upper(Str::random(4) . now()->format('s') . Str::random(2)),
        ]);

        $user->assignRole('member');

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $member = User::with('affiliateLevel')->findOrFail($id);

        $transactions = \App\Models\Transaction::with('details.book', 'details.module.book')
            ->where(function ($query) {
                $query->whereHas('details.module.book')->orWhereHas('details.book');
            })
            ->where('user_id', $member->id)
            ->latest()
            ->paginate(10);

        $ownedBooks = \App\Models\TransactionDetail::with('book', 'transaction')
            ->whereHas('transaction', function ($q) use ($member) {
                $q->where('user_id', $member->id)->where('status', 'paid');
            })
            ->whereNotNull('book_id')
            ->get()
            ->map(function ($detail) {
                return $detail->book;
            })
            ->filter()
            ->unique('id')
            ->values();

        $collaborationModules = \App\Models\Module::with('book')
            ->where('user_id', $member->id)
            ->paginate(10);

        $now = \Carbon\Carbon::now();
        $commissionTotalMonth = \App\Models\Transaction::where(function ($query) use ($member) {
            $query->whereHas('details.book.modules', function ($q) use ($member) {
                $q->where('user_id', $member->id);
            })
                ->orWhereHas('user', function ($q) use ($member) {
                    $q->where('id', $member->id)
                        ->where('use_referral_code', $member->referral_code);
                });
        })
            ->whereMonth('updated_at', $now->month)
            ->whereYear('updated_at', $now->year)
            ->sum('total_price');

        $affiliateLevels = \App\Models\AffiliateLevel::orderBy('min_earning', 'asc')->get();

        $commissionHistories = \App\Models\CommissionHistory::where('user_id', $member->id)
            ->with('transaction.user.affiliateLevel')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'commission_page');

        $referralUsers = User::where('use_referral_code', '!=', null)
            ->where('use_referral_code', $member->referral_code)
            ->with('affiliateLevel')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'referral_page');

        return view('admin.pages.member.show', compact(
            'member',
            'transactions',
            'ownedBooks',
            'collaborationModules',
            'commissionTotalMonth',
            'affiliateLevels',
            'commissionHistories',
            'referralUsers'
        ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $member)
    {
        return view('admin.pages.member.edit', compact('member'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberRequest $request, User $member)
    {
        $validated = $request->validated();

        $member->update([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'job' => $validated['job'],
            'degree' => $validated['degree'],
            'phone_number' => $validated['phone_number'],
        ]);

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $member)
    {
        $member->delete();

        return redirect()->route('admin.member.index')->with('success', 'Member berhasil dihapus.');
    }

    /**
     * Meng-handle proses import data member dari file.
     */
    public function import(ImportRequest $request)
    {
        $data = $request->validated();

        try {
            $import = new MemberImport;
            Excel::import($import, $request->file('file'));

            $report = $import->getReport();

            if (isset($report['errors']) && count($report['errors']) > 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ada beberapa error validasi pada file Anda.',
                    'data' => $report['errors'],
                ], 201);
            }

            return response()->json([
                'success' => true,
                'message' => 'Data member berhasil diimpor.',
                'data' => $report,
            ], 200);
        } catch (ValidationException $e) {
            $failures = $e->failures();

            // Handle validation failures, maybe return them to the view
            return response()->json([
                'success' => false,
                'message' => 'Ada beberapa error validasi pada file Anda.',
                'data' => $failures,
            ], 422);
        } catch (\Exception $e) {
            // Handle other exceptions
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengimpor file: '.$e->getMessage(),
            ], 400);
        }
    }

    /**
     * Import super cepat dengan CSV streaming
     */
    public function importFast(ImportCsvMemberRequest $request)
    {
        try {
            $file = $request->file('file');
            $path = $file->getRealPath();

            // Baca CSV dengan streaming
            $handle = fopen($path, 'r');
            if ($handle === false) {
                throw new \Exception('Tidak dapat membuka file');
            }

            // Skip header
            $header = fgetcsv($handle);

            $batch = [];
            $success = 0;
            $failed = 0;
            $errors = [];

            $affiliateLevelId = DB::table('affiliate_levels')
                ->orderBy('percentage', 'asc')
                ->value('id');

            $password = bcrypt('password');
            $now = now();

            DB::disableQueryLog(); // Matikan query log untuk performa

            $rowNum = 1;
            while (($data = fgetcsv($handle)) !== false) {
                try {
                    // Validasi basic
                    if (! isset($data[0], $data[1]) || empty($data[0]) || empty($data[1])) {
                        $failed++;
                        $errors[] = "Row $rowNum: Nama dan email wajib diisi";

                        continue;
                    }

                    $full_name = trim($data[0]);
                    $email = trim($data[1]);
                    $phone_number = isset($data[2]) ? trim($data[2]) : null;
                    $referral_code = isset($data[3]) ? trim($data[3]) : null;
                    $use_referral_code = isset($data[4]) ? trim($data[4]) : null;
                    $balance = isset($data[5]) && is_numeric($data[5]) ? (float) $data[5] : 0;

                    // Validasi nama
                    if (strlen($full_name) < 2 || strlen($full_name) > 255) {
                        $failed++;
                        $errors[] = "Row $rowNum: Nama harus 2-255 karakter";

                        continue;
                    }

                    if (strlen($email) > 255) {
                        $failed++;
                        $errors[] = "Row $rowNum: Email terlalu panjang (max 255)";

                        continue;
                    }

                    // Validasi phone number (jika ada)
                    if (isset($phone_number) && (strlen($phone_number) > 20 || ! preg_match('/^[0-9+\-\s]+$/', $phone_number))) {
                        $failed++;
                        $errors[] = "Row $rowNum: Nomor telepon tidak valid (max 20 digit)";

                        continue;
                    }

                    // Validasi referral code (jika ada)
                    if ($referral_code && strlen($referral_code) > 255) {
                        $failed++;
                        $errors[] = "Row $rowNum: Referral code terlalu panjang (max 255)";

                        continue;
                    }

                    // Validasi balance
                    if ($balance < 0 || $balance > 999999999) {
                        $failed++;
                        $errors[] = "Row $rowNum: Balance tidak valid (0-999999999)";

                        continue;
                    }

                    // Cek duplikasi email dalam batch
                    if (isset($emailsInBatch[$email])) {
                        $failed++;
                        $errors[] = "Row $rowNum: Email duplikat dalam file ($email)";

                        continue;
                    }

                    $batch[] = [
                        'id' => Str::uuid(),
                        'number' => $rowNum,
                        'full_name' => $full_name, // nama
                        'email' => $email,       // email
                        'phone_number' => $phone_number ?? null, // no_telp
                        'password' => $password,
                        'referral_code' => $referral_code ?? Str::upper(Str::random(4) . now()->format('s') . Str::random(2)),
                        'use_referral_code' => $use_referral_code ?? null,
                        'email_verified_at' => $now,
                        'affiliate_level_id' => $affiliateLevelId,
                        'balance' => $balance,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];

                    $emailsInBatch[$email] = true;

                    // Insert batch setiap 5000 record
                    if (count($batch) >= 5000) {
                        MemberImportCsv::insertBatchFast($batch, $success, $failed, $errors);
                        $batch = [];
                        $emailsInBatch = [];
                    }

                } catch (\Exception $e) {
                    $failed++;
                    $errors[] = "Row $rowNum: ".$e->getMessage();
                }

                $rowNum++;
            }

            // Insert sisa batch
            if (! empty($batch)) {
                MemberImportCsv::insertBatchFast($batch, $success, $failed, $errors);
            }

            fclose($handle);

            return response()->json([
                'success' => true,
                'message' => 'Data member berhasil diimpor.',
                'data' => [
                    'success' => $success,
                    'failed' => $failed,
                    'errors' => $errors,
                ],
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Row $rowNum error => ".$e->getMessage(),
            ], 400);
        }
    }
}
