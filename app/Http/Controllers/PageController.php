<?php

namespace App\Http\Controllers;

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

    // public function editUserAdmin($id){
    //     return view('Admin.editUser', ['id' => $id]);
    // }

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
}
