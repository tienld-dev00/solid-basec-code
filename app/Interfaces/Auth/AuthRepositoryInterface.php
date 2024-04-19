<?php

namespace App\Interfaces\Auth;

interface AuthRepositoryInterface
{
    public function register(array $data);
}