<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('activation_otps');
    }

    public function down(): void
    {
        // Tidak perlu recreate — kita ganti pakai PasswordOtp + type
    }
};
