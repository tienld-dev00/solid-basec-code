<?php

namespace App\Interfaces\Task;

use App\Interfaces\CrudRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

interface TaskRepositoryInterface extends CrudRepositoryInterface
{
    public function applyFilter(Builder $builder, string $column, string $value, string $operator = '=');

    public function applySearch(Builder $builder, array $columns, string $value);

    public function applySort(Builder $builder, string $column, string $direction = 'asc');
}
