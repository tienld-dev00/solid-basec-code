<?php

namespace App\Services\TaskGroup;

use App\Interfaces\TaskGroup\TaskGroupRepositoryInterface;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class CreateTaskGroupService extends BaseService
{
    protected $taskGroupRepository;

    public function __construct(TaskGroupRepositoryInterface $taskGroupRepository)
    {
        $this->taskGroupRepository = $taskGroupRepository;
    }

    public function handle()
    {
        try {
            return $this->taskGroupRepository->create($this->data);
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
