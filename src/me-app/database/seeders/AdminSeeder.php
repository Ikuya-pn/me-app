<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use DateTime;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admins')->insert([
            'name' => 'admin1',
            'email' => 'go.me.2019014@gmail.com',
            'password' => Hash::make('Me3114'),
            'created_at' => new DateTime(),
            'updated_at' => new DateTime(),
        ]);
    }
}
