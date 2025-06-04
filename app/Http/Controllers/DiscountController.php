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

    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.coupon_index', compact('coupons'));
    }

    public function create()
    {
        return view('admin.coupon_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'discount_value' => 'required',
            'expiry_date' => 'required|date',
        ]);
        Coupon::create($request->all());
        return redirect()->route('coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function edit($id)
    {
        $coupon = \App\Models\Coupon::findOrFail($id);
        return view('admin.coupon_edit', compact('coupon'));
    }

    public function update(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());
        return redirect()->route('coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        Coupon::destroy($id);
        return redirect()->route('coupons.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
}
