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
        if (Auth::user()->role == 'admin') {
            return response()->json([
                'status' => 200,
                'message' => 'Đăng nhập thành công',
                'data' => Auth::user()
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
            'message' => 'Logout Successful',
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

    public function productAdmin(){
        $product = Product::with('img', 'variant', 'category')->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Product List',
            'data' => $product
        ],200);
    }

    public function searchProductAdmin(Request $request){
        $search = $request->input('search');
        $product = Product::where('name', 'LIKE', "%{$search}%")
                    ->orWhere('description', 'LIKE', "%{$search}%")
                    ->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Tìm thấy sản phẩm',
            'data' => $product
        ],200);
    }

    public function categoryAdmin(){
        $category = Category::with('product')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Category List',
            'data' => $category
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

    // public function updateUser(Request $request, $id)
    // {
    //     $user = User::find($id);
    //     if ($user) {
    //         $user->name = $request->name;
    //         $user->phone = $request->phone;
    //         $user->email = $request->email;
    //         $user->role = $request->role;
    //         if ($user->save()) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'message' => 'Cập nhật người dùng thành công',
    //                 'data' => $user
    //             ], 200);
    //         } else {
    //             return response()->json([
    //                 'status' => 422,
    //                 'message' => 'Cập nhật người dùng thất bại',
    //             ], 422);
    //         }
    //     } else {
    //         return response()->json([
    //             'status' => 404,
    //             'message' => 'Người dùng không tồn tại',
    //         ], 404);
    //     }
    // }

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
