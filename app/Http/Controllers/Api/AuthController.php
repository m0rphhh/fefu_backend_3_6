<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\OpenApi\RequestBodies\AuthRequestBody;
use App\OpenApi\RequestBodies\StoreAppealRequestBody;
use App\OpenApi\Responses\ApiTokenResponse;
use App\OpenApi\Responses\AppealOkResponse;
use App\OpenApi\Responses\AppealValidationErrorsResponse;
use App\OpenApi\Responses\AuthValidationErrorsResponse;
use App\OpenApi\Responses\LogoutResponse;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Vyuldashev\LaravelOpenApi\Attributes as OpenApi;

#[OpenApi\PathItem]
class AuthController extends Controller
{
    /**
     * register
     *
     * @return JsonResponse
     *
     * @method POST
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\RequestBody(factory: AuthRequestBody::class)]
    #[OpenApi\Response(factory: ApiTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthValidationErrorsResponse::class, statusCode: 422)]
    public function register(RegisterRequest $request)
    {
        $user = User::updateOrCreate([
            'email' => $request->input('email')
        ],[
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'app_logged_in_at' => Carbon::now(),
            'app_registered_at' => Carbon::now()
        ]);

        Auth::login($user);

        return new JsonResponse([
            'token' => $user->createToken('api')->plainTextToken,
        ]);
    }

    /**
     * login
     *
     * @return JsonResponse
     *
     * @method POST
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\RequestBody(factory: AuthRequestBody::class)]
    #[OpenApi\Response(factory: ApiTokenResponse::class, statusCode: 200)]
    #[OpenApi\Response(factory: AuthValidationErrorsResponse::class, statusCode: 422)]
    public function login(LoginRequest $request)
    {
        if (Auth::attempt($request->validated(), true)) {
            $user = Auth::user();
            $user->app_logged_in_at = Carbon::now();
            $user->save();

            return new JsonResponse([
                'token' => Auth::user()->createToken('api')->plainTextToken,
            ]);
        }

        return new JsonResponse([
            'errors' => [
                'Неверный логин или пароль'
            ]
        ], 422);
    }

    /**
     * logout
     *
     * @return JsonResponse
     *
     * @method POST
     */
    #[OpenApi\Operation(tags: ['auth'])]
    #[OpenApi\Response(factory: LogoutResponse::class, statusCode: 200)]
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return new JsonResponse([]);
    }
}
