<?php

namespace App\Services\Auth;

use App\Interfaces\Auth\AuthRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class RegisterService extends BaseService
{
    protected $authRepository;

    public function __construct(AuthRepositoryInterface $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function handle()
    {
        try {
            return $this->authRepository->register($this->data);
        } catch (Exception $e) {
            Log::info($e);
            return false;
        }
    }
}
