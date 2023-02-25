<?php

namespace App\Http\Controllers;

use App\Helpers\Calculation;
use App\Http\Validators\DateValidator;
use App\Models\Order;
use App\Models\Supplie;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
class IndexController extends Controller
{
    private $template = 'default';
    public function indexAction(){
        $tamplate = $this->template;
        $date = date("Y-m-d");
        $msg = "Выберите дату...";
        return view('pages.main', compact('tamplate', 'msg'));
    }
    public function dateAction(Request $request){
        //Данный валидатор проверяет наличие и правильность принимаемой даты
        $validator = DateValidator::dateCheck($request);
        if($validator->fails()){
            //Если данные не соответсвуют, то редиректим на главную страницу
            return redirect()->with('home');
        }
        $tamplate = $this->template;
        $date = $request->date;
        //Получаем предзаказы по выбранной дате
        $orders = Order::where('date', $date)->get();
        //Отправляем дату в Helper который расчитает остаток на складе и цену товаров
        $storage = Calculation::countOnStorage($date);
        $prices = Calculation::calculPrice($date);
        return view('pages.main', compact('tamplate', 'date', 'orders', 'storage', 'prices'));
    }
}
