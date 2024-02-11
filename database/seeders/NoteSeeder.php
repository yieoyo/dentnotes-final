<?php

namespace Database\Seeders;

use App\Models\Note;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteSeeder extends Seeder
{
    public function run(): void
    {
        // name: input + date now with
        // json:
        Note::insert([
            ['name' => 'lorel ipsum', 'notes' => "We define sample data for th", 'user_id' => 1, 'category_id' => 1],
            ['name' => 'lorel ipsum1', 'notes' => "We define sample data for th", 'user_id' => 1, 'category_id' => 2],
            ['name' => 'lorel ipsum2', 'notes' => "We define sample data for th", 'user_id' => 1, 'category_id' => 3],
            ['name' => 'lorel ipsum3', 'notes' => "We define sample data for th", 'user_id' => 1, 'category_id' => 4],
        ]);
    }
}
