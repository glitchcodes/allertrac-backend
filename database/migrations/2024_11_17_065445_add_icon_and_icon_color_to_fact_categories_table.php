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
        Schema::table('fact_categories', function (Blueprint $table) {
            $table->string('icon')->nullable();
            $table->string('icon_color')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumns('fact_categories', ['icon', 'icon_color'])) {
            Schema::table('fact_categories', function (Blueprint $table) {
                $table->dropColumn('icon');
                $table->dropColumn('icon_color');
            });
        }
    }
};
