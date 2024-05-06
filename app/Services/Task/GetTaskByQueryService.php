<?php

namespace App\Services\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Models\Task;
use App\Services\BaseService;
use Exception;
use Illuminate\Support\Facades\Log;

class GetTaskByQueryService extends BaseService
{
    protected $taskRepository;

    public function __construct(TaskRepositoryInterface $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function handle()
    {
        try {
            return $this->taskRepository->getByQuery(
                $this->data['filters'] ?? [],
                $this->data['sorts'] ?? [],
                $this->data['search'] ?? [],
            );
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }

    /**
     * Set parameters for filtering, sorting, and searching from request query.
     * 
     * @param array|null $data The data containing filters, sorts, and search text
     * @return $this
     */
    public function setParams($data = null)
    {
        $filters = [];
        $sorts = [];
        $search = [];

        if (isset($data['filters'])) {
            foreach ($data['filters'] as $column => $value) {
                if (in_array($column, Task::$filterable)) {
                    array_push($filters, [$column, ...explode(',', $value)]);
                }
            }
        }

        if (isset($data['sorts'])) {
            foreach ($data['sorts'] as $column => $direction) {
                if (in_array($column, Task::$sortable)) {
                    array_push($sorts, [$column, ...explode(',', $direction)]);
                }
            }
        }

        if (isset($data['search'])) {
            foreach (Task::$searchable as $column) {
                $search[$column] = $data['search'];
            }
        }

        $this->data['filters'] = $filters;
        $this->data['sorts'] = $sorts;
        $this->data['search'] = $search;

        return $this;
    }
}
