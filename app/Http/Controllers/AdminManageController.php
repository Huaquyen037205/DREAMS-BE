<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\User;
use App\Models\Shipping;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Variant;
use App\Models\Payment;
use App\Models\Discount;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminManageController extends Controller
{
    public function orderAdmin(){
        $orders = Order::with('user', 'discount', 'shipping', 'payment', 'coupon', 'address')
        ->orderByDesc('created_at')
        ->paginate(12);
        return view('Admin.orderList', compact('orders'));
        return response()->json([
        'status' => 200,
        'message' => 'Danh sách đơn hàng',
        'data' => $orders
    ], 200);
    }

    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $request->validate([
            'status' => 'required|in:pending,processing,paid,cancelled',
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    public function OrderCancel(Request $request)
    {
        $order = Order::with('user', 'discount' ,'shipping', 'payment', 'coupon', 'address')->where('status', 0)->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Đơn hàng đã hủy',
            'data' => $order
        ], 200);
    }

    public function OrderDetail(Request $request, $id)
    {
        $order = Order_item::with('variant.product', 'variant.product.img', 'variant')->where('order_id', $id)->get();
        $orderInfo = Order::with('user', 'discount' ,'shipping', 'payment', 'coupon', 'address','order_items.variant.product.img')->where('id', $id)->first();
        return view('Admin.orderDetail', compact('order', 'orderInfo'));
        return response()->json([
            'status' => 200,
            'message' => 'Order List',
            'data' => [
                'orderInfo' => $orderInfo,
                'order_item' => $order
            ]
        ], 200);
    }

    public function topSoldProduct(Request $request)
    {
        $topSoldProducts = Order_item::with('variant.product')
            ->select('variant_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('variant_id')
            ->orderBy('total_quantity', 'desc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Top Sold Products',
            'data' => $topSoldProducts
        ], 200);
    }

    public function discount(Request $request)
    {
        $discount = Discount::paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Discount List',
            'data' => $discount
        ], 200);
    }

    public function addDiscount(Request $request)
    {
        $request->validate([
            'percentage' => 'required|integer|min:1|max:100',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
        ]);

        $discount = new Discount();
        $discount->percentage = $request->percentage;
        $discount->start_day = $request->start_day;
        $discount->end_day = $request->end_day;
        $discount->save();

        return response()->json([
            'status' => 200,
            'message' => 'Thêm mã giảm giá thành công',
            'data' => $discount
        ], 200);
    }

    public function updateDiscount(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy mã giảm giá'
            ], 404);
        }
        $discount->percentage = $request->percentage;
        $discount->start_date = $request->start_date;
        $discount->end_date = $request->end_date;
        $discount->save();

        return response()->json([
            'status' => 200,
            'message' => 'Cập nhật mã giảm giá thành công',
            'data' => $discount
        ], 200);
    }

    public function deleteDiscount(Request $request, $id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy mã giảm giá nào'
            ], 404);
        }

        $discount->delete();

        return response()->json([
            'status' => 200,
            'message' => 'Đã xóa mã giảm giá thành công',
        ], 200);
    }

    public function review(Request $request)
    {
        $review = Review::with('user', 'product')->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đánh giá',
            'data' => $review
        ], 200);
    }

      public function Chart(){
        $user = User::all();
        $userCount = $user->count();
        $activeCount = $user->where('is_active', 'on')->count();
        $inactiveCount = $user->where('is_active', 'off')->count();

        return response()->json([
            'status' => 200,
            'message' => 'Thống kê người dùng',
            'data' => [
                'total_users' => $userCount,
                'active_users' => $activeCount,
                'inactive_users' => $inactiveCount,
            ],
        ], 200);
    }

    public function OrderChart(){
        $order = Order::all();
        $orderCount = $order->count();
        $orderSoldCount = $order->where('status', 1)->count();
        $orderCancelCount = $order->where('status', 0)->count();

        return response()->json([
            'status' => 200,
            'message' => 'Thống kê đơn hàng',
            'data' => [
                'total_orders' => $orderCount,
                'sold_orders' => $orderSoldCount,
                'cancel_orders' => $orderCancelCount,
            ],
        ], 200);
    }

    public function ProductChart(){
        $product = Product::all();
        $productCount = $product->count();
        $variantCount = Variant::all()->count();

        return response()->json([
            'status' => 200,
            'message' => 'Thống kê sản phẩm',
            'data' => [
                'total_products' => $productCount,
                'total_variants' => $variantCount,
            ],
        ], 200);
    }
}

