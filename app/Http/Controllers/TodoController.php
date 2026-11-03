<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    public function index()
    {
        return view('todos.index', [
            'filter' => request('filter', 'all'),
            'todos' => match (request('filter', 'all')) {
                'active' => Todo::where('completed', false)->latest()->get(),
                'done' => Todo::where('completed', true)->latest()->get(),
                default => Todo::latest()->get(),
            },
            'remaining' => Todo::where('completed', false)->count(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
        ]);

        Todo::create($validated);

        return redirect()->route('todos.index');
    }

    public function toggle(Todo $todo): RedirectResponse
    {
        $todo->update(['completed' => ! $todo->completed]);

        return redirect()->route('todos.index');
    }

    public function destroy(Todo $todo): RedirectResponse
    {
        $todo->delete();

        return redirect()->route('todos.index');
    }
}
