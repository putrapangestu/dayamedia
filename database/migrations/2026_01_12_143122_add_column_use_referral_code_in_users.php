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
        Schema::table('users', function (Blueprint $table) {
            if (! Schema::hasColumn('users', 'use_referral_code')) {
                $table->string('use_referral_code')->nullable();
            }

            if (! Schema::hasColumn('users', 'affiliate_level_id')) {
                $table->foreignUuid('affiliate_level_id')->nullable()->constrained('affiliate_levels');
            }

            if (! Schema::hasColumn('users', 'job')) {
                $table->string('job')->nullable();
            }

            if (! Schema::hasColumn('users', 'degree')) {
                $table->string('degree')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
