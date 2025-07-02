<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Flash_Sale_Variant;
use App\Models\Variant;
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
            $variant = Variant::find($item['variant_id']);
            $flashSaleVariant = Flash_Sale_Variant::where('variant_id', $variant->id)
                ->whereHas('flashSale', function($q) {
                    $now = now();
                    $q->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now);
                })
                ->first();

            if ($flashSaleVariant) {
                $price = $flashSaleVariant->sale_price;
            } elseif ($variant->sale_price !== null) {
                $price = $variant->sale_price;
            } else {
                $price = $variant ? $variant->price : 0;
            }

            $total += $price * $item['quantity'];
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

        $vnp_TxnRef = uniqid();

        cache()->put('vnpay_' . $vnp_TxnRef, [
            'user_id' => $user->id,
            'cart' => $cart,
            'coupon_id' => $coupon_id,
            'shipping_id' => $request->input('shipping_id', null),
            'address_id' => $request->input('address_id', null),
            'payment_id' => $request->input('payment_id', null),
            'totalAfterDiscount' => $totalAfterDiscount,
        ], now()->addMinutes(30));

        // Tạo link thanh toán VNPAY
        $vnp_OrderInfo = $request->input('order_desc', 'Thanh toan don hang');
        $vnp_Amount = $totalAfterDiscount * 100;
        $vnp_Locale = 'vn';
        $vnp_BankCode = $request->input('bank_code', '');
        $vnp_IpAddr = $request->ip();

        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = "http://localhost:3000/vnpay-success";
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

        ksort($inputData);
        $query = [];
        foreach ($inputData as $key => $value) {
            $query[] = urlencode($key) . "=" . urlencode($value);
        }
        $hashdata = implode('&', $query);

        $vnp_Url .= "?" . implode('&', $query);
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= '&vnp_SecureHash=' . $vnpSecureHash;

        // Trả về link thanh toán và vnp_TxnRef để client lưu lại
        return response()->json([
            'status' => 200,
            'payment_url' => $vnp_Url,
            'vnp_TxnRef' => $vnp_TxnRef,
        ]);
    }

    public function vnpayReturn(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        if ($request->input('vnp_ResponseCode') == '00') {
            $vnp_TxnRef = $request->input('vnp_TxnRef');
            $temp = cache()->pull('vnpay_' . $vnp_TxnRef);

            if (!$temp) {
                return response()->json(['status' => 400, 'message' => 'Không tìm thấy thông tin đơn hàng!'], 400);
            }

            $cart = $temp['cart'];
            $coupon_id = $temp['coupon_id'];
            $shipping_id = $temp['shipping_id'];
            $address_id = $temp['address_id'];
            $payment_id = $temp['payment_id'];
            $totalAfterDiscount = $temp['totalAfterDiscount'];

            $order = Order::create([
                'user_id' => $user->id,
                'shipping_id' => $shipping_id,
                'payment_id' => $payment_id,
                'coupon_id' => $coupon_id,
                'address_id' => $address_id,
                'total_price' => $totalAfterDiscount,
                'status' => 'pending',
                'vnp_TxnRef' => $vnp_TxnRef,
                'order_code' => null,
            ]);

            foreach ($cart as $item) {
                $variant = Variant::find($item['variant_id']);
                $flashSaleVariant = Flash_Sale_Variant::where('variant_id', $variant->id)
                    ->whereHas('flashSale', function($q) {
                        $now = now();
                        $q->where('start_time', '<=', $now)
                        ->where('end_time', '>=', $now);
                    })
                    ->first();

                if ($flashSaleVariant) {
                    $price = $flashSaleVariant->sale_price;
                } elseif ($variant && $variant->sale_price !== null) {
                    $price = $variant->sale_price;
                } else {
                    $price = $variant ? $variant->price : 0;
                }

                // Trừ số lượng flash sale nếu có
                if ($flashSaleVariant) {
                    if ($flashSaleVariant->flash_quantity >= $item['quantity']) {
                        $flashSaleVariant->flash_quantity -= $item['quantity'];
                        $flashSaleVariant->flash_sold += $item['quantity'];
                        $flashSaleVariant->save();
                    } else {
                        return response()->json(['error' => 'Số lượng flash sale không đủ'], 400);
                    }
                }

                $order->order_items()->create([
                    'variant_id' => $item['variant_id'],
                    'quantity' => $item['quantity'],
                    'price' => $price,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            return response()->json([
                'status' => 200,
                'message' => 'Thanh toán thành công',
                'order' => $order,
            ]);
        } else {
            return response()->json([
                'status' => 400,
                'message' => 'Thanh toán không thành công. Mã phản hồi: ' . $request->input('vnp_ResponseCode'),
            ], 400);
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
        $order = Order::with(['order_items', 'order_items.variant', 'order_items.product', 'order_items.product.img', 'address'])
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

    public function createCodPayment(Request $request)
    {
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $cart = $request->input('cart', []);
        $total = 0;
        foreach ($cart as $item) {
            $variant = Variant::find($item['variant_id']);
            $flashSaleVariant = Flash_Sale_Variant::where('variant_id', $variant->id)
                ->whereHas('flashSale', function($q) {
                    $now = now();
                    $q->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now);
                })
                ->first();

            if ($flashSaleVariant) {
                $price = $flashSaleVariant->sale_price;
            } elseif ($variant && $variant->sale_price !== null) {
                $price = $variant->sale_price;
            } else {
                $price = $variant ? $variant->price : 0;
            }

            $total += $price * $item['quantity'];
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

        $order = Order::create([
            'user_id' => $user->id,
            'shipping_id' => $request->input('shipping_id', null),
            'payment_id' => $request->input('payment_id', null),
            'coupon_id' => $coupon_id,
            'address_id' => $request->input('address_id', null),
            'total_price' => $totalAfterDiscount,
            'status' => 'pending',
            'vnp_TxnRef' => null,
            'order_code' => 'COD' . strtoupper(uniqid()),
        ]);

        foreach ($cart as $item) {
            $variant = Variant::find($item['variant_id']);
            $flashSaleVariant = Flash_Sale_Variant::where('variant_id', $variant->id)
                ->whereHas('flashSale', function($q) {
                    $now = now();
                    $q->where('start_time', '<=', $now)
                    ->where('end_time', '>=', $now);
                })
                ->first();

            if ($flashSaleVariant) {
                $price = $flashSaleVariant->sale_price;
            } elseif ($variant && $variant->sale_price !== null) {
                $price = $variant->sale_price;
            } else {
                $price = $variant ? $variant->price : 0;
            }

            // Trừ số lượng flash sale nếu có
            if ($flashSaleVariant) {
                if ($flashSaleVariant->flash_quantity >= $item['quantity']) {
                    $flashSaleVariant->flash_quantity -= $item['quantity'];
                    $flashSaleVariant->flash_sold += $item['quantity'];
                    $flashSaleVariant->save();
                } else {
                    return response()->json(['error' => 'Số lượng flash sale không đủ'], 400);
                }
            }

            $order->order_items()->create([
                'variant_id' => $item['variant_id'],
                'quantity' => $item['quantity'],
                'price' => $price,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        return response()->json([
            'status' => 200,
            'message' => 'Đặt hàng thành công. Vui lòng thanh toán khi nhận hàng!',
            'order' => $order,
        ]);
    }
}
