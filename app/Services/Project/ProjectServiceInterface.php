<?php

namespace App\Services\Project;

use App\Models\Project;

interface ProjectServiceInterface
{
    public function create(array $data): Project;

    public function update(int $id, array $data): Project;

    public function delete(int $id): bool;
}
