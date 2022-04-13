<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    protected $fillable = [
        'consumer_id',
    ];

    public function products(): BelongsToMany
    {
         return $this->belongsToMany(Product::class,'cart_product')
             ->withPivot('quantity', 'product_id', 'cart_id');
    }

    public function consumer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'consumer_id');
    }
}
