<?php

namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Http\Request;

class DiscountController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return response()->json($coupons);
    }

    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'unique:coupons,code',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Z0-9]+$/'
            ],
            'discount_value' => 'required',
            'expiry_date' => 'required|date',
        ], [
            'code.regex' => 'Mã giảm giá phải là chữ in hoa và số, không chứa ký tự thường hoặc ký tự đặc biệt.'
        ]);

        $data = $request->all();
        $data['code'] = strtoupper($data['code']); // Đảm bảo luôn lưu chữ hoa
        Coupon::create($data);

        return redirect()->route('coupons.index')->with('success', 'Tạo mã giảm giá thành công!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'code' => [
                'required',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Z0-9]+$/',
                'unique:coupons,code,' . $id
            ],
            'discount_value' => 'required',
            'expiry_date' => 'required|date',
        ], [
            'code.regex' => 'Mã giảm giá phải chữ là in hoa và số, không chứa ký tự thường hoặc ký tự đặc biệt.'
        ]);

        $coupon = Coupon::findOrFail($id);
        $data = $request->all();
        $data['code'] = strtoupper($data['code']); // Đảm bảo luôn lưu chữ hoa
        $coupon->update($data);

        return redirect()->route('coupons.index')->with('success', 'Cập nhật mã giảm giá thành công!');
    }

    public function destroy($id)
    {
        Coupon::destroy($id);
        return redirect()->route('coupons.index')->with('success', 'Xóa mã giảm giá thành công!');
    }
}
