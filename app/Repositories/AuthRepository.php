<?php

namespace App\Repositories;

use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Services\User\CreateUserService;
use App\Services\User\FindUserByEmailService;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{

    public function __construct()
    {
    }

    public function register(array $data)
    {
        $data['password'] = bcrypt($data['password']);
        $user = resolve(CreateUserService::class)->setParams($data)->handle();
        if ($user) {
            Auth::login($user);
            return true;
        }
        return false;
    }

    public function login(array $data)
    {
        $user = resolve(FindUserByEmailService::class)->setParams($data['email'])->handle();

        if ($user) {
            if (Auth::attempt($data)) {
                return true;
            }
        }
        return false;
    }
}
