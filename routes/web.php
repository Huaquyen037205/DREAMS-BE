<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminManageController;
use App\Http\Middleware\CheckAdmin;

// Web Routes
// Route::get('/', [PageController::class, 'home']);
// Route::get('/login', [PageController::class, 'login']);
// Route::post('/login', [AuthController::class, 'login']);
// Route::post('/register', [AuthController::class, 'register']);
// Route::get('/reset-password', [AuthController::class, 'resetPassword']);
// Route::post('/logout', [AuthController::class, 'logout']);
//product routes

route::get('/product', [ProductController::class, 'product']);
route::get('/hotProduct', [ProductController::class, 'hotProduct']);
route::get('/viewProduct', [ProductController::class, 'viewProduct']);
route::get('/category', [ProductController::class, 'category']);
route::get('/product/{id}', [ProductController::class, 'productById']);
route::get('/search', [ProductController::class, 'searchProduct']);

//Message
Route::get('/admin/message', [PageController::class, 'message']);

//Review
Route::get('/review', [ProductController::class, 'reviews']);
Route::post('/review', [ProductController::class, 'reviews']);


// Admin Routes
Route::get('/dashboard', [PageController::class, 'dashBoard']);
Route::get('/admin/user/list', [PageController::class, 'userList']);
Route::get('/admin/user/list', [AdminUserController::class, 'userAdmin']);
Route::get('/admin/profile/user', [PageController::class, 'profileUser']);


//Auth Routes
Route::get('/admin/login', [PageController::class, 'loginAdmin']);
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);;

Route::get('/admin/forgotPassword', [PageController::class, 'forgotPasswordEmail']);
Route::post('/admin/forgotPassword', [AdminUserController::class, 'forgotPasswordAdmin']);
Route::get("/admin/email-forgot-password", [PageController::class, 'forgotPasswordAdmin']);

Route::get('/admin/forgot-password', [PageController::class, 'forgotPasswordAdmin']);
Route::get('/admin/reset-password', [AdminUserController::class, 'resetPasswordAdmin']);

Route::get('/admin/change-password', [PageController::class, 'changePassword']);
Route::post('/admin/change-password', [AdminUserController::class, 'changePasswordAdmin']);

//Product
Route::get('/admin/product/list', [PageController::class, 'productList']);
Route::get('/admin/product/{id}', [AdminController::class, 'productById'])->name('product.detail');
Route::get('/admin/product/list', [AdminController::class, 'productAdmin']);
Route::get('/search/admin/product/list', [AdminController::class, 'searchProductAdmin']);

Route::get('/admin/add', [PageController::class, 'addProduct']);
Route::post('/admin/product/add', [AdminController::class, 'addProduct']);
Route::get('/admin/product/edit/{id}', [PageController::class, 'editProduct']);
Route::put('/admin/product/edit/{id}', [AdminController::class, 'editProduct']);

//variant
Route::get('/admin/variant/list', [PageController::class, 'variantList']);
Route::get('/admin/variant/list', [AdminController::class, 'variantAdmin']);
Route::get('/admin/search/variant', [AdminController::class, 'searchVariantAdmin']);
Route::get('/admin/add/variant', [PageController::class, 'addVariant']);
Route::post('/admin/variant/add', [AdminController::class, 'addVariant']);
Route::get('/admin/variant/edit/{id}', [PageController::class, 'editVariant']);
Route::put('/admin/variant/edit/{id}', [AdminController::class, 'editVariant']);
Route::get('/admin/variant/delete/{id}', [AdminController::class, 'deleteVariant']);

Route::get('/admin/editUser/{id}', [PageController::class, 'editUserAdmin']);
Route::put('/admin/editUser/{id}', [AdminUserController::class, 'editUser']);


Route::prefix('/admin')->middleware(CheckAdmin::class)->group(function () {
    //Product
    route::get('/product', [AdminController::class, 'productAdmin']);
    Route::get('/category', [AdminController::class, 'categoryAdmin']);
    route::post('/addCategory', [AdminController::class, 'addCategory']);
    // route::get('/product/{id}', [AdminController::class, 'editProduct']);

    //User
    route::get('/searchUser', [AdminUserController::class, 'searchUser']);
    route::get('/user', [AdminUserController::class, 'userAdmin']);
    Route::get('/addUser', [PageController::class, 'addUserAdmin']);

});
