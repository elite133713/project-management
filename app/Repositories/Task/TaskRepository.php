<?php

namespace App\Repositories\Task;

use App\Models\Task;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TaskRepository implements TaskRepositoryInterface
{
    public function all()
    {
        return Task::all();
    }

    public function paginate(int $page = 1, int $limit = 15): LengthAwarePaginator
    {
        return Task::paginate(page: $page, perPage: $limit);
    }

    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function findOrFail(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function update(array $data, int $id): Task
    {
        $task = $this->findOrFail($id);
        $task->update($data);

        return $task;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }

    public function getTasksByProjectId(int $projectId)
    {
        return Task::where('project_id', $projectId)->get();
    }
}
