<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tasks') - Task Manager</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <nav class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-3xl items-center justify-between px-6 py-4">
            <a href="{{ route('tasks.index') }}" class="text-lg font-semibold tracking-tight">Task Manager</a>
            <a href="{{ route('tasks.create') }}" class="rounded-md bg-slate-900 px-4 py-2 text-sm font-medium text-white hover:bg-slate-700">
                + New Task
            </a>
        </div>
    </nav>

    <main class="mx-auto max-w-3xl px-6 py-10">
        @if (session('status'))
            <div class="mb-6 rounded-md border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 rounded-md border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                {{ session('error') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
