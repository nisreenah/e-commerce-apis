<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    protected $fillable = [
        'name',
        'merchant_id',
        'is_VAT_included',
        'VAT_percentage',
    ];
}
