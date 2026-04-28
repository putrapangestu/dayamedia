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
        Schema::table('transaction_details', function (Blueprint $table) {
            if (! Schema::hasColumn('transaction_details', 'module_id')) {
                $table->foreignUuid('module_id')->nullable()->after('book_id')->constrained('modules');
            }

            if (Schema::hasColumn('transaction_details', 'book_id')) {
                $table->foreignUuid('book_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaction_details', function (Blueprint $table) {
            //
        });
    }
};
