<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'total_price',
        'quantity',
        'product_id',
        'consumer_id'
    ];

}
