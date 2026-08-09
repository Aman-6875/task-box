<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TaskNotFoundException extends Exception
{
    public function __construct(int $taskId) {
        parent::__construct("Task with ID {$taskId} was not found.");
    }

    public function render(Request $request): JsonResponse|RedirectResponse {
        if ($request->expectsJson()) {
            return response()->json([
                'message' => $this->getMessage(),
            ], 404);
        }

        return redirect()->route('tasks.index')->with('error', $this->getMessage());
    }
}
