<?php

use App\Models\Setting;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $this->upsertSetting('admin_whatsapp', '6281166012020,6281166031010', 'string', 'Nomor WhatsApp admin untuk notifikasi', 'notification');
        $this->upsertSetting('payment_confirmation_whatsapp', '6281166012020,6281166031010', 'string', 'Nomor WhatsApp untuk konfirmasi pembayaran', 'payment');
    }

    public function down(): void
    {
        //
    }

    private function upsertSetting(string $key, string $value, string $type, string $description, string $group): void
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
};
