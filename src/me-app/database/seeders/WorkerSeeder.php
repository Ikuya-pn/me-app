<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTime;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('workers')->insert([
            'name' => 'admin1',
            'email' => 'test1@test.com',
            'password' => Hash::make('password123'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
