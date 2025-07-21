<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminManageController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FlashSaleController;
use App\Models\Flash_Sale_Variant;
use App\Http\Controllers\VirtualTryOnController;
use App\Http\Controllers\StylistAiController;
use App\Models\Flash_Sale;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ImageSearchController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\VoiceOrderController;
use App\Http\Controllers\AIChatController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostReactionController;



// use App\Http\Middleware\CheckAdmin;
// Web Routes:
Route::get('/product', [ProductController::class, 'product']);
Route::get('/hotProduct', [ProductController::class, 'hotProduct']);
Route::get('/viewProduct', [ProductController::class, 'viewProduct']);
Route::get('/product/{id}', [ProductController::class, 'productById']);
// Route::middleware('auth:sanctum')->get('/product/{id}', [ProductController::class, 'productById']);
Route::get('/search', [ProductController::class, 'searchProduct']);
Route::get('/category/{id}', [ProductController::class, 'productByCategory']);
Route::get('/products/price', [ProductController::class, 'productByPrice']);
Route::get('/products/sort', [ProductController::class, 'SortByPrice']);
Route::get('/products/filter-size', [ProductController::class, 'filterBySize']);
// Route::get('/fill/product', [ProductController::class, 'filterAll']);
Route::get('/products/filter-all', [ProductController::class, 'filterAll']);
Route::get('/products-by-category', [ProductController::class, 'productsByCategoryId']);
//Login, Register
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
route::post('/logout', [AuthController::class, 'logout']);
Route::post('/forgotPassword', [AuthController::class, 'forgotPassword']);
route::post('/resetPassword', [AuthController::class, 'resetPassword']);

Route::get('/review/{id}', [ProductController::class, 'reviewByProductId']);
Route::middleware('auth:sanctum')->group(function () {
    //discount
    Route::post('/discount', [ProductController::class, 'discountUser']);
    Route::post('/discount/apply', [DiscountController::class, 'applyDiscount']);
   //oder
    Route::get('/order', [PaymentController::class, 'getOrdersByUser']);
    //Review
    Route::get('/review', [ProductController::class, 'getReviews']);
    Route::post('/review', [ProductController::class, 'reviews']);
    Route::post('/change-password', [AuthController::class, 'changePassword']);
    Route::delete('/review/{id}', [ProductController::class, 'deleteReview']);
});



//Img
Route::post('/admin/addImg', [AdminController::class, 'addImg']);
Route::patch('/admin/editImg/{id}', [AdminController::class, 'editImg']);
Route::delete('/admin/deleteImg/{id}', [AdminController::class, 'deleteImg']);


// Admin Routes
Route::post('/admin/login', [AdminUserController::class, 'loginAdmin']);
Route::post('/admin/forgotPassword', [AdminUserController::class, 'forgotPasswordAdmin']);
Route::post('/admin/resetPassword', [AdminUserController::class, 'resetPasswordAdmin']);
Route::post('/admin/change-password', [AdminUserController::class, 'changePasswordAdmin']);
Route::post('/admin/addUser', [AdminUserController::class, 'addUser']);
Route::middleware(['auth:sanctum'])->group(function (){
    //Product routes
    Route::get('/admin/product', [AdminController::class, 'productAdmin']);
    Route::patch('/admin/editProduct/{id}', [AdminController::class, 'editProduct']);
    Route::get('/admin/searchProduct', [AdminController::class, 'searchProductAdmin']);
    Route::patch('/admin/productActive/{id}', [AdminController::class, 'setActiveProduct']);
    Route::post('/admin/addProduct', [AdminController::class, 'addProduct']);
    Route::delete('/admin/product/{id}', [AdminController::class, 'deleteProduct']);

    //Category
    Route::get('/admin/category', [AdminController::class, 'categoryAdmin']);
    Route::post('/admin/addCategory', [AdminController::class, 'addCategory']);
    Route::patch('/admin/editCategory/{id}', [AdminController::class, 'editCategory']);
    Route::delete('/admin/deleteCategory/{id}', [AdminController::class, 'deleteCategory']);

    //Variant
    Route::get('/admin/variant', [AdminController::class, 'variantAdmin']);
    Route::post('/admin/addVariant', [AdminController::class, 'addVariant']);
    Route::patch('/admin/editVariant/{id}', [AdminController::class, 'editVariant']);
    Route::patch('/admin/variantActive/{id}', [AdminController::class, 'setVariantActive']);
    Route::delete('/admin/deleteVariant/{id}', [AdminController::class, 'deleteVariant']);

    //Login routes
    Route::post('/admin/logout', [AdminUserController::class, 'logoutAdmin']);

    //Payment
    // Route::get('/payment/vnpay/return', [PaymentController::class, 'vnpayReturn']);
    // Route::post('/payment/vnpay', [PaymentController::class, 'createVnpayPayment']);
    // Route::post('/payment/cod', [PaymentController::class, 'createCodPayment']);

    //Order routes
    Route::get('/admin/order', [AdminManageController::class, 'ShowOrder']);
    Route::get('/admin/order/sold', [AdminManageController::class, 'OrderSold']);
    Route::patch('/admin/order/cancel', [AdminManageController::class, 'OrderCancel']);
    Route::get('/admin/orderDetail/{id}', [AdminManageController::class, 'OrderDetail']);
    Route::get('/admin/topSoldProduct', [AdminManageController::class, 'topSoldProduct']);

    //Discount routes
    Route::get('/admin/discount', [AdminManageController::class, 'discount']);
    Route::post('/admin/add/discount', [AdminManageController::class, 'addDiscount']);
    Route::patch('/admin/edit/discount/{id}', [AdminManageController::class, 'editDiscount']);
    Route::delete('/admin/delete/discount/{id}', [AdminManageController::class, 'deleteDiscount']);

    //User routes
    Route::get('/admin/user', [AdminUserController::class, 'userAdmin']);
    Route::get('/admin/searchUser', [AdminUserController::class, 'searchUser']);

    Route::patch('/admin/updateUser/{id}', [AdminUserController::class, 'updateUser']);
    Route::patch('/admin/editUser/{id}', [AdminUserController::class, 'editUser']);
    Route::patch('/admin/setActive/{id}', [AdminUserController::class, 'setActiveUser']);
    Route::delete('/admin/deleteUser/{id}', [AdminUserController::class, 'deleteUser']);

    //Chart routes
    Route::get('/admin/chart', [AdminManageController::class, 'Chart']);
    Route::get('/admin/OrderChart', [AdminManageController::class, 'OrderChart']);
    Route::get('/admin/ProductChart', [AdminManageController::class, 'ProductChart']);

    //Order routes
    Route::get('/admin/order/{id}', [PaymentController::class, 'getOrderDetails']);
    Route::get('/admin/orderDetail/{id}', [AdminManageController::class, 'OrderDetail']);
});


Route::middleware(['auth:sanctum', \Illuminate\Session\Middleware\StartSession::class])->group(function () {
    Route::post('/payment/vnpay/return', [PaymentController::class, 'vnpayReturn']);
    Route::post('/payment/vnpay', [PaymentController::class, 'createVnpayPayment']);
    Route::post('/payment/cod', [PaymentController::class, 'createCodPayment']);
});

//flash sale routes
Route::get('/flash-sales', [FlashSaleController::class, 'apiActiveFlashSales']);

//address routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/addresses', [AddressController::class, 'show']);
    Route::post('/addresses', [AddressController::class, 'store']);
    Route::patch('/addresses/{id}/set-default', [AddressController::class, 'setDefault']);
});

// edit user profile
Route::middleware('auth:sanctum')->patch('/user/profile', [AuthController::class, 'updateProfile']);

//coupons
Route::get('/coupons', [DiscountController::class, 'index']);

// Wishlist routes
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index']);
    Route::post('/wishlist/{productId}', [WishlistController::class, 'store']);
    Route::delete('/wishlist/{productId}', [WishlistController::class, 'destroy']);
});


//AI SEARCH
Route::post('/image-search', [ImageSearchController::class, 'search']);

// gửi mã giảm giá
Route::middleware('auth:sanctum')->post('/apply-coupon', [CouponController::class, 'applyCoupon']);


//AI SEARCH IMG
Route::post('/image-search', [ImageSearchController::class, 'search']);





// Virtual Try-On

Route::post('/tryon', [VirtualTryOnController::class, 'tryOn']);
Route::get('/result/{id}', [VirtualTryOnController::class, 'getResult']);




//login gg
Route::post('auth/google', [AuthController::class, 'loginOrRegisterWithGoogle']);

//StyleAI





Route::post('/stylist/analyze', [StylistAiController::class, 'analyzeStyle']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/voice-order/parse', [VoiceOrderController::class, 'parseVoiceOrder']);
    Route::post('/voice-order/quick', [VoiceOrderController::class, 'quickOrder']);
    Route::post('/voice-order/confirm-otp/{orderId}', [VoiceOrderController::class, 'confirmOtp']);
});

//  chat
// Route::post('/chat-ai', [AIChatController::class, 'chat']);
Route::post('/chat-ai', [AIChatController::class, 'chat']);
//AI xem chi tiết sẽ gợi ý sản phẩm
Route::middleware('auth:sanctum')->get('/user/viewed-products', [ProductController::class, 'viewedProducts']);
Route::middleware('auth:sanctum')->get('/user/ai-recommend', [ProductController::class, 'aiRecommend']);


//api bai viet
// Route::apiResource('posts', PostController::class);
// Danh sách bài viết
Route::get('/posts', [PostController::class, 'index']);

// Xem chi tiết bài viết
Route::get('/posts/{id}', [PostController::class, 'show']);

// Tạo mới bài viết
Route::post('/posts', [PostController::class, 'store']);

// Cập nhật bài viết
Route::put('/posts/{id}', [PostController::class, 'update']);
Route::patch('/posts/{id}', [PostController::class, 'update']);

// Xóa bài viết
Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Bình luận
Route::middleware('auth:sanctum')->post('/posts/{post}/comments', [CommentController::class, 'store']);

// Biểu cảm
Route::middleware('auth:sanctum')->post('/posts/{post}/react', [PostReactionController::class, 'react']);

// Lấy bình luận của bài viết
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);

// Lấy biểu cảm của bài viết
Route::get('/posts/{post}/react', [PostReactionController::class, 'index']);
Route::put('/admin/posts/{id}/toggle-status', [PostController::class, 'toggleStatus']);
// Route API để lấy gợi ý từ Gemini

Route::post('/posts/gemini-suggestions', [PostController::class, 'getGeminiSuggestions']);
