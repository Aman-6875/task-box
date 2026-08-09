<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Services\TaskService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TaskWebController extends Controller
{
    public function __construct(
        private readonly TaskService $taskService,
    ) {
    }

    public function index(): View {
        return view('tasks.index', [
            'tasks' => $this->taskService->listAll(),
        ]);
    }

    public function create(): View {
        return view('tasks.create');
    }

    public function store(StoreTaskRequest $request): RedirectResponse {
        $this->taskService->create($request->validated());

        return redirect()->route('tasks.index')->with('status', 'Task created successfully.');
    }

    public function edit(int $id): View {
        return view('tasks.edit', [
            'task' => $this->taskService->find($id),
        ]);
    }

    public function update(UpdateTaskRequest $request, int $id): RedirectResponse {
        $task = $this->taskService->find($id);
        $this->taskService->update($task, $request->validated());

        return redirect()->route('tasks.index')->with('status', 'Task updated successfully.');
    }

    public function destroy(int $id): RedirectResponse {
        $task = $this->taskService->find($id);
        $this->taskService->delete($task);

        return redirect()->route('tasks.index')->with('status', 'Task deleted successfully.');
    }
}
