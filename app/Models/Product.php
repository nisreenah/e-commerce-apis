<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['name', 'description'];
    protected $fillable = ['price', 'product_id', 'store_id'];
    protected $appends = ['VAT_percentage'];

    public function carts(): BelongsToMany
    {
        return $this->belongsToMany(Cart::class, 'cart_product', 'product_id', 'cart_id')
            ->withPivot('quantity', 'product_id', 'cart_id');
    }

    public function getVATPercentageAttribute(): int
    {
        $store = Store::findOrFail($this->store_id);
        $VAT = 0;
        if ((int)$store->is_VAT_included) {
            $VAT = $store->VAT_percentage != 0 ? $store->VAT_percentage : 0;
        }
        return (int)$VAT;
    }

    public function getPriceAttribute($value): float
    {
        $store = Store::findOrFail($this->store_id);

        $total_price = $value;

        if ((int)$store->is_VAT_included) {
            $VAT = $store->VAT_percentage;
            if ($VAT != 0) {
                $VAT_price = $value * ($VAT / 100);
                $total_price = $value + $VAT_price;
            }
        }
        return (float)$total_price;
    }


}
