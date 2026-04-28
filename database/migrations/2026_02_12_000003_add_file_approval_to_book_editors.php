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
            $table->enum('file_status', ['pending', 'approved', 'rejected', 'revision'])->default('pending')->after('status');
            $table->text('revision_notes')->nullable()->after('file_status');
            $table->dateTime('file_submitted_at')->nullable()->after('revision_notes');
            $table->dateTime('file_reviewed_at')->nullable()->after('file_submitted_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('book_editors', function (Blueprint $table) {
            $table->dropColumn(['file_status', 'revision_notes', 'file_submitted_at', 'file_reviewed_at']);
        });
    }
};
