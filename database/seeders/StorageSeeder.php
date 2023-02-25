<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('storage')->insertOrIgnore([
            [
                "name" => "Колбаса",
                "count" => 0,
                "price" => null,
            ],
            [
                "name" => "Пармезан",
                "count" => 0,
                "price" => null,
            ],
            [
                "name" => "Левый носок",
                "count" => 0,
                "price" => null,
            ],
        ]);
    }
}
