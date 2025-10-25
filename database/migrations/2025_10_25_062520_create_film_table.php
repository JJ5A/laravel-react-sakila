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
        Schema::create('film', function (Blueprint $table) {
            $table->id('film_id');
            $table->string('title', 128);
            $table->text('description')->nullable();
            $table->year('release_year')->nullable();
            $table->unsignedBigInteger('language_id');
            $table->unsignedBigInteger('original_language_id')->nullable();
            $table->unsignedTinyInteger('rental_duration')->default(3);
            $table->decimal('rental_rate', 4, 2)->default(4.99);
            $table->unsignedSmallInteger('length')->nullable();
            $table->decimal('replacement_cost', 5, 2)->default(19.99);
            $table->string('rating', 10)->default('G');
            $table->text('special_features')->nullable();
            $table->timestamps('last_update')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('film');
    }
};
