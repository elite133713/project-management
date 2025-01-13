<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\TaskIndexRequest;
use App\Http\Requests\Task\TaskRequest;
use App\Http\Resources\Task\TaskResource;
use App\Models\Task;
use App\Repositories\Task\TaskRepositoryInterface;
use App\Services\Task\TaskServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{

    public function index(TaskIndexRequest $request, TaskRepositoryInterface $repository): JsonResponse
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 15);

        $tasks = $repository->paginate($page, $limit);

        return response()->json(TaskResource::collection($tasks));
    }

    public function getTasksByProject(int $project_id, TaskRepositoryInterface $repository): JsonResponse
    {
        return response()->json(TaskResource::collection($repository->getTasksByProjectId($project_id)));
    }

    public function store(TaskRequest $request, int $project_id, TaskServiceInterface $service): JsonResponse
    {
        $data = $request->validated();
        $data['project_id'] = $project_id;

        return response()->json(TaskResource::make($service->create($data)), Response::HTTP_CREATED);
    }

    public function show(int $id, TaskRepositoryInterface $repository): JsonResponse
    {
        return response()->json(TaskResource::make($repository->findOrFail($id)));
    }

    public function update(TaskRequest $request, int $id, TaskServiceInterface $service): JsonResponse
    {
        return response()->json(TaskResource::make($service->update($id, $request->validated())));
    }

    public function destroy(int $id, TaskServiceInterface $service): JsonResponse
    {
        $service->delete($id);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
