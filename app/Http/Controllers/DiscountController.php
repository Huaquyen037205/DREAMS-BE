<?php

namespace App\Http\Controllers;
use App\Models\Discount;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
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
