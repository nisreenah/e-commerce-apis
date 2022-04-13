<?php

namespace App\Http\Controllers\APIs\v1;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

/**
 * @group Auth
 * APIs for managing authentication (login, register)
 */
class AuthController extends Controller
{
    /**
     * Login
     *
     * @bodyParam email string required The user email. Example: nisreen.baik@gmail.sa
     * @bodyParam password string required The user password. Example: 123456
     * @bodyParam remember_me int If remember_me = 0, then the token will expires after one week. Example: 1
     *
     * @response 200
     * {
     * "status": true,
     * "status_code": 200,
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiODAyZjBmY2UxMzZkODI2ZWU2Y2U0OTY4Njg1NzI2Njc4ZWYyZWFhYTNhNmI4YjI2OTRkYzI3ZDdlMGQwNjg3MWJiNzUzZDRiOWU0N2JiNTAiLCJpYXQiOjE2NDk4NzQ1MDQuODk3Mjc0LCJuYmYiOjE2NDk4NzQ1MDQuODk3Mjc3LCJleHAiOjE2ODE0MTA1MDQuODg1MzEzLCJzdWIiOiIyIiwic2NvcGVzIjpbXX0.S-wKvJIgJdWplkZZgz5BOPGIah6mmrfrX9XHMpQfvrgqvLsNDQ7iv7QvSwFGs1OCuuEfmvGxiBa6c3s0kns02LobkKv87z9O2dNRNZD_5cSwu1S_PItPYkBNmGWXtOyOcUGgacvBk0lNu6soWCjoVTMS5ooZ8rmul_4nkEpB6y_fP6SIglIoLVO5rvdPjhLQUr-STY4R6Q_9OlM8qjS-1Nk3tBIdMlKFAsQarNto_-S-O2rkMeiOFDCzffh6QtncgEwDYQnBxxLDWlZgRL42FyoPM0Go03MBzN1QnxMmcA3t2RMDYDEkMMHEOoMpGwMjUhIbhQYRTRd2e5O2MpKmXjZRfIvpT5QC1q4ilRmCYg0bHI2dQS-D8MnidL9xMHzg7ImKZUC8CaCDhicoPj88aoFDQqHLL2ZjZWAAUueDq73nUIp7mu7WmGmlT13PNC6_XsHJAS1ci0RyDio9UlFLFLs9EIVUiirKmlHxcXQG1wQfcSKB5NyiLyIr4dpr-pOAZvqqgDn_8xU1qFIoFoNAvSKF06WI6nynqaomgsLje0ZCLDA-mL4kq4Jh2pcMpyD5f2DW47Y7LMfvPJU_pJmQEPTivUlLKpTZfhJZCLObIQJFVvNLERYrWPc43BBBUOZeo5K5HWtao1h3GxsJL7XH2pynGcKEJgHtXrworx3_b7Y",
     * "user": {
     * "id": 2,
     * "name": "Consumer",
     * "email": "consumer@gmail.com",
     * "email_verified_at": null,
     * "created_at": "2022-04-13T10:14:36.000000Z",
     * "updated_at": "2022-04-13T10:14:36.000000Z"
     * }
     * }
     *
     * @response 401
     * {
     * "status" : false,
     * "status_code" : 401,
     * "message" : "Incorrect credential, unauthorised user!"
     * }
     *
     * @response 422
     * {
     * "status": false,
     * "status_code": 422,
     * "message": "The given data was invalid.",
     * "errors": {
     * "password": [
     * "The password field is required."
     * ]
     * }
     * }
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
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

    /**
     * Register
     *
     * @bodyParam name string required The user name. Example: Nisreen Albaik
     * @bodyParam email string required The email of the user. Example: nisreen@gmail.com
     * @bodyParam password string required The user password. Example: 123456
     * @bodyParam password_confirmation string required The confirmation password. Example: 123456
     * @bodyParam role string required The role name (merchant, or consumer). Example: consumer
     * @response 201
     * {
     * "status": true,
     * "status_code": 201,
     * "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiN2JjNWU5YTU5MjA5NWEyOWQxZjliMGZmMjlhNWY3MTVmNzcyOGQ0NTlmOTc4NDU3ZTJmYjI4ZjdmMzk1YmYzNjRhOGZhNDM1ZDI3ZmE3NDUiLCJpYXQiOjE2NDk4NzQ4NTIuNjg4MzI4LCJuYmYiOjE2NDk4NzQ4NTIuNjg4MzMyLCJleHAiOjE2ODE0MTA4NTIuNjgyNzYsInN1YiI6IjQiLCJzY29wZXMiOltdfQ.p0GWtso5qn1VTSq3-cTfpkzWe3toURRbfZeiQCQUGWayjonZI9bNCqqMgI8gQ8_Q1eGAQLOtCIemnHRxSHULPhZ5CPiazRpnb_c8r_NlUaEETDVkutZGXptVRYomKBqbNl-eIeoECCocZZyI35OjRqOWCGYkmk51zFHIndl8PqcDum6DBAEh-k2teVl0DXN5PS55qh_vQ4GKPk_ptNYq88CSSjM4AYdi-GFQfhh-DkY3idQlE5AXXRxMF61HK5xoQ_hWDVgbxwHtovE_Ht-cDTl_tUBhHOWC0V3r74RiTwTg_pf64l2b0xMOXL504Ro-R1q1OHws1n8Ew3EYd7XX8s_rH_vsGthxG22ey976IqziunDUv8lhGPFIezSIFWz2GD2-XXRvzTVrPsS7WwO5ejo0nQuCcFNfziZhQN6UbSCyGCuN8Blrhv-w_9T4vz_ycnI3D3hPwEg_NwEGTbfA5odl-E9DsNZOSNxt6Sxfavwm17kjnw5WAJdhENxG6dJTffz8tipja4yPCSPH2OxIPR51Tb5Yz2MHvFCIt_52eP2LxnSk65v3B1MfUYE8G4J5LsPiT9eCRoJ-ow8RV2eQKvAkvVLbCzDkg7APCIj0TdIT-azeyjCg9-O4t6wB--aW-Nh9fXxD_NMGMLP-NUPkdoJYOaB-E3oQ4clzXP0Fzlg",
     * "user": {
     * "name": "Test name 03",
     * "email": "merchant-03@gmail.com",
     * "updated_at": "2022-04-13T18:34:12.000000Z",
     * "created_at": "2022-04-13T18:34:12.000000Z",
     * "id": 4,
     * "roles": [
     * {
     * "id": 1,
     * "name": "merchant",
     * "guard_name": "web",
     * "created_at": "2022-04-13T10:14:36.000000Z",
     * "updated_at": "2022-04-13T10:14:36.000000Z",
     * "pivot": {
     * "model_id": 4,
     * "role_id": 1,
     * "model_type": "App\\Models\\User"
     * }
     * }
     * ]
     * }
     * }
     *
     * @response 400
     * {
     * "status" : false,
     * "status_code" : 400,
     * "message" : "Failed to create a new user!"
     * }
     *
     * @response 422 {
     * "status": false,
     * "status_code" : 422,
     *      "message" : "The given data was invalid.",
     *      "errors" : {
     *          "email" : "The question field is required."
     *      }
     * }
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
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
