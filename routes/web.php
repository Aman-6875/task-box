<?php

use App\Http\Controllers\TaskWebController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/tasks');

Route::resource('tasks', TaskWebController::class)->except(['show']);
