<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('category')->insert([
            ['category_id' => 1, 'name' => 'Rau củ',         'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 2, 'name' => 'Trái cây',       'created_at' => now(), 'updated_at' => now()],
            ['category_id' => 3, 'name' => 'Thực phẩm sạch', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}