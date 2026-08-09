@extends('layouts.app')

@section('title', 'All Tasks')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">Tasks</h1>

    @if ($tasks->isEmpty())
        <div class="rounded-lg border border-dashed border-slate-300 bg-white px-6 py-12 text-center text-slate-500">
            No tasks yet. <a href="{{ route('tasks.create') }}" class="font-medium text-slate-900 underline">Create your first task</a>.
        </div>
    @else
        <ul class="space-y-3">
            @foreach ($tasks as $task)
                <li class="flex items-center justify-between rounded-lg border border-slate-200 bg-white px-5 py-4 shadow-sm">
                    <div>
                        <p class="font-medium">{{ $task->title }}</p>
                        @if ($task->description)
                            <p class="mt-1 text-sm text-slate-500">{{ $task->description }}</p>
                        @endif
                        <div class="mt-2 flex flex-wrap items-center gap-2">
                            <span @class([
                                'inline-block rounded-full px-2.5 py-0.5 text-xs font-medium',
                                'bg-amber-100 text-amber-800' => $task->status->value === 'pending',
                                'bg-blue-100 text-blue-800' => $task->status->value === 'in_progress',
                                'bg-green-100 text-green-800' => $task->status->value === 'completed',
                            ])>
                                {{ str_replace('_', ' ', $task->status->value) }}
                            </span>

                            <span @class([
                                'inline-block rounded-full px-2.5 py-0.5 text-xs font-medium',
                                'bg-slate-100 text-slate-600' => $task->priority->value === 'low',
                                'bg-orange-100 text-orange-800' => $task->priority->value === 'medium',
                                'bg-red-100 text-red-800' => $task->priority->value === 'high',
                            ])>
                                {{ ucfirst($task->priority->value) }} priority
                            </span>

                            @if ($task->due_date)
                                <span class="text-xs text-slate-500">Due {{ $task->due_date->format('M j, Y') }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="flex shrink-0 items-center gap-3 text-sm">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="font-medium text-slate-600 hover:text-slate-900">Edit</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Delete this task?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="font-medium text-red-600 hover:text-red-800">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
@endsection
