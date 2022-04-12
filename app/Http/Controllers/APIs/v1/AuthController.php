<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $this->validate($request, [
            'password' => 'required|min:6',
            'email' => 'required|email',
            'remember_me' => 'nullable'
        ]);

        $email = $request->get('email');
        $password = $request->get('password');
        $remember_me = (int)$request->get('remember_me');

        if (Auth::attempt(['email' => $email, 'password' => $password], $remember_me)) {

            $user = Auth::user();

            // generate a new token
            $token_result = $user->createToken('Personal Access Token');
            $token = $token_result->token;
            $access_token = $token_result->accessToken;

            if ($remember_me == 0)
                $token->expires_at = Carbon::now()->addWeeks(1);

            $token->save();

            return response()->json([
                'status' => true,
                'status_code' => 200,
                'access_token' => $access_token,
                'user' => $user,
            ], 200);

        } else {
            return response()->json([
                'status' => false,
                'status_code' => 401,
                'message' => 'Incorrect credential, unauthorised user!',
            ], 401);
        }

    }

    public function register(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|string', // consumer, or merchant
        ]);

        $name = $request->get('name');
        $email = $request->get('email');
        $password = $request->get('password');
        $hashed_password = Hash::make($password);
        $role = $request->get('role');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $hashed_password
        ]);

        if (!$user) {
            return response()->json([
                'status' => false,
                'status_code' => 400,
                'message' => 'Failed to create a new user!',
            ], 400);
        }

        $user->assignRole($role);

        // generate a new token
        $token_result = $user->createToken('Personal Access Token');
        $access_token = $token_result->accessToken;

        return response()->json([
            'status' => true,
            'status_code' => 201,
            'access_token' => $access_token,
            'user' => $user,
        ], 201);

    }

}
