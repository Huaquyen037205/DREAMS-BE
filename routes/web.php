<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminManageController;
use App\Http\Middleware\CheckAdmin;

// Web Routes
Route::get('/test/product', [PageController::class, 'product']);
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

 //Auth Routes
Route::get('/admin/login', [PageController::class, 'loginAdmin'])->name('Admin.Login');
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);
Route::post('/logout', [AdminUserController::class, 'logoutAdmin']);
Route::get('/forgotPassword', [PageController::class, 'forgotPasswordEmail']);
Route::post('/forgotPassword', [AdminUserController::class, 'forgotPasswordAdmin']);
Route::get("/email-forgot-password", [PageController::class, 'forgotPasswordAdmin']);
Route::get('/forgot-password', [PageController::class, 'forgotPasswordAdmin']);
Route::get('/reset-password', [AdminUserController::class, 'resetPasswordAdmin']);
Route::get('/change-password', [PageController::class, 'changePassword']);
Route::post('/change-password', [AdminUserController::class, 'changePasswordAdmin']);

Route::post('/admin/product/add-img', [AdminController::class, 'addImg']);
//Review
Route::get('/review', [ProductController::class, 'reviews']);
Route::post('/review', [ProductController::class, 'reviews']);

Route::prefix('/admin')->middleware(['auth', CheckAdmin::class])->group(function () {
    //Product
    Route::get('/product/list', [PageController::class, 'productList']);
    Route::get('/product/{id}', [AdminController::class, 'productById'])->name('product.detail');
    Route::get('/product/list', [AdminController::class, 'productAdmin']);
    Route::get('/search/product/list', [AdminController::class, 'searchProductAdmin']);
    Route::get('/add', [PageController::class, 'addProduct']);
    Route::post('/product/add', [AdminController::class, 'addProduct']);
    Route::get('/product/edit/{id}', [PageController::class, 'editProduct']);
    Route::put('/product/edit/{id}', [AdminController::class, 'editProduct']);


    // Admin Routes
    Route::get('/dashboard', [PageController::class, 'dashBoard']);
    Route::get('/user/list', [PageController::class, 'userList']);
    Route::get('/user/list', [AdminUserController::class, 'userAdmin']);
    Route::get('/profile/user', [PageController::class, 'profileUser']);

    //Message
    Route::get('/message', [PageController::class, 'message']);

    //variant
    Route::get('/variant/list', [PageController::class, 'variantList']);
    Route::get('/variant/list', [AdminController::class, 'variantAdmin']);
    Route::get('/search/variant', [AdminController::class, 'searchVariantAdmin']);
    Route::get('/add/variant', [PageController::class, 'addVariant']);
    Route::post('/variant/add', [AdminController::class, 'addVariant']);
    Route::get('/variant/edit/{id}', [PageController::class, 'editVariant']);
    Route::put('/variant/edit/{id}', [AdminController::class, 'editVariant']);
    Route::get('/variant/delete/{id}', [AdminController::class, 'deleteVariant']);
});
