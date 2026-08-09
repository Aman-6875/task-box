<?php

namespace App\Services;

use App\Exceptions\TaskNotFoundException;
use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class TaskService
{
    private const CACHE_KEY = 'tasks.all';

    private const CACHE_TTL_SECONDS = 60;

    public function listAll(): Collection {
        $rows = Cache::remember(self::CACHE_KEY, self::CACHE_TTL_SECONDS, function () {
            return Task::latest()->get()->toArray();
        });

        return Task::hydrate($rows);
    }

    public function find(int $taskId): Task {
        $task = Task::find($taskId);

        if (! $task) {
            throw new TaskNotFoundException($taskId);
        }

        return $task;
    }

    public function create(array $data): Task {
        $task = Task::create($data);

        Cache::forget(self::CACHE_KEY);

        return $task;
    }

    public function update(Task $task, array $data): Task {
        $task->update($data);

        Cache::forget(self::CACHE_KEY);

        return $task;
    }

    public function delete(Task $task): void {
        $task->delete();

        Cache::forget(self::CACHE_KEY);
    }
}
