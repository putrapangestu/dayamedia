<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('withdraws', function (Blueprint $table) {
            if (! Schema::hasColumn('withdraws', 'admin_fee')) {
                $table->double('admin_fee')->default(0)->after('amount');
            }
            if (! Schema::hasColumn('withdraws', 'net_amount')) {
                $table->double('net_amount')->default(0)->after('admin_fee');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('withdraws', function (Blueprint $table) {
            $table->dropColumn(['admin_fee', 'net_amount']);
        });
    }
};
