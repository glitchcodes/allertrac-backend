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
        Schema::table('emergency_contacts', function (Blueprint $table) {
            $table->string('relationship_specific')->after('relationship')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('emergency_contacts', 'relationship_specific')) {
            Schema::table('emergency_contacts', function (Blueprint $table) {
                $table->dropColumn('relationship_specific');
            });
        }
    }
};
