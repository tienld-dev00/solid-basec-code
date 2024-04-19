<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Services\Auth\RegisterService;

class RegisterUserController extends Controller
{
    public function store(RegisterRequest $request)
    {
        $result = resolve(RegisterService::class)->setParams($request->all())->handle();
        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Đăng ký tài khoản thành công!'
            ], 201);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Đăng ký tài khoản thất bại!'
            ], 500);
        }
    }

}
