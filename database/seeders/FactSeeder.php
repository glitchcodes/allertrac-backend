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
            [
                'name' => 'Common Allergens',
                'icon' => 'cubeOutline',
                'icon_color' => '#eabcab'
            ],
            [
                'name' => 'Food Allergy',
                'icon' => 'fastFoodOutline',
                'icon_color' => '#b0d4c8'
            ],
            [
                'name' => 'Emergency Plan',
                'icon' => 'warningOutline',
                'icon_color' => '#beb9d6'
            ],
            [
                'name' => 'Recipes',
                'icon' => 'documentOutline',
                'icon_color' => '#f1d586'
            ]
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
