<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {
    }

    public function index(): JsonResponse {
        $tasks = $this->taskService->listAll();

        return response()->json([
            'data' => TaskResource::collection($tasks),
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse {
        $task = $this->taskService->create($request->validated());

        return response()->json([
            'data' => new TaskResource($task),
        ], 201);
    }

    public function show(int $id): JsonResponse {
        $task = $this->taskService->find($id);

        return response()->json([
            'data' => new TaskResource($task),
        ]);
    }

    public function update(UpdateTaskRequest $request, int $id): JsonResponse {
        $task = $this->taskService->find($id);
        $task = $this->taskService->update($task, $request->validated());

        return response()->json([
            'data' => new TaskResource($task),
        ]);
    }

    public function destroy(int $id): JsonResponse {
        $task = $this->taskService->find($id);
        $this->taskService->delete($task);

        return response()->json(null, 204);
    }
}
