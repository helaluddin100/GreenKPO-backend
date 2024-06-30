<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;



Route::get('/posts', [PostController::class, 'getPosts']);
Route::get('/last-post', [PostController::class, 'getLastPost']);
Route::get('/posts/{slug}', [PostController::class, 'getPostBySlug']);
Route::get('/latest-posts', [PostController::class, 'latestPosts']);


//product
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/product/{id}', [ProductController::class, 'getProductId']);
