<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/logo.PNG?raw=true" width="800" alt="Laravel Logo"></a></p>

## О проекте
Это небольшая CRM-система магазина, которая выполняет следующие задачи:
 - Отслеживает поставки,
 - Отслеживает предзаказы,
 - Рассчитывает остаток на складе исходя из первых двух пунктов,
 - Рассчитывает цены товаров,
 - Упрощает работу сотрудникам. 
 
 ## Демо видео 
 
 <a href="https://vk.com/video284614176_456239236">
    <img style="text-align: centr;" width="500px" src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/video.png?raw=true">
 </a>

К сожалению на видео не отобразилось окно для выбора даты:

<img width="400px" src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/image.png">

 ## Стек проекта
 В проекте были использованы следующие технологии:
 - PHP 8
 - JavaScript
 - Laravel 10x
 - Bootstrap
 - HTML
 - CSS
 
## База данных

В базе данных есть три таблицы:
 - Таблица 'storage' , где хранятся названия продуктов:
    | id            | name               | count |
    | ------------- |:------------------:| -----:|
    | 1             | Колбаса            |     0 |
    | 2             | Пармезан           |     0 |
    | 3             | Левый носок        |     0 |
    
 - Таблица 'supplies' , где хранятся поставки:
    | id | name     | id_product | count | cost | date 
    | --- | ---     | --- | --- | --- | --- 
    | 1 | 1         | 1 | 300 | 5000 | 2021-01-01 
    | 2 | t-500     | 2 | 10 | 6000 | 2021-01-02 
    | 3 | 12-TP-777 | 3 | 100 | 500 | 2021-01-13 
    | 4 | 12-TP-778 | 3 | 50 | 300 | 2021-01-14 
    | 5 | 12-TP-779 | 3 | 77 | 539 | 2021-01-20 
    | 6 | 12-TP-877 | 3 | 32 | 176 | 2021-01-30
    | 7 | 12-TP-977 | 3 | 94 | 554 | 2021-02-01 
    | 8 | 12-TP-979 | 3 | 200 | 1000 | 2021-02-05 
    
    
 - Таблица 'orders' , где хранятся предзаказы:
    | id | name | id_product | count | price | date 
    | ---| --- | --- | --- | --- | --- 
    | 1  | tb-0 | 3 | 1 | 5 | 2021-01-13 
    | 2  | tb-1 | 3 | 1 | 6 | 2021-01-14 
    | 3  | tb-2 | 3 | 2 | 6 | 2021-01-15 
    | 4  | tb-3 | 3 | 3 | 6 | 2021-01-16  
    | 5  | tb-4 | 3 | 5 | 6 | 2021-01-17 
    | 6  | tb-5 | 3 | 8 | 6 | 2021-01-18 
    | 7  | tb-6 | 3 |13 | 6 | 2021-01-19 
    | 8  | tb-7 | 3 | 21 | 7 | 2021-01-20 
    | 9  | tb-8 | 3 | 34 | 7 | 2021-01-21 
    | 10 | tb-9 | 3 | 55 | 7 | 2021-01-22 
    | 11 | tb-10 | 3 | 89 | 6 | 2021-01-30 
    | 12 | tb-11 | 3 | 144 | 5 | 2021-02-05 

Связи между таблицами организованы в ORM Laravel и связаны все таблици по id товаров. Для этого были созданы 3 модели:
 - Модель [Storage](https://github.com/PaulPolkanov/MyStorage/blob/master/app/Models/Storage.php),
``` PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Storage extends Model
{
    protected $table = 'storage';
    public $timestamps= false;
    public function orders(){
        return $this->hasMany(Order::class, 'id_product');
    }
    public function supplies(){
        return $this->hasMany(Supplie::class, 'id_product');
    }
}

```
 - Модель [Order](https://github.com/PaulPolkanov/MyStorage/blob/master/app/Models/Order.php),
``` PHP
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table =  'orders';
    public function product(){
        return $this->belongsTo(Storage::class, 'id_product');
    }
}
```
 - Модель [Supplie](https://github.com/PaulPolkanov/MyStorage/blob/master/app/Models/Supplie.php),
 ``` PHP
 namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplie extends Model
{
    protected $table =  'supplies';
    public function product(){
        return $this->belongsTo(Storage::class, 'id_product');
    }
}
 ```
 
## Описание логики
Вся логика приложения завязана на дате, которую выбрал пользователь. Выбор даты реализован формой с полем для ввода даты и кнопкой отправки:

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
            //Если данные не соответствуют, то редиректим на главную страницу
            return redirect()->with('home');
        }
        
        $date = $request->date;
        
        //Получаем предзаказы по выбранной дате
        $orders = Order::where('date', $date)->get();
        
        //Отправляем дату в Helper который рассчитает остаток на складе и цену товаров
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
    //Цикл, который проходит по массиву объектов(продукты)
    foreach($products as $item)
    {
        //Получаем предзаказы и поставки определённого продукта и до определённой даты
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
 Далее все данные из Helper присваиваются переменным и передаются в шаблон:
 ``` PHP
$storage = Calculation::countOnStorage($date);
$prices = Calculation::calculPrice($date);

return view('pages.main', compact('tamplate', 'date', 'orders', 'storage', 'prices'));
 ```
 В итоге у нас парсятся в веб-страницу:
 
 <img width="700px" src="https://github.com/PaulPolkanov/MyStorage/blob/master/public/image/%D0%A1%D0%BD%D0%B8%D0%BC%D0%BE%D0%BA%20%D1%8D%D0%BA%D1%80%D0%B0%D0%BD%D0%B0%20(405).png">
