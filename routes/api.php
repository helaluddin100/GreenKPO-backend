<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\ApiController;

Route::get('/posts', [PostController::class, 'getPosts']);
Route::get('/last-post', [PostController::class, 'getLastPost']);
Route::get('/posts/{slug}', [PostController::class, 'getPostBySlug']);
Route::get('/latest-posts', [PostController::class, 'latestPosts']);


//product
Route::get('/products', [ProductController::class, 'getAllProducts']);
Route::get('/product/{id}', [ProductController::class, 'getProductId']);


//contact Email
Route::post('/contact', [ContactController::class, 'store']);

//slider
Route::get('/sliders', [ApiController::class, 'slider']);
Route::get('/faqs/carbon-democratisation', [ApiController::class, 'carbon_faq']);
Route::get('/faqs/why-should-i-consider-green-kpo', [ApiController::class, 'considerGreenKpo']);
Route::get('/faqs/product', [ApiController::class, 'faqProduct']);
Route::get('settings', 'App\Http\Controllers\Api\SettingController@index')->name('api.settings.index');
