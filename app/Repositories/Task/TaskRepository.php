<?php

namespace App\Repositories\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Models\Task;
use App\Repositories\BaseRepository;
use Illuminate\Database\Eloquent\Builder;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * Apply filter to builder
     * 
     * @param Builder $builder
     * @param string $column
     * @param string $value
     * @param string $operator
     * 
     * @return Builder
     */
    public function applyFilter(
        Builder $builder,
        string $column,
        string $value,
        string $operator = '='
    ) {
        return $builder->where($column, $operator, $value);
    }

    /**
     * Apply search to builder
     * 
     * @param Builder $builder
     * @param array $columns
     * @param string $value
     * 
     * @return Builder
     */
    public function applySearch(
        Builder $builder,
        array $columns,
        string $value
    ) {
        return $builder->where(function ($builder) use ($columns, $value) {
            foreach ($columns as $column) {
                $builder->orWhere($column, 'like', '%' . $value . '%');
            }
        });
    }

    /**
     * Apply sort to builder
     * 
     * @param Builder $builder
     * @param string $column
     * @param string $direction
     * 
     * @return Builder
     */
    public function applySort(
        Builder $builder,
        string $column,
        string $direction = 'asc'
    ) {
        return $builder->orderBy($column, $direction);
    }
}
