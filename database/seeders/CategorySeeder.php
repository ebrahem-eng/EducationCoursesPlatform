<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        Category::create([
            'name' => 'Coding',
            'code' => 'qokwdknj',
            'priority' => '0',
            'status' => '1',
            'created_by' => '1',
        ]);

        Category::create([
            'name' => 'C#',
            'code' => 'qokwdknj',
            'priority' => '0',
            'parent_id' => '1',
            'status' => '1',
            'created_by' => '1',
        ]);
    }
}
