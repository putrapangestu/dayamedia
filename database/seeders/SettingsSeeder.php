<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Payment settings
        $this->createSetting('expired_time', 24, 'integer', 'Waktu kadaluarsa pembayaran dalam jam', 'payment');
        $this->createSetting('payment_reminder_hours', 12, 'integer', 'Waktu pengingat pembayaran dalam jam sebelum kadaluarsa', 'payment');
        $this->createSetting('auto_cancel_expired', true, 'boolean', 'Otomatis membatalkan transaksi yang kadaluarsa', 'payment');

        // Bank information settings
        $this->createSetting('bank_name', 'Bank Mandiri', 'string', 'Nama Bank', 'payment');
        $this->createSetting('bank_account_name', 'PT Daya Media', 'string', 'Nama Rekening', 'payment');
        $this->createSetting('bank_account_number', '1234567890', 'string', 'Nomor Rekening', 'payment');
        $this->createSetting('bank_swift_code', '', 'string', 'Kode SWIFT', 'payment');
        $this->createSetting('bank_branch', '', 'string', 'Cabang Bank', 'payment');
        $this->createSetting('bank_address', '', 'string', 'Alamat Bank', 'payment');

        // Payment confirmation settings
        $this->createSetting('admin_whatsapp', '6281166012020,6281166031010', 'string', 'Nomor WhatsApp admin untuk notifikasi', 'notification');
        $this->createSetting('payment_confirmation_whatsapp', '6281166012020,6281166031010', 'string', 'Nomor WhatsApp untuk konfirmasi pembayaran', 'payment');
        $this->createSetting('payment_confirmation_email', 'admin@azzia.id', 'string', 'Email untuk konfirmasi pembayaran', 'payment');

        // Royalty settings
        $this->createSetting('royalty_percentage', 10, 'decimal', 'Persentase royalty untuk author/editor', 'royalty');
        $this->createSetting('referral_percentage', 5, 'decimal', 'Persentase referral untuk user yang mereferensikan', 'royalty');
        $this->createSetting('min_withdrawal', 50000, 'integer', 'Minimum jumlah untuk penarikan royalty', 'royalty');
        $this->createSetting('payment_terms', '', 'text', 'Syarat dan ketentuan pembayaran royalty', 'royalty');
    }

    private function createSetting(string $key, $value, string $type = 'string', string $description = '', string $group = 'general')
    {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'id' => Setting::where('key', $key)->first()?->id ?? (string) Str::uuid(),
                'value' => $value,
                'type' => $type,
                'description' => $description,
                'group' => $group,
            ]
        );
    }
}
