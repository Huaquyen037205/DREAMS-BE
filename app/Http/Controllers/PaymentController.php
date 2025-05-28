<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentController extends Controller
{
     public function createVnpayPayment(Request $request)
    {
        // Lấy thông tin đơn hàng từ request
        $vnp_TxnRef = uniqid(); // Mã giao dịch
        $vnp_OrderInfo = $request->input('order_desc', 'Thanh toan don hang');
        $vnp_Amount = $request->input('amount') * 100; // VNPAY yêu cầu đơn vị là VND * 100
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

        return response()->json([
            'status' => 200,
            'payment_url' => $vnp_Url
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        // Xử lý kết quả trả về từ VNPAY tại đây
        // $request->all() chứa các tham số trả về
        // Kiểm tra vnp_ResponseCode, vnp_TxnRef, vnp_Amount, vnp_SecureHash, ...
        return response()->json([
            'status' => 200,
            'message' => 'Kết quả thanh toán',
            'data' => $request->all()
        ]);
    }
}
