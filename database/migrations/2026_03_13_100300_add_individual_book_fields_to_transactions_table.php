<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (! Schema::hasColumn('transactions', 'individual_book_package_id')) {
                $table->foreignUuid('individual_book_package_id')->nullable()->constrained('individual_book_packages');
            }
            if (! Schema::hasColumn('transactions', 'additional_authors_count')) {
                $table->integer('additional_authors_count')->default(0);
            }
            if (! Schema::hasColumn('transactions', 'individual_book_status')) {
                $table->enum('individual_book_status', ['pending', 'confirmed', 'rejected'])->default('pending');
            }
            if (! Schema::hasColumn('transactions', 'individual_book_confirmed_at')) {
                $table->timestamp('individual_book_confirmed_at')->nullable();
            }
            if (! Schema::hasColumn('transactions', 'individual_book_rejected_at')) {
                $table->timestamp('individual_book_rejected_at')->nullable();
            }
            if (! Schema::hasColumn('transactions', 'individual_book_rejected_reason')) {
                $table->text('individual_book_rejected_reason')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            if (Schema::hasColumn('transactions', 'individual_book_package_id')) {
                $table->dropConstrainedForeignId('individual_book_package_id');
            }
            if (Schema::hasColumn('transactions', 'additional_authors_count')) {
                $table->dropColumn('additional_authors_count');
            }
            if (Schema::hasColumn('transactions', 'individual_book_status')) {
                $table->dropColumn('individual_book_status');
            }
            if (Schema::hasColumn('transactions', 'individual_book_confirmed_at')) {
                $table->dropColumn('individual_book_confirmed_at');
            }
            if (Schema::hasColumn('transactions', 'individual_book_rejected_at')) {
                $table->dropColumn('individual_book_rejected_at');
            }
            if (Schema::hasColumn('transactions', 'individual_book_rejected_reason')) {
                $table->dropColumn('individual_book_rejected_reason');
            }
        });
    }
};
