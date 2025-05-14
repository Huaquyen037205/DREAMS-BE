<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function loginAdmin(){
        return view('Admin.login');
    }

    public function addUserAdmin(){
        return view('Admin.addUser');
    }

    public function editUserAdmin($id){
        return view('Admin.editUser', ['id' => $id]);
    }
}
