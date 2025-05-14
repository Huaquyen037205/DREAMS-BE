<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PageController;
use App\Http\Middleware\CheckAdmin;

// Web Routes
route::get('/product', [ProductController::class, 'product']);
route::get('/hotProduct', [ProductController::class, 'hotProduct']);
route::get('/viewProduct', [ProductController::class, 'viewProduct']);
route::get('/category', [ProductController::class, 'category']);
route::get('/product/{id}', [ProductController::class, 'productById']);
route::get('/search', [ProductController::class, 'searchProduct']);

// Admin Routes
Route::get('/admin/login', [PageController::class, 'loginAdmin']);
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);

Route::prefix('/admin')->middleware(CheckAdmin::class)->group(function () {
    //Product
    route::get('/product', [AdminController::class, 'productAdmin']);
    Route::get('/category', [AdminController::class, 'categoryAdmin']);
    route::post('/addCategory', [AdminController::class, 'addCategory']);
    route::get('/product/{id}', [AdminController::class, 'editProduct']);


    //User
    route::get('/searchUser', [AdminUserController::class, 'searchUser']);
    route::get('/user', [AdminUserController::class, 'userAdmin']);
    Route::get('/addUser', [PageController::class, 'addUserAdmin']);
    Route::get('/editUser/{id}', [PageController::class, 'editUserAdmin']);

});

