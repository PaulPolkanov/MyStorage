<?php
namespace App\Http\Validators;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class DateValidator{
    public static function dateCheck($request){
        return Validator::make($request->all(), [
            'date' => 'required',
        ]);
    }
}