<?php

namespace App\Interfaces\TaskGroup;

use App\Interfaces\CrudRepositoryInterface;

interface TaskGroupRepositoryInterface extends CrudRepositoryInterface
{
    public function getAllByField(string $column, string $value);
}
