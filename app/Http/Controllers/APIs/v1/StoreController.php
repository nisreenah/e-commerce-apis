<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Auth;
use Illuminate\Http\JsonResponse;

/**
 * @group Stores
 * APIs for managing stores
 */
class StoreController extends Controller
{
    /**
     * Set Store Setting
     *
     * This API is for setting the store setting or updating the merchant's store setting if existing.
     *
     * @authenticated
     *
     * @bodyParam name string required The store name. Example: Store name
     * @bodyParam is_VAT_included string required If the VAT included in product price set is_VAT_included to "1" . Example: 1
     * @bodyParam VAT_percentage int If the is_VAT_included = 1 then the VAT_percentage will be required. Example: 5
     * @bodyParam shipping_cost int required The shipping cost of the the product price in the store. Example: 8
     *
     * @response 201
     * {
     * "status": true,
     * "status_code": 201,
     * "store": {
     * "name": "Test store name",
     * "is_VAT_included": "1",
     * "VAT_percentage": "5",
     * "merchant_id": 1,
     * "updated_at": "2022-04-13T15:42:28.000000Z",
     * "created_at": "2022-04-13T15:42:28.000000Z",
     * "id": 3
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
     * "name": [
     * "The name field is required."
     * ]
     * }
     * }
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function setOrUpdateStoreSetting(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'is_VAT_included' => 'required',
            'shipping_cost' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        ]);

        $user = Auth::user();
        $inputs = $request->all();
        $is_VAT_included = $request->get('is_VAT_included');

        if ((int)$is_VAT_included) {
            $this->validate($request, [
                'VAT_percentage' => 'required',
            ]);
        }

        $store = Store::updateOrCreate(
            ['merchant_id' => $user->id],
            $inputs
        );

        if (!$store) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'Failed to set your store setting!',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'status_code' => 201,
            'store' => $store,
        ], 201);

    }
}
