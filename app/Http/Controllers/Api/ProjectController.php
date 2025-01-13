<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\ProjectIndexRequest;
use App\Http\Requests\Project\ProjectRequest;
use App\Http\Resources\Project\ProjectResource;
use App\Models\Project;
use App\Repositories\Project\ProjectRepositoryInterface;
use App\Services\Project\ProjectServiceInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProjectController extends Controller
{
    public function index(ProjectIndexRequest $request, ProjectRepositoryInterface $repository): JsonResponse
    {
        $page = $request->query('page', 1);
        $limit = $request->query('limit', 15);

        $tasks = $repository->paginate($page, $limit);

        return response()->json(ProjectResource::collection($tasks));
    }

    public function store(ProjectRequest $request, ProjectServiceInterface $service): JsonResponse
    {
        return response()->json(ProjectResource::make($service->create($request->validated())), Response::HTTP_CREATED);
    }

    public function update(ProjectRequest $request, int $id, ProjectServiceInterface $service): JsonResponse
    {
        return response()->json(ProjectResource::make($service->update($id, $request->validated())));
    }

    public function show(int $id, ProjectRepositoryInterface $repository): JsonResponse
    {
        return response()->json(ProjectResource::make($repository->findOrFail($id)));
    }

    public function destroy(int $id, ProjectServiceInterface $service): JsonResponse
    {
        $service->delete($id);

        return response()->json(status: Response::HTTP_NO_CONTENT);
    }
}
