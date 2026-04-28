<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // This migration will be handled by SettingsSeeder
        // We just need to ensure the settings table has proper columns
        // The actual settings will be seeded via seeder
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Settings will be handled by settings system
    }
};
