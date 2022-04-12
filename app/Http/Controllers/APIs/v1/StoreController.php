<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Auth;
use Illuminate\Http\JsonResponse;

class StoreController extends Controller
{
    public function setStoreSetting(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'is_VAT_included' => 'required',
        ]);

        $user = Auth::user();
        $is_VAT_included = $request->get('is_VAT_included');
        $name = $request->get('name');

        $store = new Store;
        $store->name = $name;
        $store->is_VAT_included = $is_VAT_included;

        if ((int)$is_VAT_included) {
            $this->validate($request, [
                'VAT_percentage' => 'required',
            ]);
            $VAT_percentage = $request->get('VAT_percentage');
            $store->VAT_percentage = $VAT_percentage;
        }

        $store = $user->store()->save($store);
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

    public function setOrUpdateStoreSetting(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string',
            'is_VAT_included' => 'required',
        ]);

        $user = Auth::user();
        $is_VAT_included = $request->get('is_VAT_included');

        if ((int)$is_VAT_included) {
            $this->validate($request, [
                'VAT_percentage' => 'required',
            ]);
        }

        $inputs = $request->all();
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
