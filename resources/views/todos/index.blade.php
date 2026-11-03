<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo — Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", sans-serif; }
        .completed-title { text-decoration: line-through; opacity: 0.45; }
    </style>
</head>
<body class="min-h-screen bg-slate-100 text-slate-800 antialiased">
    <main class="mx-auto mt-16 w-full max-w-md rounded-2xl bg-white p-8 shadow-lg shadow-slate-200/60">

        <h1 class="text-2xl font-bold tracking-tight">My Day</h1>

        <div class="mt-1 text-sm text-slate-500">
            @if($remaining > 0)
                {{ $remaining }} task{{ $remaining === 1 ? '' : 's' }} remaining
            @else
                All done. Enjoy the calm.
            @endif
        </div>

        <form action="{{ route('todos.store') }}" method="POST" class="mt-6 flex gap-2">
            @csrf
            <input type="text" name="title" placeholder="Add a task…"
                   value="{{ old('title') }}" autofocus
                   class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-2.5 text-sm outline-none transition focus:border-indigo-400 focus:bg-white focus:ring-2 focus:ring-indigo-100">
            <button type="submit"
                    class="rounded-xl bg-indigo-600 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-indigo-500">
                Add
            </button>
        </form>

        @error('title')
            <p class="mt-2 text-sm text-rose-500">{{ $message }}</p>
        @enderror

        @if($todos->isEmpty())
            <div class="mt-10 mb-6 text-center text-sm text-slate-400">
                @if($filter !== 'all') Nothing here — try another filter. @else Nothing yet. Write your first task above. @endif
            </div>
        @else
            <ul class="mt-6 divide-y divide-slate-100">
                @foreach($todos as $todo)
                    <li class="group flex items-center gap-3 py-2.5">
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf @method('PATCH')
                            <input type="checkbox" {{ $todo->completed ? 'checked' : '' }}
                                   onchange="this.form.submit()"
                                   class="h-5 w-5 cursor-pointer rounded border-slate-300 text-indigo-600 focus:ring-indigo-300">
                            <input type="hidden" disabled>
                        </form>
                        <span class="flex-1 text-sm {{ $todo->completed ? 'completed-title' : '' }}">{{ $todo->title }}</span>
                        <form action="{{ route('todos.destroy', $todo) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit"
                                    class="text-xs text-slate-300 transition hover:text-rose-500">✕</button>
                        </form>
                    </li>
                @endforeach
            </ul>

            <div class="mt-4 flex gap-2 text-xs">
                <a href="{{ route('todos.index', ['filter' => 'all']) }}"
                   class="rounded-lg px-3 py-1.5 transition {{ $filter === 'all' ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-500 hover:bg-slate-100' }}">All</a>
                <a href="{{ route('todos.index', ['filter' => 'active']) }}"
                   class="rounded-lg px-3 py-1.5 transition {{ $filter === 'active' ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-500 hover:bg-slate-100' }}">Active</a>
                <a href="{{ route('todos.index', ['filter' => 'done']) }}"
                   class="rounded-lg px-3 py-1.5 transition {{ $filter === 'done' ? 'bg-indigo-50 text-indigo-600 font-medium' : 'text-slate-500 hover:bg-slate-100' }}">Done</a>
            </div>
        @endif

    </main>
</body>
</html>
