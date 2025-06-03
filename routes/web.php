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
use App\Http\Controllers\FlashSaleController;
use App\Http\Controllers\CateList;

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


// Flash Sale Routes
Route::prefix('admin/flash-sale')->group(function () {
    Route::get('/', [FlashSaleController::class, 'index'])->name('flashsale.list');
    Route::get('/create', [FlashSaleController::class, 'create'])->name('flashsale.create');
    Route::post('/', [FlashSaleController::class, 'store'])->name('flashsale.store');
    Route::get('/{id}/products', [FlashSaleController::class, 'showProducts'])->name('flashsale.products');
    Route::post('/{id}/add-product', [FlashSaleController::class, 'addProduct'])->name('flashsale.addProduct');
    Route::get('/{id}/edit', [FlashSaleController::class, 'edit'])->name('flashsale.edit');
    Route::put('/{id}', [FlashSaleController::class, 'update'])->name('flashsale.update');
    Route::delete('/{id}', [FlashSaleController::class, 'destroy'])->name('flashsale.destroy');
    Route::get('/{id}', [FlashSaleController::class, 'show'])->name('flashsale.show');
     // Route xử lý cập nhật sản phẩm Flash Sale
    Route::put('{flashsale}/variant/{variant}', [FlashSaleController::class, 'updateVariant'])->name('flashsale.variant.update');
    Route::delete('{flashsale}/variant/{variant}', [FlashSaleController::class, 'destroyVariant'])->name('flashsale.variant.destroy');
});

// Category Routes
// Danh sách danh mục
Route::get('/admin/categories', [CateList::class, 'index'])->name('categories.index');
// Thêm danh mục (xử lý form POST)
Route::post('/admin/categories', [CateList::class, 'store'])->name('categories.store');
// Chi tiết danh mục
Route::get('/admin/categories/{id}', [CateList::class, 'show'])->name('categories.show');
// Hiển thị form chỉnh sửa danh mục
Route::put('/admin/categories/{id}', [CateList::class, 'update']);

