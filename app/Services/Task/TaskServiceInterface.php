<?php

namespace App\Services\Task;

use App\Models\Task;

interface TaskServiceInterface
{
    public function create(array $data): Task;

    public function update(int $id, array $data): Task;

    public function delete(int $id): bool;
}
