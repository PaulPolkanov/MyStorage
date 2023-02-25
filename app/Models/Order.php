<?php

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
