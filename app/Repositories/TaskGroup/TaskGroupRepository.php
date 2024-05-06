<?php

namespace App\Repositories\TaskGroup;

use App\Interfaces\TaskGroup\TaskGroupRepositoryInterface;
use App\Models\TaskGroup;
use App\Repositories\BaseRepository;

class TaskGroupRepository extends BaseRepository implements TaskGroupRepositoryInterface
{
    public function __construct(TaskGroup $taskGroup)
    {
        $this->model = $taskGroup;
    }

    /**
     * Get user by field
     * 
     * @param string $column
     * @param string $value
     * 
     * @return TaskGroup[]
     */
    public function getAllByField(string $column, string $value)
    {
        return $this->model->where($column, '=', $value)->get();
    }
}
