<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/logo.PNG?raw=true" width="400" alt="Laravel Logo"></a></p>

## О проекте
Это небольшая CRM-система магазина, которая выполняет следующие задачи:
 - Отслеживает поставки,
 - Отслеживает предзаказы,
 - Расчитывает остаток на складе исходя из первых двух пунктов,
 - Расчитывает цены товаров,
 - Упращает работу сотрудникам. 
 
 ## Демо видео 
 
 <a href="https://vk.com/video284614176_456239236"><img style="text-align: centr;" width="500px" src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/video.png?raw=true"></a>
 
 ## Стек проекта
 В проекте были использованы следующие технологии:
 - PHP 8
 - JavaScript
 - Laravel 10x
 - Bootstrap
 - HTML
 - CSS
 
## Описание логики

Вся логика приложения завязана на дате, которую выбрал пользователь. Выбор даты реализовон формой с полем для ввода даты и кнопкой отправки:
``` html
<form action="/date" method="post">
    <div class="flex form_date">
        <Label>Выбери дату:</Label>
        <input class="input_date" type="date" id="start" name="date" value="{{$date}}" min="2021-01-01" max="2023-12-31">
        <button disabled class="sub_btn" >Показать данные</button>
    </div>
    <div class="err"></div>
</form>
```

Далее данные отправляются на URL "/date" и активирует acthion в [IndexController](https://github.com/PaulPolkanov/MyStorage/blob/master/app/Http/Controllers/IndexController.php):

``` PHP
public function dateAction(Request $request)
{
        $tamplate = $this->template;
        //Данный валидатор проверяет наличие и правильность принимаемой даты
        $validator = DateValidator::dateCheck($request);
        
        if($validator->fails())
        {
            //Если данные не соответсвуют, то редиректим на главную страницу
            return redirect()->with('home');
        }
        
        $date = $request->date;
        
        //Получаем предзаказы по выбранной дате
        $orders = Order::where('date', $date)->get();
        
        //Отправляем дату в Helper который расчитает остаток на складе и цену товаров
        $storage = Calculation::countOnStorage($date);
        
        $prices = Calculation::calculPrice($date);
        
        return view('pages.main', compact('tamplate', 'date', 'orders', 'storage', 'prices'));
}
```

Все вычисления цен товаров и остатка на складе рассчитываются в Helper [Calculation](https://github.com/PaulPolkanov/MyStorage/blob/master/app/Helpers/Calculation.php). В Helper есть два статических метода.

 - [СountOnStorage](#), который отвечает за вычисления остатков на складе:
``` PHP
static function countOnStorage($date)
{
    //storage - массив в который будут записываться данные
    $storage = [];
    $products = Storage::get();
    //Цикл, который проходит по массиву обьектов(продукты)
    foreach($products as $item)
    {
        //Получаем предзаказы и поставки определеного продукта и до определеной даты
        $productSupp = Supplie::where('id_product', $item->id)->where('date' , '<=', $date)->get();
        
        $productOrders = Order::where('id_product', $item->id)->where('date' , '<=', $date)->get();
        
        $count = 0;
        
        foreach($productSupp as $supp)
        {
            $count = $count + $supp->count;
        }
        foreach($productOrders as $order)
        {
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
```

 - [CalculPrice](#), который отвечает за вычисления цен товаров:
 ``` PHP
 static function calculPrice($date)
 {
    $prices = [];
    $products = Storage::get();
    foreach($products as $item)
    {
        $productSupp = Supplie::where('id_product', $item->id)->where('date' , '<=', $date)->orderBy('date', 'desc')->first();
        $price = 0;
        if($productSupp)
        {
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
 ```
 
 
