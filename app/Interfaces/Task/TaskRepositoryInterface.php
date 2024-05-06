<?php

namespace App\Interfaces\Task;

use App\Interfaces\CrudRepositoryInterface;

interface TaskRepositoryInterface extends CrudRepositoryInterface
{
    public function getByQuery(
        array $filters = [],
        array $sorts = [],
        array $searchText = [],
        int $limit = 0
    );
}
