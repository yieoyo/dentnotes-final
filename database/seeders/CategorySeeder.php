<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use App\Models\User;
class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            ['uuid' => str()->uuid(), 'name' => 'Default',],
            ['uuid' => str()->uuid(), 'name' => 'Another Default',],
        ]);
    }
}
