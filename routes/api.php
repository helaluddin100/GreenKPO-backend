<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;



Route::get('/posts', [PostController::class, 'getPosts']);
Route::get('/last-post', [PostController::class, 'getLastPost']);
