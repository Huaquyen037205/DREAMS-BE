<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Flash_Sale;
use App\Models\Flash_Sale_Variant;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Variant;
use App\Models\Product;
use App\Models\Category;

use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    public function getActiveSales()
    {
        $now = Carbon::now();
        $sales = Flash_Sale::where('status', true)
            ->where('start_time', '<=', $now)
            ->where('end_time', '>=', $now)
            ->get();

        return response()->json($sales);
    }

    public function getVariants($id)
    {
        $sale = Flash_Sale::findOrFail($id);
        $variants = $sale->variants()->with('variant.product')->get();

        return response()->json($variants);
    }

    public function orderVariant(Request $request)
    {
        $variantId = $request->variant_id;
        $userId = auth()->id();

        DB::beginTransaction();
        try {
            $item = Flash_Sale_Variant::lockForUpdate()
                ->where('variant_id', $variantId)
                ->first();

            if (!$item || $item->flash_sold >= $item->flash_quantity) {
                return response()->json(['message' => 'Hết hàng'], 400);
            }

            // Tạo đơn hàng (giả sử các field cơ bản và tạm payment_id, address_id...)
            $order = Order::create([
                'user_id' => $userId,
                'shipping_id' => 1,
                'discount_id' => null,
                'payment_id' => 1,
                'coupon_id' => null,
                'address_id' => 1,
                'status' => 'chờ xử lý',
                'total_price' => $item->sale_price,
                'order_date' => Carbon::now(),
            ]);

            Order_item::create([
                'order_id' => $order->id,
                'variant_id' => $variantId,
                'quantity' => 1,
                'price' => $item->sale_price,
            ]);

            $item->increment('flash_sold');
            DB::commit();

            return response()->json(['message' => 'Đặt hàng thành công']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Lỗi hệ thống'], 500);
        }
    }
}
