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
        Schema::table('modules', function (Blueprint $table) {
            $table->dateTime('deadline_date')->nullable()->after('deadline');
            $table->enum('deadline_type', ['days', 'date'])->default('days')->after('deadline_date');
            $table->boolean('is_overdue')->default(false)->after('deadline_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('modules', function (Blueprint $table) {
            $table->dropColumn(['deadline_date', 'deadline_type', 'is_overdue']);
        });
    }
};
