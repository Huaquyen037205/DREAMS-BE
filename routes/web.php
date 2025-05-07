<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

route::get('/product', [ProductController::class, 'product']);
route::get('/product/{id}', [ProductController::class, 'productById']);
