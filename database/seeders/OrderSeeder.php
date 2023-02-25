<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        function fibonache($i) { 
            if ($i == 0 ) return 0; 
            if ($i == 1 || $i == 2) { 
             return 1; 
            } else { 
             return fibonache($i - 1) + fibonache($i -2); 
            } 
        } 
        $arrOrders = [];
        $arrPrice = [5, 6, 6, 6, 6, 6, 6, 7, 7, 7, 7, 7, 7, 7, 7, 7, 7, 5.5, 5.5, 5.9,];

        for($i = 0; $i < 24; $i++){
            if($i < 10){
                $day = $i + 13;
                $arr = [
                    "name" => "tb-".$i,
                    "id_product" => 3,
                    "count" => fibonache($i+1),
                    "price" => $arrPrice[$i],
                    "date" => "2021-01-".$day,
                ];
                array_push($arrOrders, $arr);
            }
            if($i == 17){
                $day = $i + 13;
                $arr = [
                    "name" => "tb-".$i,
                    "id_product" => 3,
                    "count" => 89,
                    "price" => $arrPrice[$i],
                    "date" => "2021-01-".$day,
                ];
                array_push($arrOrders, $arr);
            }
            if($i == 23){
                $day = 5;
                $arr = [
                    "name" => "tb-".$i,
                    "id_product" => 3,
                    "count" => 144,
                    "price" => 5,
                    "date" => "2021-02-0".$day,
                ];
                array_push($arrOrders, $arr);
            }

        }
        DB::table('orders')->insertOrIgnore($arrOrders);
    }
}
