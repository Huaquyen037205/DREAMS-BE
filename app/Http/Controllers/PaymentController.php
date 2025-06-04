<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Address;
use App\Models\Coupon;
use App\Models\Shipping;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class PaymentController extends Controller
{
     public function createVnpayPayment(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cart = $request->input('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $coupon_id = $request->input('coupon_id');
        $discountAmount = 0;
            if ($coupon_id) {
                $coupon = Coupon::find($coupon_id);
                if ($coupon && now()->lt($coupon->expiry_date)) {
                    $discountAmount = (int)$coupon->discount_value;
                }
            }

        $totalAfterDiscount = max($total - $discountAmount, 0);

        $vnp_TxnRef = uniqid(); // Mã giao dịch
        $order = Order::create([
            'user_id' => $user->id,
            'shipping_id' => $request->input('shipping_id', null),
            'payment_id' => $request->input('payment_id', null),
            'coupon_id' => $coupon_id,
            'address_id' => $request->input('address_id', null),
            'total_price' => $totalAfterDiscount,
            'status' => 'pending',
            'vnp_TxnRef' => $vnp_TxnRef,
        ]);

        $cart = $request->input('cart', []);
            foreach ($cart as $item) {
                $order->order_items()->create([
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Lấy thông tin đơn hàng từ request
        $vnp_OrderInfo = $request->input('order_desc', 'Thanh toan don hang');
        $vnp_Amount = $total * 100; // VNPAY yêu cầu đơn vị là VND * 100
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->input('bank_code', '');
        $vnp_IpAddr = $request->ip();

        // Các thông tin cấu hình VNPAY
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = url('/api/payment/vnpay/return');
        $vnp_TmnCode = env('VNP_TMN_CODE');
        $vnp_HashSecret = env('VNP_HASH_SECRET');

        $inputData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => now()->format('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        ];
        if ($vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }

        // Sắp xếp dữ liệu theo key
        ksort($inputData);
        $query = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . "=" . urlencode($value);
        }
        $hashdata = implode('&', $query);

        $vnp_Url .= "?" . implode('&', $query);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;
        $order = Order::with('order_items')->find($order->id);
        return response()->json([
            'status' => 200,
            'payment_url' => $vnp_Url,
            'order' => $order,
        ]);
    }

    public function vnpayReturn(Request $request)
    {
       if ($request->input('vnp_ResponseCode') == '00') {
        $vnp_TxnRef = $request->input('vnp_TxnRef');
        $order = Order::where('vnp_TxnRef', $vnp_TxnRef)->first();

        if (!$order) {
            return response()->json([
                'status' => 400,
                'message' => 'Không tìm thấy đơn hàng với mã giao dịch này',
            ]);
        }
        $order->status = 'pending';
        $order->save();

        return response()->json([
            'status' => 200,
            'message' => 'Thanh toán thành công, đã cập nhật đơn hàng!',
            'order' => $order
        ]);
    } else {
        return response()->json([
            'status' => 200,
            'message' => 'Kết quả thanh toán',
            'data' => $request->all()
        ]);
    }
    }

    public function getOrdersByUser(Request $request)
    {
        $user = $request->user();

        $orders = Order::with(['order_items', 'order_items.variant', 'order_items.product', 'order_items.product.img'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đơn hàng của bạn',
            'data' => $orders
        ], 200);
    }


    public function getOrderDetails($id)
    {
        $order = Order::with(['order_items', 'order_items.variant', 'order_items.product'])
            ->findOrFail($id);

        return response()->json([
            'status' => 200,
            'message' => 'Chi tiết đơn hàng',
            'data' => $order
        ], 200);
    }

    public function cancelOrder($id)
    {
        $order = Order::findOrFail($id);
        if ($order->status !== 'pending') {
            return response()->json([
                'status' => 400,
                'message' => 'Không thể hủy đơn hàng đã được xử lý',
            ], 400);
        }

        $order->status = 'canceled';
        $order->save();

        return response()->json([
            'status' => 200,
            'message' => 'Đơn hàng đã được hủy thành công',
            'data' => $order
        ], 200);
    }
}
