<?php

namespace App\Services\Project;

use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;

class ProjectService implements ProjectServiceInterface
{
    protected ProjectRepositoryInterface $repository;

    public function __construct(ProjectRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): Project
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Project
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
