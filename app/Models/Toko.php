<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class toko extends Model
{
    protected $guarded = ['id' ] ;

    public function order()
    {
        return $this->hasMany(Order::class);

    }
}
