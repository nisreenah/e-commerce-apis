<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('APIs')->group(function () {
    // Controllers Within The "App\Http\Controllers\APIs" Namespace

    Route::namespace('v1')->group(function () {
        // Controllers Within The "App\Http\Controllers\APIs\v1" Namespace

        Route::prefix('v1')->group(function () {

            Route::post('/login', 'AuthController@login');
            Route::post('/register', 'AuthController@register');

            Route::group(['middleware' => ['auth:api']], function () {

                Route::group(['middleware' => ['role:merchant']], function () {
                    // Route::post('/set-store-setting', 'StoreController@setStoreSetting');
                    Route::post('/set-or-update-store-setting', 'StoreController@setOrUpdateStoreSetting');
                    Route::post('/add-product/{store}', 'ProductController@addProduct');
                });

                Route::group(['middleware' => ['role:consumer']], function () {
                    Route::post('/add-product-to-cart/{product}', 'ProductController@addProductToCart');
                    Route::get('/calculate-cart', 'CartController@calculateCart');
                });

            });
        });

    });

});




