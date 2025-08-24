<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Untuk Wanita',
                'slug' => 'untuk-wanita',
            ],
            [
                'name' => 'Untuk Pria',
                'slug' => 'untuk-pria',
            ],
            [
                'name' => 'Untuk Pasangan',
                'slug' => 'untuk-pasangan',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
