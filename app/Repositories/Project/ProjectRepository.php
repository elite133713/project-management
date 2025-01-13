<?php

namespace App\Repositories\Project;

use App\Models\Project;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProjectRepository implements ProjectRepositoryInterface
{

    public function all()
    {
        return Project::all();
    }
    public function paginate(int $page = 1, int $limit = 15): LengthAwarePaginator
    {
        return Project::paginate(page: $page, perPage: $limit);
    }

    public function create(array $data): Project
    {
        return Project::create($data);
    }

    public function findOrFail(int $id): Project
    {
        return Project::findOrFail($id);
    }

    public function update(array $data, int $id): Project
    {
        $project = $this->findOrFail($id);
        $project->update($data);

        return $project;
    }

    public function delete(int $id): bool
    {
        return $this->findOrFail($id)->delete();
    }
}
