<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;

class CartController extends Controller
{
    public function calculateCart(): JsonResponse
    {
        $user = Auth::user();

        // $cart_products = $user->cart->products;
        // $cart_total_price = $user->cart->products->sum('price');

        // Getting all user cart's products and calculating the total price,
        // by considering the VAT and quantity for each product.
        $cart_total_price = $user->cart->products->sum(
            function ($product) {
                return $product->price * $product->pivot->quantity;
            }
        );

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'cart_total_price' => $cart_total_price,
        ], 200);

    }

}
