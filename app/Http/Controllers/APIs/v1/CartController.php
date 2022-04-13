<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\ValidationException;

/**
 * @group Carts
 * APIs for managing shopping carts
 */
class CartController extends Controller
{
    /**
     * Calculate Shopping Cart
     *
     * Calculating the total shopping cart of the auth user,
     * by considering the VAT of each product price (if the VAT included in the store setting witch the product is related),
     * with quantity for each product and shipping cost for each store.
     * then returning the total_products_price, total_shipping_cost, cart_total_price, and cart_products.
     *
     * @authenticated
     *
     * @response 200
     * {
     * "status": true,
     * "status_code": 200,
     * "total_products_price": 1776,
     * "total_shipping_cost": 10,
     * "cart_total_price": 1786,
     * "cart_products": [
     * {
     * "id": 1,
     * "price": 222,
     * "store_id": 1,
     * "created_at": "2022-04-13T10:17:25.000000Z",
     * "updated_at": "2022-04-13T10:17:25.000000Z",
     * "VAT_percentage": 11,
     * "name": "Test en product name",
     * "description": "Test en product description",
     * "pivot": {
     * "cart_id": 1,
     * "product_id": 1,
     * "quantity": 5
     * },
     * "store": {
     * "id": 1,
     * "name": "Test store name",
     * "merchant_id": 1,
     * "is_VAT_included": "1",
     * "VAT_percentage": 11,
     * "shipping_cost": 5,
     * "created_at": "2022-04-13T10:16:59.000000Z",
     * "updated_at": "2022-04-13T15:58:40.000000Z"
     * },
     * "translations": [
     * {
     * "id": 2,
     * "product_id": 1,
     * "locale": "ar",
     * "name": "Test ar product name",
     * "description": "Test ar product description"
     * },
     * {
     * "id": 1,
     * "product_id": 1,
     * "locale": "en",
     * "name": "Test en product name",
     * "description": "Test en product description"
     * }
     * ]
     * },
     * {
     * "id": 2,
     * "price": 222,
     * "store_id": 1,
     * "created_at": "2022-04-13T10:17:42.000000Z",
     * "updated_at": "2022-04-13T10:17:42.000000Z",
     * "VAT_percentage": 11,
     * "name": "Test en product name 2",
     * "description": "Test en product description 2",
     * "pivot": {
     * "cart_id": 1,
     * "product_id": 2,
     * "quantity": 1
     * },
     * "translations": [
     * {
     * "id": 4,
     * "product_id": 2,
     * "locale": "ar",
     * "name": "Test ar product name 2",
     * "description": "Test ar product description 2"
     * },
     * {
     * "id": 3,
     * "product_id": 2,
     * "locale": "en",
     * "name": "Test en product name 2",
     * "description": "Test en product description 2"
     * }
     * ]
     * },
     * {
     * "id": 3,
     * "price": 222,
     * "store_id": 1,
     * "created_at": "2022-04-13T10:18:02.000000Z",
     * "updated_at": "2022-04-13T10:18:02.000000Z",
     * "VAT_percentage": 11,
     * "name": "Test en product name 3",
     * "description": "Test en product description 3",
     * "pivot": {
     * "cart_id": 1,
     * "product_id": 3,
     * "quantity": 1
     * },
     * "translations": [
     * {
     * "id": 6,
     * "product_id": 3,
     * "locale": "ar",
     * "name": "Test ar product name 3",
     * "description": "Test ar product description 3"
     * },
     * {
     * "id": 5,
     * "product_id": 3,
     * "locale": "en",
     * "name": "Test en product name 3",
     * "description": "Test en product description 3"
     * }
     * ]
     * },
     * {
     * "id": 5,
     * "price": 222,
     * "store_id": 4,
     * "created_at": "2022-04-13T16:17:06.000000Z",
     * "updated_at": "2022-04-13T16:17:06.000000Z",
     * "VAT_percentage": 11,
     * "name": "Test en product name 49",
     * "description": "Test en product description 48",
     * "pivot": {
     * "cart_id": 1,
     * "product_id": 5,
     * "quantity": 1
     * },
     * "store": {
     * "id": 4,
     * "name": "Test store name 03",
     * "merchant_id": 3,
     * "is_VAT_included": "1",
     * "VAT_percentage": 11,
     * "shipping_cost": 5,
     * "created_at": "2022-04-13T16:16:46.000000Z",
     * "updated_at": "2022-04-13T17:38:32.000000Z"
     * },
     * "translations": [
     * {
     * "id": 10,
     * "product_id": 5,
     * "locale": "ar",
     * "name": "Test ar product name 45",
     * "description": "Test ar product description 47"
     * },
     * {
     * "id": 9,
     * "product_id": 5,
     * "locale": "en",
     * "name": "Test en product name 49",
     * "description": "Test en product description 48"
     * }
     * ]
     * }
     * ]
     * }
     *
     * @response 401
     *{
     * "status": false,
     * "status_code": 401,
     * "message": "Unauthenticated."
     * }
     *
     * @response 403
     *{
     * "status": false,
     * "status_code": 403,
     * "message": "User does not have the right roles."
     * }
     *
     * @return JsonResponse
     */
    public function calculateCart(): JsonResponse
    {
        $user = Auth::user();

        $cart_products = $user->cart->products;
        // $cart_total_price = $user->cart->products->sum('price');

        // Getting all user cart's products and calculating the total price,
        // by considering the VAT (calculated in the model accessor), and quantity for each product.
        $total_products_price = $user->cart->products->sum(
            function ($product) {
                return $product->price * $product->pivot->quantity;
            }
        );

        $total_shipping_cost = $user->cart->products->unique('store_id')->pluck('store')->sum('shipping_cost');
        $cart_total_price = $total_shipping_cost + $total_products_price;

        return response()->json([
            'status' => true,
            'status_code' => 200,
            'total_products_price' => $total_products_price,
            'total_shipping_cost' => $total_shipping_cost,
            'cart_total_price' => $cart_total_price,
            'cart_products' => $cart_products,
        ], 200);

    }

}
