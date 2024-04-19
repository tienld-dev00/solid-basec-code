<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\Auth\LoginService;


class LoginUserController extends Controller
{
    public function store(LoginRequest $request)
    {
        $result = resolve(LoginService::class)->setParams($request->all())->handle();
        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng nhập thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Email hoặc password sai!'
            ], 500);
        }
    }

}
