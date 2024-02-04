<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        // Insert sample data into the 'users' table
        DB::table('users')->insert([
            'name' => 'John Doe',
            'email' => 'admin@example.com',
            'password' => bcrypt('secret'),
            'role' => '1',
        ]);

        DB::table('users')->insert([
            'name' => 'Justin Timberlake',
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
            'role' => '2',
        ]);
    }
}
