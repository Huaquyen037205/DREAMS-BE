<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
// use App\Http\Middleware\CheckAdmin;

// Web Routes
Route::get('/product', [ProductController::class, 'product']);
Route::get('/hotProduct', [ProductController::class, 'hotProduct']);
Route::get('/viewProduct', [ProductController::class, 'viewProduct']);
Route::get('/product/{id}', [ProductController::class, 'productById']);
Route::get('/search', [ProductController::class, 'searchProduct']);

// Admin Routes

//Product routes
Route::get('/admin/product', [AdminController::class, 'productAdmin']);
Route::get('/admin/category', [AdminController::class, 'categoryAdmin']);
Route::post('/admin/addCategory', [AdminController::class, 'addCategory']);
Route::patch('/admin/editCategory/{id}', [AdminController::class, 'editCategory']);
Route::delete('/admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory']);
Route::patch('/admin/addProduct', [AdminController::class, 'addProduct']);
Route::get('/admin/product/{id}', [AdminController::class, 'editProduct']);
Route::patch('/admin/updateProduct/{id}', [AdminController::class, 'updateProduct']);
Route::get('/admin/searchProduct', [AdminController::class, 'searchProductAdmin']);
Route::post('/admin/addProduct', [AdminController::class, 'addProduct']);
Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct']);
Route::post('/admin/addVariant', [AdminController::class, 'addVariant']);
Route::patch('/admin/editVariant/{id}', [AdminController::class, 'editVariant']);
Route::delete('/admin/deleteVariant/{id}', [AdminController::class, 'deleteVariant']);


//Login routes
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);
Route::post('/admin/logout', [AdminUserController::class, 'logoutAdmin']);

//User routes
Route::get('/admin/user', [AdminUserController::class, 'userAdmin']);
Route::get('/admin/searchUser', [AdminUserController::class, 'searchUser']);
Route::post('/admin/addUser', [AdminUserController::class, 'addUser']);
Route::patch('/admin/updateUser/{id}', [AdminUserController::class, 'updateUser']);
Route::patch('/admin/editUser/{id}', [AdminUserController::class, 'editUser']);
Route::delete('/admin/deleteUser/{id}', [AdminUserController::class, 'deleteUser']);













