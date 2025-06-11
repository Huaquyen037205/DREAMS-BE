<?php
namespace App\Http\Controllers;
use App\Models\Coupon;
use Illuminate\Http\Request;
use App\Models\Discount;

class DiscountController extends Controller
{

    public function index()
    {
        $coupons = Coupon::all();
        return response()->json($coupons);
    }

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


    public function store(Request $request)
    {
        $request->validate([
            'code' => [
                'required',
                'unique:coupons,code',
                'regex:/^(?=.*[A-Z])(?=.*\d)[A-Z0-9]+$/'
            ],
            'discount_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
        ], [
            'code.regex' => 'Mã giảm giá phải là chữ in hoa và số, không chứa ký tự thường hoặc ký tự đặc biệt.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'expiry_date.after' => 'Ngày hết hạn phải sau ngày hiện tại.'
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
            'discount_value' => 'required|numeric|min:0',
            'expiry_date' => 'required|date|after:today',
        ], [
            'code.regex' => 'Mã giảm giá phải là chữ in hoa và số, không chứa ký tự thường hoặc ký tự đặc biệt.',
            'discount_value.min' => 'Giá trị giảm giá không được nhỏ hơn 0.',
            'expiry_date.after' => 'Ngày hết hạn phải sau ngày mã được tạo.'
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
