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
        Schema::table('facts', function (Blueprint $table) {
            $table->boolean('is_published')->default(false)->after('references');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('facts', 'is_published')) {
            Schema::table('facts', function (Blueprint $table) {
                $table->dropColumn('is_published');
            });
        }
    }
};
