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
        $user->wishlist()->syncWithoutDetaching([$productId]);
        return response()->json(['message' => 'Đã thêm vào yêu thích']);
    }

    public function destroy($productId)
    {
        $user = auth()->user();
        $user->wishlist()->detach($productId);
        return response()->json(['message' => 'Đã xóa khỏi yêu thích']);
    }
}
