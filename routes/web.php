<?php

use App\Http\Controllers\TodoController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::resource('todos', TodoController::class)->only(['index', 'store', 'destroy'])->parameters(['todos' => 'todo']);
Route::patch('todos/{todo}/toggle', [TodoController::class, 'toggle'])->name('todos.toggle');
