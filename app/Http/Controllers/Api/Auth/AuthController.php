<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterRequest;
use App\Services\Auth\RegisterUserService;
use Exception;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Log;
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
            return $this->responseErrors(__('messages.auth.register_fail'));
        }

        return $this->responseSuccess([
            'user' => $result,
            'message' => __('messages.auth.register_success')
        ], Response::HTTP_CREATED);
    }

    /**
     * Get information about the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userInfo()
    {
        try {
            return $this->responseSuccess([
                'message' => __('messages.auth.get_user_info_success'),
                'user' => Auth::user()
            ]);
        } catch (Exception $e) {
            Log::error("logout fail", ['result' => $e->getMessage()]);

            return $this->responseErrors(__('messages.auth.get_user_info_fail'));
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {
            auth()->logout();

            return $this->responseSuccess(['message' => __('messages.auth.logout_success')]);
        } catch (Exception $e) {
            Log::error("logout fail", ['result' => $e->getMessage()]);

            return $this->responseErrors(__('messages.auth.logout_fail'));
        }
    }
}
