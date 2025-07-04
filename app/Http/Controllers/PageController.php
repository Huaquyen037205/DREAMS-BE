<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Order;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Img;
use App\Models\Discount;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function template(){
        $notifications = Notification::orderByDesc('created_at')->take(10)->get();
        return view('template.admin', compact('notifications'));
    }

    public function dashBoard(){
        return view('Admin.dashBoard', compact('notifications'));
    }

    public function loginAdmin(){
        return view('Admin.Login');
    }

    // public function addUserAdmin(){
    //     return view('Admin.addUser');
    // }

    public function editUserAdmin($id){
        $user = User::findOrFail($id);
        return view('Admin.editUser', compact('user'));
    }

    public function forgotPasswordEmail(){ //view của email
        return view('email.admin_reset_password');
    }

    public function forgotPasswordAdmin(){ //view của nhập email để gửi nk
        return view('Admin.forgot_password');
    }

    public function notificationResetPassword(){ //của thông báo
        return view('Admin.notification');
    }

    public function changePassword(){
        return view('Admin.reset_password');
    }

    public function productList(){
        return view('Admin.productList');
    }

    public function productById($id){
        $product = Product::findOrFail($id);
        return view('Admin.productById',['id' => $id], compact('product'));
    }

    public function addProduct(){
        $product = new Product();
        return view('Admin.add_product', compact('product'));
    }

    public function editProduct($id){
    $product = Product::findOrFail($id);
    return view('Admin.edit_product', compact('product'));
    }

    public function userList(){
        return view('Admin.userList');
    }

    public function profileUser(){
        return view('Admin.profile');
    }

    public function variantList(){
        return view('Admin.variantList');
    }

    public function addVariant(){
        $variant = new Variant();
        $products = Product::all();
        $images = Img::all();
        return view('Admin.add_variant', compact('variant', 'products', 'images'));
    }

    public function editVariant($id){
        $variant = Variant::findOrFail($id);
        return view('Admin.edit_variant', compact('variant'));
    }

    public function message(){
        return view('Admin.message');
    }

    public function orderList(){
        $orders = Order::with('user', 'discount', 'shipping', 'payment', 'coupon', 'address')
        ->orderByDesc('created_at')
        ->paginate(12);;
       return view('Admin.orderList', compact('orders'));
    }

    public function orderDetail($id){
         $order = Order::with([
        'user',
        'order_items.variant.product.img',
        'discount',
        'shipping',
        'payment',
        'coupon',
        'address'
    ])->findOrFail($id);

      return view('Admin.orderDetail', [
        'order' => $order,
        'order_items' => $order->order_items
    ]);
    }

    public function discountList(){
        return view('Admin.discountList');
    }

    public function addDiscount(){
        $discount = new Discount();
        return view('Admin.addDiscount', compact('discount'));
    }

    public function editDiscount($id){
        $discount = Discount::findOrFail($id);
        $allProducts = Product::all();
        return view('Admin.editDiscount', compact('discount', 'allProducts'));
    }

    public function product()  {
        $products = Product::all();
        return view('producTest', compact('products'));
    }

    public function couponList()
    {
        $coupons = \App\Models\Coupon::all();
        return view('admin.coupon_index', compact('coupons'));
    }

    public function couponCreate()
    {
        return view('admin.coupon_create');
    }

    public function couponEdit($id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        return view('admin.coupon_edit', compact('coupon'));
    }
}
