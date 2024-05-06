<?php

namespace App\Repositories\Task;

use App\Interfaces\Task\TaskRepositoryInterface;
use App\Models\Task;
use App\Repositories\BaseRepository;

class TaskRepository extends BaseRepository implements TaskRepositoryInterface
{
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    /**
     * Get data with filter, sort and search
     * 
     * @param array $filters e.g. $filters[0] = [col,operator,value]
     * @param array $sorts e.g. $sorts[0] = [col,desc]
     * @param array $search e.g $search[0] = [col,value] 
     * @param int $limit
     * 
     * @return \Illuminate\Pagination\LengthAwarePaginator|Task[]
     */
    public function getByQuery(
        array $filters = [],
        array $sorts = [],
        array $search = [],
        int $limit = 0
    ) {
        $query = $this->model;

        /** Apply filters */
        $query = $query->where($filters);

        /** Apply search */
        if ($search) {
            $query = $query->where(function ($query) use ($search) {
                foreach ($search as $column => $value) {
                    $query = $query->orWhere($column, 'like', "%$value%");
                }
            });
        }

        /** Apply sorts */
        foreach ($sorts as $condition) {
            $query = $query->orderBy(...$condition);
        }

        if ($limit > 0) {
            return $query->paginate($limit);
        }

        return $query->get();
    }
}
