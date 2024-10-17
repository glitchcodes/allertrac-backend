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
//            ['name' => 'Tree nuts'],
//            ['name' => 'Shellfish'],
//            ['name' => 'Dairy'],
//            ['name' => 'Soybeans'],
//            ['name' => 'Sesame'],
//            ['name' => 'Fish'],
//            ['name' => 'Egg'],
//            ['name' => 'Peanuts'],
//            ['name' => 'Milk'],
//            ['name' => 'Meat']
            ['name' => 'Celery'],
            ['name' => 'Crustacean'],
            ['name' => 'Dairy'],
            ['name' => 'Egg'],
            ['name' => 'Fish'],
            ['name' => 'Fodmap'],
            ['name' => 'Lupine'],
            ['name' => 'Mollusk'],
            ['name' => 'Mustard'],
            ['name' => 'Peanut'],
            ['name' => 'Red Meat'],
            ['name' => 'Sesame'],
            ['name' => 'Sulfite'],
            ['name' => 'Tree Nut'],
            ['name' => 'Wheat'],
        ];

        DB::table('allergens')->insert($allergens);
    }
}
