<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
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
                __('messages.auth.failed'),
                Response::HTTP_UNAUTHORIZED
            );
        }

        $user = Auth::user();

        return $this->responseSuccess([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60,
            'message' => __('messages.auth.login_success')
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
                __('messages.auth.register_server_error'),
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->responseSuccess([
            'user' => $result,
            'message' => __('messages.auth.register_success')
        ], Response::HTTP_CREATED);
    }
}
