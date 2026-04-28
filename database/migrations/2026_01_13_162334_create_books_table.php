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
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->integer('price_digital')->nullable()->default(0);
            $table->integer('price_physical')->nullable()->default(0);
            $table->integer('stock')->nullable()->default(0);
            $table->string('code_isbn')->nullable();
            $table->enum('status', ['open', 'editing', 'published', 'archived', 'closed'])->nullable()->default('open');
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->year('year_published')->nullable();
            $table->string('language')->nullable();
            $table->integer('pages')->nullable()->default(0);
            $table->integer('weight')->nullable()->default(0);

            // File Upload
            $table->string('cover')->nullable();
            $table->string('full_content')->nullable();
            $table->string('half_content')->nullable();

            // Foreign Key Relation
            $table->foreignUuid('category_id')->references('id')->on('categories');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
