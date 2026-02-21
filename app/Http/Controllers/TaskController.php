<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\MoveTaskRequest;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TaskController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService
    ) {}

    public function create(CreateTaskRequest $request): JsonResponse
    {
        $task = $this->taskService->create($request->validated(), $request->user());

        return response()->json([
            'status' => 'success',
            'data' => $task,
        ], Response::HTTP_CREATED);
    }

    public function get(): JsonResponse
    {
        $tasks = auth()->user()->tasks()->orderBy('position')->get();

        return response()->json([
            'status' => 'success',
            'data' => $tasks,
        ]);
    }

    public function delete(Request $request, Task $task): JsonResponse
    {
        $this->taskService->delete($task);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function move(MoveTaskRequest $request, Task $task): JsonResponse
    {
        $this->taskService->move($request->validated(), $task);

        return response()->json(null);
    }
}
