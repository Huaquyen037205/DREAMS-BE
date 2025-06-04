<?php

namespace App\Http\Controllers;
use App\Models\Discount;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    public function applyDiscount(Request $request)
    {
        $request->validate([
            'discount_id' => 'required|integer',
            'cart' => 'required|array',
        ]);

        $discount = Discount::find($request->discount_id);
        if (!$discount || now()->lt($discount->start_day) || now()->gt($discount->end_day)) {
            return response()->json([
                'status' => 400,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn',
            ]);
        }

        $cart = $request->cart;
        $total = 0;
        foreach ($cart as &$item) {
            $discountedPrice = $item['price'] - ($item['price'] * $discount->percentage / 100);
            $item['discounted_price'] = round($discountedPrice);
            $total += $item['discounted_price'] * $item['quantity'];
        }

        return response()->json([
            'status' => 200,
            'message' => 'Áp dụng giảm giá thành công',
            'cart' => $cart,
            'total_after_discount' => $total,
            'discount_percent' => $discount->percentage,
        ]);
    }
}
