<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->role = $request->role;
        $user->save();
        return response()->json([
            'status' => 200,
            'message' => 'Đăng ký thành công',
            'data' => $user
        ], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công',
                'data' => $user
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Đăng nhập thất bại'
            ], 401);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => 200,
            'message' => 'Đăng xuất thành công'
        ], 200);
    }
}


