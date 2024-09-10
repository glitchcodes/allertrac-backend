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
        DB::table('users')->insert([
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'dummy@example.com',
            'password' => '$2y$12$MjjZFOqBP99i/rCdB4ToAeLpPOHQhf9cAsz/8ojMGqWcrqDVLcocK',
            'email_verified_at' => now(),
            'role' => 'testing'
        ]);
    }
}
