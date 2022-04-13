<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Auth;

class ProductController extends Controller
{
    public function addProduct(Request $request, $store_id): JsonResponse
    {
        $this->validate($request, [
            'price' => 'required',
            'en_name' => 'required|string',
            'en_description' => 'required',
            'ar_name' => 'required|string',
            'ar_description' => 'required',
        ]);

        $data = [
            'en' => [
                'name' => $request->get('en_name'),
                'description' => $request->get('en_description')
            ],
            'ar' => [
                'name' => $request->get('ar_name'),
                'description' => $request->get('ar_description')
            ],
            'price' => 200,
            'store_id' => $store_id
        ];

        // Now just pass this array to regular Eloquent function and Voila!
        $product = Product::create($data);

        if (!$product) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'Failed to add the product in your store!',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'status_code' => 201,
            'product' => $product,
        ], 201);
    }

    public function addProductToCart(Request $request, $product_id): JsonResponse
    {
        $this->validate($request, [
            'quantity' => 'required',
        ]);

        $quantity = $request->get('quantity');
        $user = Auth::user();

        // if the user does not have a cart, then create one
        $user_cart = $user->cart;
        if (is_null($user_cart)) {
            Cart::create(['consumer_id' => $user->id]);
        }

        // $user->cart->products()->detach();

        // without detaching previous AND without adding duplicates:
        // $attach_product = $user->cart->products()->sync($product_id, ['quantity' => $quantity], false);

        // $is_in_cart = $user->cart->products()->wherePivotIn('product_id', [$product_id]);
        $is_in_cart = $user->cart->products->contains($product_id);
        if ($is_in_cart) {
            // Updating an existing row in your relationship's intermediate table:
            $user->cart->products()->updateExistingPivot($product_id, ['quantity' => $quantity]);
        } else {
            $user->cart->products()->attach($product_id, ['quantity' => $quantity]);
        }

        // $user->cart->products()->detach();

        $cart_products = $user->cart->products;

        return response()->json([
            'status' => true,
            'status_code' => 201,
            'cart_products' => $cart_products,
        ], 201);

    }

}
