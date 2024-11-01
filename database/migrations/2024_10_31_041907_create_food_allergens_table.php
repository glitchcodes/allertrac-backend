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
        Schema::create('food_allergens', function (Blueprint $table) {
            $table->string('food_id');
            $table->foreignId('allergen_id')->constrained()->onDelete('cascade');
            $table->primary(['food_id', 'allergen_id']);
        });

        Schema::table('food_allergens', function (Blueprint $table) {
            $table->foreign('food_id')->references('food_id')->on('food')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_allergens');
    }
};
