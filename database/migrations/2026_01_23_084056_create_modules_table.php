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
        Schema::create('modules', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('book_id')->constrained();
            $table->string('title');
            $table->string('slug');
            $table->integer('chapter');
            $table->integer('days')->nullable()->default(0);
            $table->date('deadline')->nullable();
            $table->text('description')->nullable();
            $table->double('price')->nullable()->default(0);
            $table->boolean('is_active')->nullable()->default(true);
            $table->foreignUuid('user_id')->nullable()->constrained();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('modules');
    }
};
