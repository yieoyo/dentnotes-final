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
            ['uuid' => str()->uuid(), 'name' => 'GDP', 'user_id' => 1,],
            ['uuid' => str()->uuid(), 'name' => 'Pros', 'user_id' => 1,],
            ['uuid' => str()->uuid(), 'name' => 'Perio', 'user_id' => 1,],
            ['uuid' => str()->uuid(), 'name' => 'Endo', 'user_id' => 1,],
            ['uuid' => str()->uuid(), 'name' => 'Oral Surg', 'user_id' => 1,],
            ['uuid' => str()->uuid(), 'name' => 'Emergency', 'user_id' => 1,],
        ]);
    }
}
