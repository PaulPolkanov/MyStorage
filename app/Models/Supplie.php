<?php

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
