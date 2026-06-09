<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            if (! Schema::hasColumn('books', 'google_scholar_url')) {
                $table->string('google_scholar_url', 2048)->nullable()->after('website');
            }
        });
    }

    public function down(): void
    {
        Schema::table('books', function (Blueprint $table): void {
            if (Schema::hasColumn('books', 'google_scholar_url')) {
                $table->dropColumn('google_scholar_url');
            }
        });
    }
};
