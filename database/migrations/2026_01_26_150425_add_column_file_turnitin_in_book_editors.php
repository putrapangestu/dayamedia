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
        Schema::table('book_editors', function (Blueprint $table) {
            if (! Schema::hasColumn('book_editors', 'file_turnitin')) {
                $table->string('file_turnitin')->nullable()->after('file_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_editors', function (Blueprint $table) {
            //
        });
    }
};
