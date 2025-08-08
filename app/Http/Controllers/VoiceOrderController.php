<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Variant;
use App\Models\Address;
use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Support\Facades\Cache;

class VoiceOrderController extends Controller
{
    // Hàm tính phí ship dựa vào địa chỉ
    private function calculateShippingFee($address)
    {
        $addr = mb_strtolower($address->adress);
        if (
            str_contains($addr, 'quận 1') ||
            str_contains($addr, 'quận 3') ||
            str_contains($addr, 'quận 7') ||
            str_contains($addr, 'quận 9') ||
            str_contains($addr, 'quận 12') ||
            str_contains($addr, 'tp.hcm') ||
            str_contains($addr, 'thành phố hồ chí minh')
        ) {
            return 10000;
        }
        return 50000;
    }

    // 1. Phân tích text từ voice
    public function parseVoiceOrder(Request $request)
    {
        $text = $request->input('text');

        preg_match('/(\d+)\s*(áo|quần|hoodie|tshirt|áo thun|áo khoác|bag|túi|pants|shirt|jacket)?\s*(.*?)\s*size\s*([A-Z]+).*giao về\s*(.+)/iu', $text, $matches);

        $result = [
            'quantity' => isset($matches[1]) ? (int)$matches[1] : 1,
            'product' => $matches[3] ?? 'áo',
            'size' => $matches[4] ?? 'M',
            'address' => $matches[5] ?? null,
        ];

        return response()->json($result);
    }

    // 2. Tạo đơn hàng nhanh (COD hoặc VNPAY)
    public function quickOrder(Request $request)
    {
        $user = $request->user();
        $data = $request->all();

        $product = Product::where('name', 'like', '%' . $data['product'] . '%')->first();
        if (!$product) return response()->json(['error' => 'Không tìm thấy sản phẩm'], 404);

        $variant = Variant::where('product_id', $product->id)
            ->where('size', strtoupper($data['size']))
            ->first();
        if (!$variant) return response()->json(['error' => 'Không tìm thấy size phù hợp'], 404);

        $address = Address::firstOrCreate([
            'adress' => $data['address'],
            'user_id' => $user->id,
        ], [
            'is_default' => 0,
        ]);

        $shipping_fee = $this->calculateShippingFee($address);
        $unit_price = $variant->price;
        $subtotal = $unit_price * $data['quantity'];
        $total_amount = $subtotal + $shipping_fee;

        $paymentId = $data['payment_id'] ?? 1;

        if ($paymentId == 1) {
            // COD
            $order = Order::create([
                'user_id' => $user->id,
                'shipping_id' => 1,
                'payment_id' => 1,
                'address_id' => $address->id,
                'status' => 'pending',
                'total_price' => $total_amount,
                'shipping_fee' => $shipping_fee,
                'order_code' => 'COD' . strtoupper(uniqid()),
            ]);

            Order_item::create([
                'order_id' => $order->id,
                'variant_id' => $variant->id,
                'quantity' => $data['quantity'],
                'price' => $unit_price,
            ]);

            return response()->json([
                'order_id' => $order->id,
                'product_name' => $product->name,
                'quantity' => $data['quantity'],
                'size' => $data['size'],
                'unit_price' => number_format($unit_price) . 'đ',
                'subtotal' => number_format($subtotal) . 'đ',
                'shipping_fee' => number_format($shipping_fee) . 'đ',
                'total_amount' => number_format($total_amount) . 'đ',
                'address' => $address->adress,
                'payment_method' => 'Thanh toán khi nhận hàng (COD)',
                'message' => "Đặt hàng thành công! $data[quantity] $product->name size $data[size] - Đơn giá: " . number_format($unit_price) . "đ - Tổng tiền sản phẩm: " . number_format($subtotal) . "đ - Phí ship: " . number_format($shipping_fee) . "đ - Tổng cộng: " . number_format($total_amount) . "đ",
            ]);
        }

        if ($paymentId == 2) {
            // VNPAY
            $cart = [[
                'variant_id' => $variant->id,
                'quantity' => $data['quantity'],
                'price' => $unit_price,
            ]];

            $vnp_TxnRef = uniqid('voice_');
            Cache::put('vnpay_' . $vnp_TxnRef, [
                'user_id' => $user->id,
                'cart' => $cart,
                'coupon_id' => null,
                'shipping_id' => 1,
                'address_id' => $address->id,
                'payment_id' => 2,
                'totalAfterDiscount' => $total_amount,
                'shipping_fee' => $shipping_fee,
            ], now()->addMinutes(30));

            // Tạo link thanh toán VNPAY
            $vnp_Amount = $total_amount * 100;
            $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
            $vnp_TmnCode = env('VNP_TMN_CODE');
            $vnp_HashSecret = env('VNP_HASH_SECRET');
            $inputData = [
                "vnp_Version" => "2.1.0",
                "vnp_TmnCode" => $vnp_TmnCode,
                "vnp_Amount" => $vnp_Amount,
                "vnp_Command" => "pay",
                "vnp_CreateDate" => now()->format('YmdHis'),
                "vnp_CurrCode" => "VND",
                "vnp_IpAddr" => $request->ip(),
                "vnp_Locale" => "vn",
                "vnp_OrderInfo" => "Thanh toán đơn hàng voice order",
                "vnp_OrderType" => "other",
                "vnp_ReturnUrl" => "http://localhost:3000/vnpay-success",
                "vnp_TxnRef" => $vnp_TxnRef,
            ];

            ksort($inputData);
            $query = [];
            foreach ($inputData as $key => $value) {
                $query[] = urlencode($key) . "=" . urlencode($value);
            }
            $hashdata = implode('&', $query);
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnpUrlFinal = $vnp_Url . '?' . implode('&', $query) . '&vnp_SecureHash=' . $vnpSecureHash;

            return response()->json([
                'payment_url' => $vnpUrlFinal,
                'vnp_TxnRef' => $vnp_TxnRef,
                'product_name' => $product->name,
                'quantity' => $data['quantity'],
                'size' => $data['size'],
                'unit_price' => number_format($unit_price) . 'đ',
                'subtotal' => number_format($subtotal) . 'đ',
                'shipping_fee' => number_format($shipping_fee) . 'đ',
                'total_amount' => number_format($total_amount) . 'đ',
                'address' => $address->adress,
                'payment_method' => 'VNPAY',
                'message' => "Chuyển đến trang thanh toán VNPAY. Tổng tiền: " . number_format($total_amount) . 'đ (Bao gồm phí ship: ' . number_format($shipping_fee) . 'đ)',
            ]);
        }

        return response()->json(['error' => 'Phương thức thanh toán không hợp lệ'], 400);
    }
}
