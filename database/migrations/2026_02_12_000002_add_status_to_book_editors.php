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
            // Check if status column exists, if yes modify it, if no create it
            if (Schema::hasColumn('book_editors', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending')->change();
            } else {
                $table->enum('status', ['pending', 'approved', 'rejected', 'completed'])->default('pending')->after('file_turnitin');
            }

            if (! Schema::hasColumn('book_editors', 'notes')) {
                $table->text('notes')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_editors', function (Blueprint $table) {
            $table->dropColumn(['status', 'notes']);
        });
    }
};
