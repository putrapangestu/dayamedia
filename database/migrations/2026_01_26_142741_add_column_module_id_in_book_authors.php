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
        Schema::table('book_authors', function (Blueprint $table) {
            if (! Schema::hasColumn('book_authors', 'module_id')) {
                $table->foreignUuid('module_id')->after('user_id')->nullable()->constrained('modules');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_authors', function (Blueprint $table) {
            //
        });
    }
};
