<?php

use App\Http\Controllers\TaskWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

Route::get('/version', fn () => response()->json([
    'commit' => config('app.version'),
    'env' => config('app.env'),
]));

Route::resource('tasks', TaskWebController::class)->except(['show']);
