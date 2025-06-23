<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ResetPasswordMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Google\Client as Google_Client;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:15',
            'password' => 'required|string',
            'role' => 'required|in:user,admin'
        ]);
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


    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'status' => 200,
            'message' => 'Đăng xuất thành công'
        ], 200);
    }



        public function login(Request $request)
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

                // Tạo access token
                $token = $user->createToken('API Token')->plainTextToken;

                return response()->json([
                    'status' => 200,
                    'message' => 'Đăng nhập thành công',
                    'access_token' => $token,
                    'token_type' => 'Bearer',
                    'user' => $user
                ], 200);
            } else {
                return response()->json([
                    'status' => 401,
                    'message' => 'Email hoặc mật khẩu không đúng',
                ], 401);
            }
        }

    public function forgotPassword(Request $request)
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

            Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

            return response()->json([
                'status' => 200,
                'message' => 'Vui lòng kiểm tra email để đặt lại mật khẩu'
            ], 200);

            } else {
                return response()->json([
                    'status' => 404,
                    'message' => 'Email không tồn tại'
                ], 404);
            }
    }

    public function resetPassword(Request $request)
    {
       $email = $request->query('email');
       $token = $request->query('token');

         $reset = DB::table('password_resets')->where([
              ['email', $email],
              ['token', $token]
         ])->first();

         if(!$reset){
            return response('Link đặt lại mật khẩu không hợp lệ, hoặc hết hạn', 404);
         }

         $newPassword = Str::random(8);
         $user = User::where('email', $email)->first();
         if($user){
            $user->password = Hash::make($newPassword);
            $user->save();
            DB::table('password_resets')->where('email', $email)->delete();

            return response()->json("
                <h2>Đặt lại mật khẩu thành công!</h2>
                <p>Mật khẩu mới của bạn là: <b>{$newPassword}</b></p>
                <p>Vui lòng đăng nhập và đổi lại mật khẩu.</p>
            ");
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Email không tồn tại'
            ], 404);
        }
    }

    public function changePassword(Request $request)
    {
        $user = Auth::user();
        if (Hash::check($request->old_password, $user->password)) {
            $user->password = Hash::make($request->new_password);
            $user->save();
            return response()->json([
                'status' => 200,
                'message' => 'Đổi mật khẩu thành công'
            ], 200);
        } else {
            return response()->json([
                'status' => 401,
                'message' => 'Mật khẩu cũ không đúng'
            ], 401);
        }
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'day_of_birth' => 'nullable|date',
        ]);


    if (!empty($validated['day_of_birth'])) {
        $date = \DateTime::createFromFormat('d-m-Y', $validated['day_of_birth']);
        if ($date) {
            $validated['day_of_birth'] = $date->format('Y-m-d');
        } else {
            unset($validated['day_of_birth']);
        }
    }

        $user->update($validated);
        $user->refresh();

        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật thông tin thành công',
            'data' => $user
        ]);
    }


    // login gg
   public function loginOrRegisterWithGoogle(Request $request)
{
    $request->validate([
        'id_token' => 'required|string',
    ]);

    $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
    $payload = $client->verifyIdToken($request->id_token);

    if (!$payload) {
        return response()->json(['message' => 'ID Token không hợp lệ'], 401);
    }

    $email = $payload['email'];
    $name = $payload['name'] ?? 'No Name';
    $googleId = $payload['sub'];

    // ✅ Ưu tiên tìm user theo google_id
    $user = User::where('google_id', $googleId)->first();

    if (!$user) {
        // Nếu chưa có user với google_id này, tìm theo email
        $user = User::where('email', $email)->first();

        if ($user) {
            // Nếu có user với email nhưng chưa liên kết google_id
            $user->google_id = $googleId;
            $user->save();
        } else {
            // Nếu không có user nào cả, tạo mới
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'password' => bcrypt(Str::random(16)),
            ]);
        }
    }

    $token = $user->createToken('google_token')->plainTextToken;

    return response()->json([
        'message' => 'Đăng nhập thành công',
        'access_token' => $token,
        'user' => $user,
    ]);
}
}

