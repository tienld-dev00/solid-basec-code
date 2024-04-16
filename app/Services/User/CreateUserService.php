<?php

namespace App\Services\User;

use App\Interfaces\User\UserRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateUserService extends BaseService
{
    protected $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle()
    {
        try {
            $this->userRepository->create($this->data);
            // @todo edit here
            // @todo edit here

            return true;
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
