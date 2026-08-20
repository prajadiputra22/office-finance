<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    
    public function run(): void
    {
        $categories = [
            ['id' => 1, 'category_name' => 'Perusahaan A', 'type' => 'income'],
            ['id' => 2, 'category_name' => 'Perusahaan B', 'type' => 'income'],
            ['id' => 3, 'category_name' => 'Perusahaan C', 'type' => 'income'],
            ['id' => 4, 'category_name' => 'Perusahaan D', 'type' => 'income'],
            ['id' => 5, 'category_name' => 'Kas Kecil', 'type' => 'expenditure'],
            ['id' => 6, 'category_name' => 'Kas Besar', 'type' => 'expenditure'],
            ['id' => 7, 'category_name' => 'Hutang Perusahaan', 'type' => 'expenditure'],
            ['id' => 8, 'category_name' => 'Gaji', 'type' => 'expenditure'],
        ];

        foreach ($categories as $category) {
            DB::table('category')->updateOrInsert(
                ['id' => $category['id']],
                [
                    'category_name' => $category['category_name'],
                    'type' => $category['type'],
                    'slug' => Str::slug($category['category_name']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}