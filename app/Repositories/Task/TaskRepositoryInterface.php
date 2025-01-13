<?php

namespace App\Repositories\Task;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TaskRepositoryInterface
{
    public function all();

    public function paginate(int $page = 1, int $limit = 15): LengthAwarePaginator;

    public function create(array $data): Task;

    public function findOrFail(int $id): Task;

    public function update(array $data, int $id): Task;

    public function delete(int $id): bool;

    public function getTasksByProjectId(int $projectId);
}
