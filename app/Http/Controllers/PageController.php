<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use App\Models\Category;
use App\Models\Img;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function dashBoard(){

        return view('Admin.dashBoard');
    }

    public function loginAdmin(){
        return view('Admin.login');
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
        return view('Admin.productById',['id' => $id]);
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


}
