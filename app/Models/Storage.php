<?php

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
