<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Img;
use App\Models\Order;
use App\Models\Order_item;
use App\Models\Variant;
use App\Models\Category;
use App\Models\User;
use App\Models\Discount;
use App\Models\Review;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $user = auth()->user();
        $productId = $request->input('product_id');

        $quantity = $request->input('quantity', 1);

        $product = Product::find($productId);
        if (!$product) {
            return response()->json(['message' => 'Không có sản phẩm trong giỏ hàng'], 404);
        }

        $cartItem = Order_item::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $productId,
            ],
            ['quantity' => $quantity]
        );

        return response()->json(['message' => 'Thêm sản phẩm trong giỏ hàng', 'cart_item' => $cartItem], 200);
    }

    public function viewCart()
    {
        $user = auth()->user();
        $cartItems = Order_item::with('product')->where('user_id', $user->id)->get();

        return response()->json(['cart_items' => $cartItems], 200);
    }

    public function removeFromCart($id)
    {
        $user = auth()->user();
        $cartItem = Order_item::where('user_id', $user->id)->where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found'], 404);
        }

        $cartItem->delete();

        return response()->json(['message' => 'Cart item removed successfully'], 200);
    }

    public function clearCart()
    {
        $user = auth()->user();
        Order_item::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Cart cleared successfully'], 200);
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();
        $cartItems = Order_item::where('user_id', $user->id)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 400);
        }

        $order = Order::create([
            'user_id' => $user->id,
            'total_amount' => $cartItems->sum(function ($item) {
                return $item->product->price * $item->quantity;
            }),
            'status' => 'pending',
        ]);

        foreach ($cartItems as $item) {
            $order->items()->attach($item->product_id, ['quantity' => $item->quantity]);
        }
        Order_item::where('user_id', $user->id)->delete();

        return response()->json(['message' => 'Checkout successful', 'order' => $order], 200);
    }

    public function orderHistory()
    {
        $user = auth()->user();
        $orders = Order::with('items.product')->where('user_id', $user->id)->get();

        return response()->json(['orders' => $orders], 200);
    }

    public function orderDetail($id)
    {
        $user = auth()->user();
        $order = Order::with('items.product')->where('id', $id)->where('user_id', $user->id)->first();

        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        return response()->json(['order' => $order], 200);
    }
}
