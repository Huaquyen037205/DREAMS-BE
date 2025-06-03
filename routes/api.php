<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlashSaleController;
use App\Models\Flash_Sale_Variant;
use App\Models\Flash_Sale;
use App\Http\Controllers\AddressController;

// use App\Http\Middleware\CheckAdmin;

// Web Routes:
Route::get('/product', [ProductController::class, 'product']);
Route::get('/hotProduct', [ProductController::class, 'hotProduct']);
Route::get('/viewProduct', [ProductController::class, 'viewProduct']);
Route::get('/product/{id}', [ProductController::class, 'productById']);
Route::get('/search', [ProductController::class, 'searchProduct']);
Route::get('/category/{id}', [ProductController::class, 'productByCategory']);
Route::get('/products/price/{price}', [ProductController::class, 'productByprice']);
Route::get('/products/sort', [ProductController::class, 'SortByPrice']);
Route::get('/products/filter-size', [ProductController::class, 'filterBySize']);

//Login, Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
route::post('/logout', [AuthController::class, 'logout']);
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);
route::post('/resetPassword', [AuthController::class, 'resetPassword']);
Route::post('/change-password', [AuthController::class, 'changePassword']);

//discount
Route::post('/discount', [ProductController::class, 'discountUser']);
// Route::middleware('auth:sanctum')->post('/discount', [ProductController::class, 'discountUser']);

//Review

Route::post('/review', [ProductController::class, 'reviews']);
Route::middleware(['auth:sanctum'])->group(function () {

    Route::delete('/review/{id}', [ProductController::class, 'deleteReview']);
});

//Cart
Route::post('/cart/add', [ProductController::class, 'addToCart']);
Route::get('/cart', [ProductController::class, 'cart']);

// Admin Routes
//Product routes
Route::get('/admin/product', [AdminController::class, 'productAdmin']);
//Category
Route::get('/admin/category', [AdminController::class, 'categoryAdmin']);
Route::post('/admin/addCategory', [AdminController::class, 'addCategory']);
Route::patch('/admin/editCategory/{id}', [AdminController::class, 'editCategory']);
Route::delete('/admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory']);

//Product
// Route::get('/admin/product/{id}', [AdminController::class, 'editProduct']);
Route::patch('/admin/editProduct/{id}', [AdminController::class, 'editProduct']);
Route::get('/admin/searchProduct', [AdminController::class, 'searchProductAdmin']);
Route::patch('/admin/productActive/{id}', [AdminController::class, 'setActiveProduct']);
Route::post('/admin/addProduct', [AdminController::class, 'addProduct']);
Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct']);

//Variant
Route::get('/admin/variant', [AdminController::class, 'variantAdmin']);
Route::post('/admin/addVariant', [AdminController::class, 'addVariant']);
Route::patch('/admin/editVariant/{id}', [AdminController::class, 'editVariant']);
Route::patch('/admin/variantActive/{id}', [AdminController::class, 'setVariantActive']);
Route::delete('/admin/deleteVariant/{id}', [AdminController::class, 'deleteVariant']);

//Img
Route::post('/admin/addImg', [AdminController::class, 'addImg']);
Route::patch('/admin/editImg/{id}', [AdminController::class, 'editImg']);
Route::delete('/admin/deleteImg/{id}', [AdminController::class, 'deleteImg']);

//Login routes
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);
Route::post('/admin/logout', [AdminUserController::class, 'logoutAdmin']);
Route::post('/admin/forgotPassword', [AdminUserController::class, 'forgotPasswordAdmin']);
Route::post('/admin/resetPassword', [AdminUserController::class, 'resetPasswordAdmin']);

Route::middleware('auth:sanctum')->post('/admin/change-password', [AdminUserController::class, 'changePasswordAdmin']);


//Review
Route::get('/review', [ProductController::class, 'getReviews']);
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
Route::patch('/admin/setActive/{id}', [AdminUserController::class, 'setActiveUser']);
Route::delete('/admin/deleteUser/{id}', [AdminUserController::class, 'deleteUser']);

//Chart routes
Route::get('/admin/chart', [AdminManageController::class, 'Chart']);
Route::get('/admin/OrderChart', [AdminManageController::class, 'OrderChart']);
Route::get('/admin/ProductChart', [AdminManageController::class, 'ProductChart']);

//flash sale routes
Route::get('/flash-sales', [FlashSaleController::class, 'apiActiveFlashSales']);


Route::middleware('auth:sanctum')->group(function () {
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::patch('/addresses/{id}/set-default', [AddressController::class, 'setDefault']);
});
