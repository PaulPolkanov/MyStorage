@extends('layouts/'.$tamplate)
@section('content')
    <main>
        <div class="wrap">
            <form action="/date" method="post">
                @csrf
                <div class="flex form_date">
                    @if (isset($date))
                    <Label>Выбери дату:</Label><input class="input_date" type="date" id="start" name="date" value="{{$date}}" min="2021-01-01" max="2023-12-31">
                    <button disabled class="sub_btn" >Показать данные</button>
                    @else
                    <Label>Выбери дату:</Label><input type="date" id="start" name="date" min="2021-01-01" max="2023-12-31">
                    <button disabled class="sub_btn" >Показать данные</button>
                    @endif
                </div>
                <div class="err"></div>
            </form>
        </div>
        @if (isset($msg))
            <div class="wrap flex info_bloks">
                <div class="info_block">
                    <h3>Склад</h3>
                    <div class="info_block_content flex">
                        <p>{{$msg}}</p>
                    </div>
                </div>
                <div class="info_block">
                    <h3>Цены</h3>
                    <div class="info_block_content flex">
                        <p>{{$msg}}</p>
                    </div>
                </div>
                <div class="info_block">
                    <h3>Предзаказы</h3>
                    <div class="info_block_content flex">
                        <p>{{$msg}}</p>
                    </div>
                </div>
            </div>         
        @else
            <div class="wrap flex info_bloks">
                <div class="info_block">
                    <h3>Склад</h3>
                    <div class="info_block_content flex">
                        @foreach ($storage as $item)
                              <p class="count_order">{{$item['name']}} - {{$item['count']}} шт.</p>  
                        @endforeach
                    </div>
                </div>
                <div class="info_block">
                    <h3>Цены</h3>
                    <div class="info_block_content flex">
                        @foreach ($prices as $item)
                              <p class="count_order">{{$item['name']}} - {{$item['price']}} rub</p>  
                        @endforeach
                    </div>
                </div>
                <div class="info_block">
                    <h3>Предзаказы</h3>
                    <div class="info_block_content flex">
                        @if (count($orders) > 0)
                            @foreach ($orders as $item)
                                <p class="count_order">{{$item->name}} - {{$item->product->name}} - {{$item->count}} шт.</p>  
                            @endforeach
                        @else
                        <p>В этот день нет предзаказов</p>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </main>
    <script>
        //верификация формы не дает отправить пустые данные. 
        //Когда у нас пустая форма кнотка отправки - disabled
        let form_date = document.querySelector('.form_date');
        let btn = document.querySelector('.sub_btn');
        let msg = document.querySelector('.err');
        let date_input = document.getElementById('start');
        if(date_input.value != ''){
            btn.disabled = false
        }
        date_input.addEventListener('change', (evt)=>{
            console.log(evt.target.value);
            if(evt.target.value == ""){
                btn.disabled = true;
                msg.innerHTML = "<p class=\"msg_err\">Ошибка: Не выбрана дата!</p>";
            }
            else{
                btn.disabled = false
                if(msg.querySelector('.msg_err')){
                    msg.removeChild(msg.querySelector('.msg_err'));
                }
            }

        });
        console.log(btn);
    </script>
@endsection