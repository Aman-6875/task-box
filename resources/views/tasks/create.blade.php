@extends('layouts.app')

@section('title', 'New Task')

@section('content')
    <h1 class="mb-6 text-2xl font-semibold">New Task</h1>

    <form action="{{ route('tasks.store') }}" method="POST" class="space-y-5 rounded-lg border border-slate-200 bg-white p-6 shadow-sm">
        @csrf

        <div>
            <label for="title" class="mb-1 block text-sm font-medium">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title') }}"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">
            @error('title')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-1 block text-sm font-medium">Description</label>
            <textarea name="description" id="description" rows="4"
                class="w-full rounded-md border border-slate-300 px-3 py-2 text-sm focus:border-slate-500 focus:outline-none">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                Create Task
            </button>
            <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-slate-500 hover:text-slate-800">Cancel</a>
        </div>
    </form>
@endsection
