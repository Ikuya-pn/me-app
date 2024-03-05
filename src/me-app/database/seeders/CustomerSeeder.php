<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use DateTime;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('customers')->insert([
            [
                'name' => 'たなかたろう',
                'phone' => '08000000000',
                'postcode' => '0400013',
                'address' => '佐藤町19-22',
                'memo' => 'あいう',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ],
            [
                'name' => 'すずきさちこ',
                'phone' => '09000000000',
                'postcode' => '0400014',
                'address' => '明石町19-22',
                'memo' => 'かきく',
                'created_at' => new DateTime(),
                'updated_at' => new DateTime(),
            ]
            
        ]);
    }
}
