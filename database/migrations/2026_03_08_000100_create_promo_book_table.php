<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promo_book', function (Blueprint $table) {
            $table->uuid('promo_id');
            $table->uuid('book_id');
            $table->primary(['promo_id', 'book_id']);
            $table->foreign('promo_id')->references('id')->on('promos');
            $table->foreign('book_id')->references('id')->on('books');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promo_book');
    }
};
