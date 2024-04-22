<?php

namespace App\Services\Auth;

use App\Services\User\CreateUserService;
use Illuminate\Support\Facades\Log;

class RegisterUserService extends CreateUserService
{
    public function handle()
    {
        try {
            return parent::handle();
        } catch (\Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
