<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\AdminResetPasswordMail;
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
                if($request->expectsJson() || $request->wantsJson()){
                    return response()->json([
                        'status' => 403,
                        'message' => 'Tài khoản đã bị khóa',
                    ], 403);
                }
                return back()->withInput()->with('error', 'Tài khoản đã bị khóa, vui lòng liên hệ quản trị viên');
            }


            if ($user->role === 'admin') {
                $token = $user->createToken('admin-token')->plainTextToken;
                if($request->expectsJson() || $request->wantsJson()) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Đăng nhập thành công',
                        'data' => $user,
                        'token' => $token
                    ], 200);
                }

                return redirect('/dashboard');

            } else {
                Auth::logout();
                if($request->expectsJson() || $request->wantsJson()){
                    return response()->json([
                        'status' => 403,
                        'message' => 'Không có quyền truy cập',
                    ], 403);
                }
                return back()->withInput()->with('error', 'Tài khoản không có quyền truy cập');
            }

        } else {
            if($request->expectsJson() || $request->wantsJson()){
                return response()->json([
                    'status' => 401,
                    'message' => 'Email hoặc mật khẩu không đúng',
                ], 401);
            }
            return back()->withInput()->with('error', 'Email hoặc mật khẩu không đúng');
        }
    }

    public function forgotPasswordAdmin(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user) {
            $token = Str::random(8);

            DB::table('password_resets')->updateOrInsert(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => $token,
                'created_at' => now()
            ]
        );

            Mail::to($user->email)->send(new AdminResetPasswordMail($user, $token));

            if($request->expectsJson() || $request->wantsJson()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Email đặt lại mật khẩu đã được gửi',
                ], 200);
            }
                return back()->with('status', 'Email đặt lại mật khẩu đã được gửi, vui lòng kiểm tra hộp thư của bạn');
        } else {
            if($request->expectsJson() || $request->wantsJson()){
                return response()->json([
                    'status' => 404,
                    'message' => 'Email không tồn tại',
                ], 404);
            }
            return back()->withInput()->with('error', 'Email không tồn tại');
        }
    }

    public function resetPasswordAdmin(Request $request)
    {
    $email = $request->query('email');
    $token = $request->query('token');

    $reset = DB::table('password_resets')->where([
        ['email', $email],
        ['token', $token]
    ])->first();

    if (!$reset) {
        return response('Link đặt lại mật khẩu không hợp lệ hoặc đã hết hạn.', 400);
    }

    $newPassword = Str::random(8);
    $user = User::where('email', $email)->first();
    if($user){
        $user->password = Hash::make($newPassword);
        $user->save();
        DB::table('password_resets')->where('email', $email)->delete();

        if($request->expectsJson() || $request->wantsJson()) {
            return response()->json([
                'status' => 200,
                'message' => 'Mật khẩu đã được đặt lại thành công',
                'new_password' => $newPassword
            ], 200);
        }
        return view('Admin.notification', ['newPassword' => $newPassword]);
    } else {
        return response()->json([
            'status' => 404,
            'message' => 'Email không tồn tại'
        ], 404);
    }
}

    public function changePasswordAdmin(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();

            if($request->expectsJson() || $request->wantsJson()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Đổi mật khẩu thành công',
                ], 200);
            }
            return back()->with('status', 'Đổi mật khẩu thành công');

            } else {
                if($request->expectsJson() || $request->wantsJson()){
                    return response()->json([
                        'status' => 401,
                        'message' => 'Mật khẩu cũ không đúng',
                    ], 401);
                }
                return back()->withInput()->with('error', 'Mật khẩu cũ không đúng');
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
