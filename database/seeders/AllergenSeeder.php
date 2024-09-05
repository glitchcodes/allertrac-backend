<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AllergenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allergens = [
            ['name' => 'Tree nuts'],
            ['name' => 'Shellfish'],
            ['name' => 'Dairy'],
            ['name' => 'Soybeans'],
            ['name' => 'Sesame'],
            ['name' => 'Fish'],
            ['name' => 'Egg'],
            ['name' => 'Peanuts'],
            ['name' => 'Milk'],
        ];

        DB::table('allergens')->insert($allergens);
    }
}
