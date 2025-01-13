<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProjectRepositoryInterface
{
    public function all();

    public function paginate(int $page = 1, int $limit = 15): LengthAwarePaginator;

    public function create(array $data): Project;

    public function findOrFail(int $id): Project;

    public function update(array $data, int $id): Project;

    public function delete(int $id): bool;
}
