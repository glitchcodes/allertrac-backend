<?php

namespace Database\Seeders;

use App\Models\FactCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $facts = [];

        $categories = [
            ['name' => 'Common Allergens'],
            ['name' => 'Food Allergy'],
            ['name' => 'Emergency Plan'],
            ['name' => 'Recipes']
        ];

        FactCategory::insert($categories);

        $insertedCategories = FactCategory::whereIn('name', array_column($categories, 'name'))->get();

        foreach ($insertedCategories as $category) {
            $facts[] = [
                'author_id' => 1,
                'category_id' => $category->id,
                'title' => fake()->sentence(2),
                'description' => fake()->paragraph(2),
                'cover_image' => 'fact-image-'. count($facts) + 1 .'.jpg',
                'references' => fake()->url()
            ];
        }

        DB::table('facts')->insert($facts);

    }
}
