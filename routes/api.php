<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/product', [ProductController::class, 'product']);
Route::get('/product/{id}', [ProductController::class, 'productById']);
