<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class MemberImportCsv
{
    /**
     * Insert batch dengan kecepatan maksimal
     */
    public static function insertBatchFast(array &$batch, int &$success, int &$failed, array &$errors): void
    {
        try {
            DB::transaction(function () use ($batch, &$success, &$failed, &$errors) {
                // Validasi email duplikat dalam batch
                $emails = array_column($batch, 'email');
                $existing = DB::table('users')
                    ->whereIn('email', $emails)
                    ->whereNull('deleted_at')
                    ->get(['id', 'email', 'phone_number'])
                    ->toArray();

                // Membuat array email dan nomor telepon yang sudah ada
                $existingEmail = array_column($existing, 'email');
                $existingPhone = array_column($existing, 'phone_number');
                $existingIds = array_column($existing, 'id');

                // Filter yang belum ada
                $cleaned = array_map(function ($user) use (&$errors, $existingEmail, $existingPhone, $existingIds) {
                    if (in_array($user['email'], $existingEmail)) {
                        $errors[] = "Row {$user['number']}: Email {$user['email']} sudah ada";

                        return null;
                    }

                    if (in_array($user['phone_number'], $existingPhone)) {
                        $errors[] = "Row {$user['number']}: Nomor telepon {$user['phone_number']} sudah ada";

                        return null;
                    }

                    if (in_array($user['id'], $existingIds)) {
                        $errors[] = "Row {$user['number']}: User dengan ID {$user['id']} sudah ada";

                        return null;
                    }

                    // hapus key number dari salinan user
                    if (isset($user['number'])) {
                        unset($user['number']);
                    }

                    return $user;
                }, $batch);

                // lalu filter yang emailnya belum ada
                $newUsers = array_filter($cleaned, function ($user) use ($existing) {
                    return $user && ! in_array($user['email'], $existing);
                });

                if (! empty($newUsers)) {
                    // Insert users
                    User::insert(array_values($newUsers));

                    // Ambil user IDs yang baru diinsert
                    $userIds = DB::table('users')
                        ->whereIn('email', array_column($newUsers, 'email'))
                        ->pluck('id');

                    // Batch insert roles
                    $roleData = [];
                    $memberRoleId = DB::table('roles')
                        ->where('name', 'member')
                        ->value('id');

                    foreach ($userIds as $userId) {
                        $roleData[] = [
                            'role_id' => $memberRoleId,
                            'model_type' => 'App\\Models\\User',
                            'model_id' => $userId,
                        ];
                    }

                    if (! empty($roleData)) {
                        DB::table('model_has_roles')->insert($roleData);
                    }

                    $success += count($newUsers);
                }

                $failed += (count($batch) - count($newUsers));
            });
        } catch (\Exception $e) {
            // Jika gagal, hitung semua sebagai failed
            $failed += count($batch);
            $errors[] = $e->getMessage();
        }
    }
}
