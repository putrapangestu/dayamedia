<?php

namespace App\Imports;

use App\Models\AffiliateLevel;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Validators\Failure;

class MemberImport implements SkipsOnFailure, ToCollection, WithBatchInserts, WithChunkReading, WithHeadingRow, WithValidation
{
    private int $success_rows = 0;

    private int $failed_rows = 0;

    private array $errors = [];

    private int $batch_size = 100;

    private array $batch_data = [];

    private array $batch_index = [];

    public function collection(Collection $rows)
    {
        $affiliateLevel = AffiliateLevel::orderby('percentage', 'asc')->first();
        $affiliateLevelId = $affiliateLevel ? $affiliateLevel->id : null;

        // Persiapkan data untuk batch insert
        $users_data = [];
        $now = now();

        foreach ($rows as $index => $row) {
            try {
                // Validasi email unik secara manual untuk batch
                if (User::where('email', $row['email'])->exists()) {
                    throw new \Exception('Email sudah terdaftar');
                }

                $users_data[] = [
                    'full_name' => $row['nama'],
                    'email' => $row['email'],
                    'phone_number' => $row['no_telp'] ?? null,
                    'password' => Hash::make('password'),
                    'use_referral_code' => $row['use_referral_code'] ?? null,
                    'referral_code' => $row['referral_code'] ?? Str::upper(Str::random(4) . now()->format('s') . Str::random(2)),
                    'email_verified_at' => $now,
                    'affiliate_level_id' => $affiliateLevelId,
                    'balance' => $row['balance'] ?? 0,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];

                $this->batch_index[] = $index;

                // Insert batch ketika mencapai ukuran batch
                if (count($users_data) >= $this->batch_size) {
                    $this->processBatch($users_data);
                    $users_data = [];
                    $this->batch_index = [];
                }

            } catch (\Exception $e) {
                $this->failed_rows++;
                $this->errors[] = [
                    'row' => $index + 2, // +2 karena heading row dan index dimulai dari 0
                    'data' => $row->toArray(),
                    'errors' => [$e->getMessage()],
                ];
            }
        }

        // Proses sisa data
        if (! empty($users_data)) {
            $this->processBatch($users_data);
        }
    }

    private function processBatch(array $users_data): void
    {
        try {
            // Gunakan transaction untuk keamanan
            DB::transaction(function () use ($users_data) {
                // Batch insert users
                User::insert($users_data);

                // Ambil user yang baru saja diinsert
                $emails = array_column($users_data, 'email');
                $users = User::whereIn('email', $emails)->get();

                // Assign role ke semua user
                foreach ($users as $user) {
                    $user->assignRole('member');
                }

                $this->success_rows += count($users_data);
            });

        } catch (\Exception $e) {
            // Jika batch gagal, proses satu per satu
            foreach ($users_data as $index => $user_data) {
                try {
                    $user = User::create($user_data);
                    $user->assignRole('member');
                    $this->success_rows++;
                } catch (\Exception $inner_e) {
                    $this->failed_rows++;
                    $this->errors[] = [
                        'row' => $this->batch_index[$index] + 2,
                        'data' => $user_data,
                        'errors' => [$inner_e->getMessage()],
                    ];
                }
            }
        }
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,NULL,id,deleted_at,NULL',
            'no_telp' => 'nullable|max:20|unique:users,phone_number,NULL,id,deleted_at,NULL',
            'use_referral_code' => 'nullable|string|max:255',
            'referral_code' => 'nullable|string|max:255',
            'balance' => 'nullable|numeric|min:0',
        ];
    }

    public function chunkSize(): int
    {
        return $this->batch_size;
    }

    public function batchSize(): int
    {
        return $this->batch_size;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->failed_rows++;
            $this->errors[] = [
                'row' => $failure->row(),
                'data' => $failure->values(),
                'errors' => $failure->errors(),
            ];
        }
    }

    public function getReport(): array
    {
        return [
            'success' => $this->success_rows,
            'failed' => $this->failed_rows,
            'errors' => $this->errors,
        ];
    }
}
