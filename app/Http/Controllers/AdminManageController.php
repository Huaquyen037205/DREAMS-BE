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
use Carbon\Carbon;
use App\Models\Notification;
use App\Mail\OrderInvoiceMail;
use Illuminate\Support\Facades\Mail;
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

        $statusOrder = [
        'pending' => 1,
        'processing' => 2,
        'paid' => 3,
        'cancelled' => 4,
    ];

    $current = $statusOrder[$order->status];
    $next = $statusOrder[$request->status];

    if ($next <= $current) {
        return redirect()->back()->with('error', 'Không thể chuyển về trạng thái trước hoặc trạng thái hiện tại!');
    }

    if ($order->status !== 'paid' && $request->status === 'paid') {
        $orderItems = Order_item::where('order_id', $order->id)->get();
        foreach ($orderItems as $item) {
            if ($item->variant) {
                $item->variant->stock_quantity -= $item->quantity;
                if ($item->variant->stock_quantity < 0) $item->variant->stock_quantity = 0;
                $item->variant->save();
            }

            if ($item->variant->stock_quantity <= 10 && $item->variant->stock_quantity > 0) {
                Notification::create([
                    'user_id' => null,
                    'message' => '📦 Sản phẩm "' . $item->variant->product->name . '" chỉ còn ' . $item->variant->stock_quantity . ' sản phẩm!',
                    'status' => 'unread',
                ]);
            }
            if ($item->variant->stock_quantity == 0) {
                Notification::create([
                    'user_id' => null,
                    'message' => '❌ Sản phẩm "' . $item->variant->product->name . '" đã hết hàng!',
                    'status' => 'unread',
                ]);
            }

            elseif ($item->product_id) {
                $product = Product::find($item->product_id);
                if ($product && isset($product->stock_quantity)) {
                    $product->stock_quantity -= $item->quantity;
                    if ($product->stock_quantity < 0) $product->stock_quantity = 0;
                    $product->save();
                }
            }
        }
    }

        if ($order->status !== 'paid' && $request->status === 'paid') {
        $orderItems = Order_item::where('order_id', $order->id)->get();
        foreach ($orderItems as $item) {
            $product = $item->variant->product ?? null;
            if ($product) {
                $product->hot = ($product->hot ?? 0) + $item->quantity;
                $product->save();
            }
        }
    }

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Trạng thái đơn hàng đã được cập nhật.');
    }

    public function markNotificationsRead(Request $request)
    {
        Notification::where('status', 'unread')->update(['status' => 'read']);
        return response()->json(['success' => true]);
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

    public function ShowOrder(Request $request){
        $orders = Order::with('user', 'discount', 'shipping', 'payment', 'coupon', 'address')
            ->orderByDesc('created_at')
            ->paginate(12);

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đơn hàng',
            'data' => $orders
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

    public function searchOrder(Request $request){
       $search = $request->input('search');
        $query = Order::with('user')->orderByDesc('created_at');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('vnp_TxnRef', 'like', "%$search%")
                ->orWhere('order_code', 'like', "%$search%")
                ->orWhereHas('user', function($q2) use ($search) {
                    $q2->where('email', 'like', "%$search%");
                });
            });
        }

        $orders = $query->paginate(10);

        return view('Admin.orderList' , compact('orders'));
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

    public function removeExpiredDiscounts()
    {
        $now = now();
        $expiredDiscounts = Discount::where('end_day', '<', $now)->get();

        foreach ($expiredDiscounts as $discount) {
            $products = Product::where('discount_id', $discount->id)->get();
            foreach ($products as $product) {
                $product->discount_id = null;
                $product->save();
                foreach ($product->variant as $variant) {
                    $variant->sale_price = null;
                    $variant->save();
                }
            }
        }
    }

    public function discount(Request $request)
    {
        $this->removeExpiredDiscounts();
        $discounts = Discount::orderBy('created_at', 'desc')->paginate(12);
        return view ('Admin.discountList', compact('discounts'));
        return response()->json([
            'status' => 200,
            'message' => 'Discount List',
            'data' => $discounts
        ], 200);
    }

    public function searchDiscount(Request $request){
        $name = $request->input('search');
        $query = Discount::query();

        if ($name) {
            $query->where('name', 'like', '%' . $name . '%');
        }

        $discounts = $query->orderBy('created_at', 'desc')->paginate(12);
        return view ('Admin.discountList', ['discounts' => $discounts]);
        return response()->json([
            'status' => 200,
            'message' => 'Kết quả tìm kiếm chương trình giảm giá',
            'data' => $discounts
        ], 200);
    }

    public function discountDetail($id){
        $this->removeExpiredDiscounts();
        $discount = Discount::with('products')->find($id);
        if (!$discount) {
            return redirect('/admin/discount')->with('error', 'Không tìm thấy chương trình giảm giá');
        }
        return view('Admin.discountDetail', compact('discount'));
    }

    public function addDiscount(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'percentage' => 'required|integer|min:1|max:100',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
        ], [
            'name.required' => 'Tên mã giảm giá là bắt buộc',
            'percentage.required' => 'Phần trăm giảm giá là bắt buộc',
            'percentage.integer' => 'Phần trăm giảm giá phải là một số nguyên',
            'percentage.min' => 'Phần trăm giảm giá phải lớn hơn 0',
            'percentage.max' => 'Phần trăm giảm giá không được vượt quá 100',
            'start_day.required' => 'Ngày bắt đầu là bắt buộc',
            'end_day.required' => 'Ngày kết thúc là bắt buộc',
            'end_day.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        $discount = new Discount();
        $discount->name = $request->name;
        $discount->percentage = $request->percentage;
        $discount->start_day = $request->start_day;
        $discount->end_day = $request->end_day;
        $discount->save();
        return view ('Admin.addDiscount');
        return response()->json([
            'status' => 200,
            'message' => 'Thêm mã giảm giá thành công',
            'data' => $discount
        ], 200);
    }

    public function editDiscount(Request $request, $id)
    {
        $this->removeExpiredDiscounts();
        $request->validate([
            'name' => 'required',
            'percentage' => 'required|integer|min:1|max:100',
            'start_day' => 'required|date',
            'end_day' => 'required|date|after_or_equal:start_day',
        ], [
            'name.required' => 'Tên mã giảm giá là bắt buộc',
            'percentage.required' => 'Phần trăm giảm giá là bắt buộc',
            'percentage.integer' => 'Phần trăm giảm giá phải là một số nguyên',
            'percentage.min' => 'Phần trăm giảm giá phải lớn hơn 0',
            'percentage.max' => 'Phần trăm giảm giá không được vượt quá 100',
            'start_day.required' => 'Ngày bắt đầu là bắt buộc',
            'end_day.required' => 'Ngày kết thúc là bắt buộc',
            'end_day.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu',
        ]);

        $discount = Discount::findOrFail($id);
        $discount->name = $request->name;
        $discount->percentage = $request->percentage;
        $discount->start_day = $request->start_day;
        $discount->end_day = $request->end_day;
        $discount->save();

        $selectedProducts = $request->products ?? [];

        if (!empty($selectedProducts)) {
            foreach ($selectedProducts as $productId) {
            $product = Product::with('variant')->find($productId);
            if ($product) {
                $now = now()->toDateString();
                if ($product->discount_id && $product->discount_id != $discount->id) {
                        $product->discount_id = null;
                }
                $product->discount_id = $discount->id;
                $product->save();

                foreach ($product->variant as $variant) {
                    if ($discount->start_day <= $now && $discount->end_day >= $now) {
                        $variant->sale_price = round($variant->price * (1 - $discount->percentage / 100));
                    } else {
                        $variant->sale_price = null;
                    }
                    $variant->save();
            }
        }
    }
            $productsToRemove = Product::where('discount_id', $discount->id)
                ->whereNotIn('id', $selectedProducts)
                ->get();
            foreach ($productsToRemove as $product) {
                $product->discount_id = null;
                $product->save();
                foreach ($product->variant as $variant) {
                    $variant->sale_price = null;
                    $variant->save();
                }
            }
        } else {

            $productsToRemove = Product::where('discount_id', $discount->id)->get();
            foreach ($productsToRemove as $product) {
                $product->discount_id = null;
                $product->save();
                foreach ($product->variant as $variant) {
                    $variant->sale_price = null;
                    $variant->save();
                }
            }
        }

        return redirect('/admin/discount')->with('success', 'Cập nhật mã giảm giá thành công!');
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

    public function starAverage(){
        $starAverage = Review::select('product_id', DB::raw('AVG(rating) as average_star'))
            ->groupBy('product_id')
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->product_id => round($item->average_star, 1)];
            });

        return response()->json([
            'status' => 200,
            'message' => 'Trung bình sao của sản phẩm',
            'data' => $starAverage
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
        $totalSells = Order::where('status', 'paid')->sum('total_price');
        $totalOrders = Order::count();
        $totalProducts = Product::count();
        $dailyVisitors = User::count();
        $salesByMonth = Order::where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $salesByDay = Order::where('status', 'paid')
            ->where('created_at', '>=', Carbon::now()->subDays(6)->startOfDay())
            ->selectRaw('DATE(created_at) as day, SUM(total_price) as total')
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day')
            ->toArray();

        $ordersToday = Order::with('user', 'shipping', 'payment')
            ->whereDate('created_at', now()->startOfDay())
            ->orderByDesc('created_at')
            ->paginate(8);

        $hotProduct = Product::with('variant', 'img')
            ->orderBy('hot', 'desc')
            ->take(6)
            ->get();

        $profit = Order::where('status', 'paid')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $refunds = Order::where('status', 'cancelled')
            ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $expenses = [];

        $monthlyStats = [
            'profit' => [],
            'refunds' => [],
            'expenses' => [],
        ];
        for ($i = 1; $i <= 12; $i++) {
            $monthlyStats['profit'][] = isset($profit[$i]) ? $profit[$i] : 0;
            $monthlyStats['refunds'][] = isset($refunds[$i]) ? $refunds[$i] : 0;
            $monthlyStats['expenses'][] = isset($expenses[$i]) ? $expenses[$i] : 0;
        }
        return view('Admin.dashBoard', compact('totalSells', 'totalOrders', 'dailyVisitors', 'salesByMonth', 'salesByDay', 'monthlyStats', 'totalProducts', 'profit', 'refunds', 'expenses', 'ordersToday', 'hotProduct'));
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

    public function printInvoice($id)
    {
        $order = Order::with('user', 'order_items.variant.product', 'shipping', 'payment', 'address')->findOrFail($id);
        return view('Admin.invoice', compact('order'));
    }

    public function sendInvoiceMail($id)
    {
        $order = Order::with('user', 'order_items.variant.product')->findOrFail($id);
        Mail::to($order->user->email)->send(new OrderInvoiceMail($order));
        return back()->with('success', 'Đã gửi hóa đơn tới email khách hàng!');
    }

    public function notifications()
    {
        $notifications = Notification::orderByDesc('created_at')->paginate(10);
        return view('Admin.notification', compact('notifications'));
    }
}
