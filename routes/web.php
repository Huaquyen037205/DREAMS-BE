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
use App\Http\Controllers\DiscountController;

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


// Admin Routes
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
Route::post('/admin/product/edit-img/{id}', [AdminController::class, 'editImg']);
Route::delete('/admin/product/delete-img/{id}', [AdminController::class, 'deleteImg']);
//Review
Route::get('/review', [ProductController::class, 'reviews']);
Route::post('/review', [ProductController::class, 'reviews']);

Route::prefix('/admin')->middleware(['auth', CheckAdmin::class])->group(function () {
    //Product
    Route::get('/product/list', [PageController::class, 'productList']);
    Route::get('/product/{id}', [AdminController::class, 'productById'])->name('product.detail');
    Route::get('/product/list', [AdminController::class, 'productAdmin'])->name('product.list');
    Route::get('/search/product/list', [AdminController::class, 'searchProductAdmin']);
    Route::get('/add', [PageController::class, 'addProduct']);
    Route::post('/product/add', [AdminController::class, 'addProduct']);
    Route::get('/product/edit/{id}', [PageController::class, 'editProduct']);
    Route::put('/product/edit/{id}', [AdminController::class, 'editProduct']);

    //User
    Route::get('/dashboard', [PageController::class, 'dashBoard']);
    Route::get('/user/list', [PageController::class, 'userList']);
    Route::get('/user/list', [AdminUserController::class, 'userAdmin']);
    Route::get('/profile/user', [PageController::class, 'profileUser']);
    Route::get('/editUser/{id}', [PageController::class, 'editUserAdmin']);
    Route::put('/editUser/{id}', [AdminUserController::class, 'editUser']);
    Route::get('/searchUser', [AdminUserController::class, 'searchUser']);

    //Discount
    Route::get('/discount', [PageController::class, 'discountList']);
    //Message
    Route::get('/message', [PageController::class, 'message']);
    //Order
    Route::get('/order', [PageController::class, 'orderList']);
    Route::get('/order/{id}', [AdminManageController::class, 'OrderDetail']);
    Route::put('/order/update-status/{id}', [AdminManageController::class, 'updateStatus']);
    //variant
    Route::get('/variant/list', [PageController::class, 'variantList']);
    Route::get('/variant/list', [AdminController::class, 'variantAdmin']);
    Route::get('/search/variant', [AdminController::class, 'searchVariantAdmin']);
    Route::get('/add/variant', [PageController::class, 'addVariant']);
    Route::post('/variant/add', [AdminController::class, 'addVariant']);
    Route::get('/variant/edit/{id}', [PageController::class, 'editVariant']);
    Route::put('/variant/edit/{id}', [AdminController::class, 'editVariant']);
    Route::get('/variant/delete/{id}', [AdminController::class, 'deleteVariant']);


    //Coupons
    Route::get('/coupons', [PageController::class, 'couponList'])->name('coupons.index');
    Route::get('/coupons/create', [PageController::class, 'couponCreate'])->name('coupons.create');
    Route::get('/coupons/{id}/edit', [PageController::class, 'couponEdit'])->name('coupons.edit');
    Route::post('/coupons', [DiscountController::class, 'store'])->name('coupons.store');
    Route::put('/coupons/{id}', [DiscountController::class, 'update'])->name('coupons.update');
    Route::delete('/coupons/{id}', [DiscountController::class, 'destroy'])->name('coupons.destroy');
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



