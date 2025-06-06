<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class WishlistController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return response()->json($user->wishlist()->with('category', 'img')->get());
    }

    public function store($productId)
    {
        $user = auth()->user();
        // Kiểm tra sản phẩm đã có trong wishlist chưa
        if ($user->wishlist()->where('product_id', $productId)->exists()) {
            return response()->json(['message' => 'Sản phẩm đã có trong danh sách yêu thích'], 409);
        }
        $user->wishlist()->attach($productId);
        return response()->json(['message' => 'Đã thêm vào yêu thích']);
    }

    public function destroy($productId)
    {
        $user = auth()->user();
        $user->wishlist()->detach($productId);
        return response()->json(['message' => 'Đã xóa khỏi yêu thích']);
    }
}
