<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminManageController;
// use App\Http\Middleware\CheckAdmin;

// Web Routes:
Route::get('/product', [ProductController::class, 'product']);
Route::get('/hotProduct', [ProductController::class, 'hotProduct']);
Route::get('/viewProduct', [ProductController::class, 'viewProduct']);
Route::get('/product/{id}', [ProductController::class, 'productById']);
Route::get('/search', [ProductController::class, 'searchProduct']);



// Admin Routes
//Product routes
Route::get('/admin/product', [AdminController::class, 'productAdmin']);
//Category
Route::get('/admin/category', [AdminController::class, 'categoryAdmin']);
Route::post('/admin/addCategory', [AdminController::class, 'addCategory']);
Route::patch('/admin/editCategory/{id}', [AdminController::class, 'editCategory']);
Route::delete('/admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory']);

//Product
Route::get('/admin/product/{id}', [AdminController::class, 'editProduct']);
Route::patch('/admin/updateProduct/{id}', [AdminController::class, 'updateProduct']);
Route::get('/admin/searchProduct', [AdminController::class, 'searchProductAdmin']);
Route::post('/admin/addProduct', [AdminController::class, 'addProduct']);
Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct']);

//Variant
Route::post('/admin/addVariant', [AdminController::class, 'addVariant']);
Route::patch('/admin/editVariant/{id}', [AdminController::class, 'editVariant']);
Route::delete('/admin/deleteVariant/{id}', [AdminController::class, 'deleteVariant']);

//Img
Route::post('/admin/addImg', [AdminController::class, 'addImg']);
Route::patch('/admin/editImg/{id}', [AdminController::class, 'editImg']);
Route::delete('/admin/deleteImg/{id}', [AdminController::class, 'deleteImg']);

//Login routes
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);
Route::post('/admin/logout', [AdminUserController::class, 'logoutAdmin']);

//Review
Route::get('/admin/review', [AdminManageController::class, 'review']);

//Order routes
Route::get('/admin/order', [AdminManageController::class, 'ShowOrder']);
Route::get('/admin/order/sold', [AdminManageController::class, 'OrderSold']);
Route::patch('/admin/order/cancel', [AdminManageController::class, 'OrderCancel']);
Route::get('/admin/orderDetail/{id}', [AdminManageController::class, 'OrderDetail']);
Route::get('/admin/topSoldProduct', [AdminManageController::class, 'topSoldProduct']);

//Discount routes
Route::get('/admin/discount', [AdminManageController::class, 'discount']);
Route::post('/admin/add/discount', [AdminManageController::class, 'addDiscount']);
Route::patch('/admin/update/discount/{id}', [AdminManageController::class, 'updateDiscount']);
Route::delete('/admin/delete/discount/{id}', [AdminManageController::class, 'deleteDiscount']);

//User routes
Route::get('/admin/user', [AdminUserController::class, 'userAdmin']);
Route::get('/admin/searchUser', [AdminUserController::class, 'searchUser']);
Route::post('/admin/addUser', [AdminUserController::class, 'addUser']);
Route::patch('/admin/updateUser/{id}', [AdminUserController::class, 'updateUser']);
Route::patch('/admin/editUser/{id}', [AdminUserController::class, 'editUser']);
Route::delete('/admin/deleteUser/{id}', [AdminUserController::class, 'deleteUser']);













