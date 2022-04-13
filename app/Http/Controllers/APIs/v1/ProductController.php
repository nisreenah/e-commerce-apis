<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\JsonResponse;
use Auth;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

/**
 * @group Products
 * APIs for managing products
 */
class ProductController extends Controller
{
    /**
     * Add Product
     *
     * @authenticated
     *
     * @urlParam store_id int required
     * @bodyParam price int required The product price. Example: 200
     * @bodyParam ar_name string required The Arabic name of the product. Example: Arabic product name
     * @bodyParam ar_description string required The Arabic description of the product. Example: Arabic product description
     * @bodyParam en_name string required The English name of the product. Example: English product name
     * @bodyParam en_description string required The English description of the product. Example: English product description
     *
     * @response 201
     * {
     * "status": true,
     * "status_code": 201,
     * "product": {
     * "price": 222,
     * "store_id": "4",
     * "updated_at": "2022-04-13T19:11:20.000000Z",
     * "created_at": "2022-04-13T19:11:20.000000Z",
     * "id": 6,
     * "VAT_percentage": 11,
     * "name": "Test en product name 49",
     * "description": "Test en product description 48",
     * "translations": [
     * {
     * "locale": "en",
     * "name": "Test en product name 49",
     * "description": "Test en product description 48",
     * "product_id": 6,
     * "id": 11
     * },
     * {
     * "locale": "ar",
     * "name": "Test ar product name 45",
     * "description": "Test ar product description 47",
     * "product_id": 6,
     * "id": 12
     * }
     * ]
     * }
     * }
     *
     * @response 400
     * {
     * "status" : false,
     * "status_code" : 400,
     * "message" : "Failed to add the product in your store!"
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
     * @response 422
     * {
     * "status": false,
     * "status_code": 422,
     * "message": "The given data was invalid.",
     * "errors": {
     * "price": [
     * "The price field is required."
     * ]
     * }
     * }
     *
     * @param Request $request
     * @param $store_id
     * @return JsonResponse
     */
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

    /**
     * Add Product To Cart
     *
     * If the user does not have a cart yet we will create one, then add the product to their cart.
     * and if the user adds the same product we will update the existing records by updating the quantity column
     *
     * @authenticated
     *
     * @urlParam product_id int required
     * @bodyParam quantity int required The product quantity. Example: 2
     *
     * @response 201
     * {
     * "status": true,
     * "status_code": 201,
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
     * @response 400
     * {
     * "status" : false,
     * "status_code" : 400,
     * "message" : "Failed to add the product in your store!"
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
     * @response 422
     * {
     * "status": false,
     * "status_code": 422,
     * "message": "The given data was invalid.",
     * "errors": {
     * "quantity": [
     * "The quantity field is required."
     * ]
     * }
     * }
     *
     * @param Request $request
     * @param $product_id
     * @return JsonResponse
     */
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
