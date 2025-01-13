<?php

namespace App\Services\Task;

use App\Repositories\Task\TaskRepositoryInterface;
use App\Models\Task;

class TaskService implements TaskServiceInterface
{
    protected TaskRepositoryInterface $repository;

    public function __construct(TaskRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(array $data): Task
    {
        return $this->repository->create($data);
    }

    public function update(int $id, array $data): Task
    {
        return $this->repository->update($data, $id);
    }

    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
