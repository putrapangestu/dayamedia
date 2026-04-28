<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('individual_book_packages', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->double('price');
            $table->text('description')->nullable();
            $table->integer('max_authors_default')->default(3);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('individual_book_packages');
    }
};
