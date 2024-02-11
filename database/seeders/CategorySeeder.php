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
            ['name' => 'GDP', 'user_id' => 1,],
            ['name' => 'Pros', 'user_id' => 1,],
            ['name' => 'Perio', 'user_id' => 1,],
            ['name' => 'Endo', 'user_id' => 1,],
            ['name' => 'Oral Surg', 'user_id' => 1,],
            ['name' => 'Emergency', 'user_id' => 1,],
            ['name' => 'user cat', 'user_id' => 2,],
            ['name' => 'user category', 'user_id' => 2,],
        ]);
    }
}
