<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckAdmin;

class AdminUserController extends Controller
{
    public function loginAdmin(Request $request)
    {
        $isLogin = Auth::attempt([
        'email' => $request->email,
        'password' => $request->password
        ]);

        if ($isLogin) {
            $user = Auth::user();

            if ($user->is_active === 'off') {
                Auth::logout();
                return response()->json([
                    'status' => 403,
                    'message' => 'Tài khoản đã bị khóa',
                ], 403);
            }

            if ($user->role === 'admin') {
                return response()->json([
                    'status' => 200,
                    'message' => 'Đăng nhập thành công',
                    'data' => $user
                ], 200);
            } else {
                Auth::logout();
                return response()->json([
                    'status' => 403,
                    'message' => 'Không có quyền truy cập',
                ], 403);
            }
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Email hoặc mật khẩu không đúng',
            ], 401);
        }
    }

    public function logoutAdmin(Request $request){
        auth()->logout();
        return response()->json([
            'status' => 200,
            'message' => 'Đã đăng xuất',
        ], 200);
    }

    public function userAdmin(){
        $user = User::paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách người dùng',
            'data' => $user
        ],200);
    }

    public function searchUser(Request $request){
        $search = $request->input('search');
        $user = User::where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Tìm thấy người dùng',
            'data' => $user
        ],200);
    }

    public function addUser(Request $request)
    {
     $user = User::where('email', $request->email)->first();
        if(!$user){
            $user = new User();
            $user ->name = $request->name;
            $user ->phone = $request->phone;
            $user ->email = $request->email;
            $user ->password = Hash::make($request->password);
            $user ->role = $request->role;
            if($user ->save()){
                return response()->json([
                    'succses'=> true,
                    'message'=> 'thêm người dùng thành công',
                    'data' => $user

                ], 200);
            }
            else{
                return response()->json([
                    'succses'=> false,
                    'message'=> 'thêm người dùng thất bại',
                    'data' => $user
                ], 422);
            }
        }
    }

    public function editUser(Request $request, $id)
    {
        $user = User::find($id);
        if ($user) {
            $user->name = $request->name;
            $user->phone = $request->phone;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->role = $request->role;
            if ($user->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật người dùng thành công',
                    'data' => $user
                ], 200);
            } else {
                    return response()->json([
                        'status' => 422,
                        'message' => 'Cập nhật người dùng thất bại',
                    ], 422);
                }
            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Người dùng không tồn tại',
                ], 404);
            }
        }

    public function setActiveUser(Request $request, $id)
    {
        $request->validate([
        'is_active' => 'required|in:on,off',
        ]);

        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 404,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }

        $user->is_active = $request->is_active;
        $user->save();

        return response()->json([
            'status' => 200,
            'message' => $request->is_active === 'on' ? 'Kích hoạt người dùng thành công' : 'Ngừng kích hoạt người dùng thành công',
        ], 200);
    }

    public function deleteUser($id)
    {
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa người dùng thành công',
            ], 200);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }
    }



}
