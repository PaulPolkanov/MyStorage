<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SupplieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('supplies')->insertOrIgnore([
            [
                "name" => "1",
                "id_product" => 1,
                "count" => 300,
                "cost" => 5000,
                "date" => "2021-01-01"
            ],
            [
                "name" => "t-500",
                "id_product" => 2,
                "count" => 10,
                "cost" => 6000,
                "date" => "2021-01-02"
            ],
            [
                "name" => "12-TP-777",
                "id_product" => 3,
                "count" => 100,
                "cost" => 500,
                "date" => "2021-01-13"
            ],
            [
                "name" => "12-TP-778",
                "id_product" => 3,
                "count" => 50,
                "cost" => 300,
                "date" => "2021-01-14"
            ],
            [
                "name" => "12-TP-779",
                "id_product" => 3,
                "count" => 77,
                "cost" => 539,
                "date" => "2021-01-20"
            ],
            [
                "name" => "12-TP-877",
                "id_product" => 3,
                "count" => 32,
                "cost" => 176,
                "date" => "2021-01-30"
            ],
            [
                "name" => "12-TP-977",
                "id_product" => 3,
                "count" => 94,
                "cost" => 554,
                "date" => "2021-02-01"
            ],
            [
                "name" => "12-TP-979",
                "id_product" => 3,
                "count" => 200,
                "cost" => 1000,
                "date" => "2021-02-05"
            ],
        ]);
    }
}
