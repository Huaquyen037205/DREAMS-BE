<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coupon;

class CouponController extends Controller
{
public function applyCoupon(Request $request)
{
    $userId = auth()->id();
    $coupon = Coupon::where('code', $request->code)->first();

    if (!$coupon) {
        return response()->json(['status' => 404, 'message' => 'Mã giảm giá không tồn tại!']);
    }

    // Nếu là mã sinh nhật (is_public == 1) thì chỉ user được gán mới dùng được
    if ($coupon->is_public == 1) {
        $valid = \DB::table('coupons_user')
            ->where('user_id', $userId)
            ->where('coupon_id', $coupon->id)
            ->exists();

        if (!$valid) {
            return response()->json(['status' => 403, 'message' => 'Mã này không dành cho bạn!']);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Áp dụng mã sinh nhật thành công!',
            'coupon' => $coupon
        ]);
    }

    // Nếu là mã công khai (is_public == 0) thì ai cũng dùng được
    return response()->json([
        'status' => 200,
        'message' => 'Áp dụng mã công khai thành công!',
        'coupon' => $coupon
    ]);
}
}
