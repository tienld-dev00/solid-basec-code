<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Services\Auth\RegisterUserService;
use Illuminate\Http\Response as HttpResponse;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Method to handle login request
     * @param LoginRequest $request
     * @return HttpResponse
     */
    public function login(LoginRequest $request)
    {
        if (!$token = Auth::attempt($request->validated())) {
            return $this->responseErrors(
                __('auth.failed'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = Auth::user();

        return $this->responseSuccess([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'message' => __('auth.login_success')
        ]);
    }

    /**
     * Method to handle register request
     * @param RegisterRequest $request
     * @return HttpResponse
     */
    public function register(RegisterRequest $request)
    {
        $result = resolve(RegisterUserService::class)->setParams($request->validated())->handle();

        if (!$result) {
            return $this->responseErrors(
                __('auth.register_server_error'),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->responseSuccess([
            'user' => $result,
            'message' => __('auth.register_success')
        ], Response::HTTP_CREATED);
    }
}
