<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index()
{
    $user = auth()->user();
    $wishlist = $user->wishlist()->with('category', 'img')->get();

    // Thêm size và price cho từng sản phẩm
    $wishlist = $wishlist->map(function ($product) {
        $variantM = DB::table('variant')
            ->where('product_id', $product->id)
            ->where('size', 'M')
            ->first();
        $productArr = $product->toArray();
        if ($variantM) {
            $productArr['size'] = $variantM->size;
            $productArr['price'] = $variantM->price;
            $productArr['variant_id'] = $variantM->id;
        }

        $image = $product->img->first()->name ?? null;
        $productArr['image_url'] = $image ? url('img/' . $image) : null;
        return $productArr;
    });

    return response()->json($wishlist);
}

    public function store($productId)
    {
        $user = auth()->user();
        if ($user->wishlist()->where('product_id', $productId)->exists()) {
            return response()->json(['message' => 'Sản phẩm đã có trong danh sách yêu thích'], 409);
        }
        $user->wishlist()->attach($productId);
        $product = Product::with('category', 'img')->find($productId);

        $variantM = DB::table('variant')
            ->where('product_id', $productId)
            ->where('size', 'M')
            ->first();

        if ($product && $variantM) {
            $productArr = $product->toArray();
            $productArr['size'] = $variantM->size;
            $productArr['price'] = $variantM->price;
            $productArr['variant_id'] = $variantM->id;
        } else {
            $productArr = $product ? $product->toArray() : null;
        }

        if ($product) {
        $image = $product->img->first()->name ?? null;
        $productArr['image_url'] = $image ? url('img/' . $image) : null;
    }

        return response()->json([
            'message' => 'Đã thêm vào yêu thích',
            'product' => $productArr
        ]);
    }

public function destroy($productId)
{
    $user = auth()->user();
    if (!$user->wishlist()->where('product_id', $productId)->exists()) {
        return response()->json(['message' => 'Sản phẩm không tồn tại trong danh sách yêu thích'], 404);
    }
    $user->wishlist()->detach($productId);

    return response()->json(['message' => 'Đã xóa khỏi danh sách yêu thích']);
}

}
