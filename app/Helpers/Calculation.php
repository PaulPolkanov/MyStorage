<?php
    namespace App\Helpers;

use App\Models\Order;
use App\Models\Storage;
use App\Models\Supplie;

    class Calculation{
        //countOnStorage - статический метод, который принемает дату и расчитывает 
        //остаток на складе с учетом всех поставок и предзаказов
        static function countOnStorage($date){
            //storage - массив в который будут записываться данные
            $storage = [];
            $products = Storage::get();
            //Цикл, который проходит по массиву обьектов(продукты)
            foreach($products as $item){
                //Получаем предзаказы и поставки определеного продукта и до определеной даты
                $productSupp = Supplie::where('id_product', $item->id)->where('date' , '<=', $date)->get();
                $productOrders = Order::where('id_product', $item->id)->where('date' , '<=', $date)->get();
                $count = 0;
                foreach($productSupp as $supp){
                    $count = $count + $supp->count;
                }
                foreach($productOrders as $order){
                    $count = $count - $order->count;
                }
                $arr = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'count' => $count,
                ];
                array_push($storage, $arr);
            }
            return $storage;
        }
        static function calculPrice($date){
            $prices = [];
            $products = Storage::get();
            foreach($products as $item){
                $productSupp = Supplie::where('id_product', $item->id)->where('date' , '<=', $date)->orderBy('date', 'desc')->first();
                $price=0;
                if($productSupp){
                  //Вычислить себестоимость и делаем наценку 30%
                    $price = round($productSupp->cost/$productSupp->count/100*130);
                }
                $arr = [
                    'id' => $item->id,
                    'name' => $item->name,
                    'price' => $price,
                ];
                array_push($prices, $arr);
            }
            return $prices;
        }
    }