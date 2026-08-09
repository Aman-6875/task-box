@extends('layouts.app')

@section('title', 'Edit Task')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">Edit Task</h1>

    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf
        @method('PUT')

        <div>
            <label for="title" class="mb-1 block text-sm font-medium">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $task->title) }}"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-medium">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">{{ old('description', $task->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-1 block text-sm font-medium">Status</label>
            <select name="status" id="status" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                @foreach (['pending', 'in_progress', 'completed'] as $status)
                    <option value="{{ $status }}" @selected(old('status', $task->status->value) === $status)>
                        {{ str_replace('_', ' ', $status) }}
                    </option>
                @endforeach
            </select>
            @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-5">
            <div class="flex-1">
                <label for="priority" class="mb-1 block text-sm font-medium">Priority</label>
                <select name="priority" id="priority" class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                    @foreach (['low', 'medium', 'high'] as $priority)
                        <option value="{{ $priority }}" @selected(old('priority', $task->priority->value) === $priority)>
                            {{ ucfirst($priority) }}
                        </option>
                    @endforeach
                </select>
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex-1">
                <label for="due_date" class="mb-1 block text-sm font-medium">Due Date</label>
                <input type="date" name="due_date" id="due_date" value="{{ old('due_date', $task->due_date?->toDateString()) }}"
                    class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
                @error('due_date')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                Save Changes
            </button>
            <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">Cancel</a>
        </div>
    </form>
@endsection
