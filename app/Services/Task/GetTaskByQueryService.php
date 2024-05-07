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
            $builder = Task::query();

            //** Apply filters */
            if (isset($this->data['filters'])) {
                foreach ($this->data['filters'] as $column => $value) {
                    /** example $column => 'operator,value'|'value' */
                    if (in_array($column, Task::filterable)) {
                        $commaPosition = strpos($value, ',');

                        if ($commaPosition) {
                            $operator = substr($value, 0, $commaPosition);
                            $valueFilter = substr($value, $commaPosition + 1);
                            $this->taskRepository->applyFilter(
                                $builder,
                                $column,
                                $valueFilter,
                                $operator
                            );
                            continue;
                        }

                        $this->taskRepository->applyFilter(
                            $builder,
                            $column,
                            $value,
                        );
                    }
                }
            }

            //** Apply search */
            $this->taskRepository->applySearch(
                $builder,
                Task::searchable,
                $this->data['search'] ?? ''
            );

            //** Apply sorts */
            if (isset($this->data['sorts'])) {
                foreach ($this->data['sorts'] as $column => $direction) {
                    /** example $column => 'desc' */
                    if (in_array($column, Task::sortable)) {
                        $this->taskRepository->applySort($builder, $column, $direction);
                    }
                }
            }

            return $builder->get();
        } catch (Exception $e) {
            Log::info($e);

            return false;
        }
    }
}
