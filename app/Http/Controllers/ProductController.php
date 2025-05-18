<?php

namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Img;
use App\Models\Variant;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function product(){
        $product = Product::with('img', 'variant', 'category')->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm',
            'data' => $product
        ],200);
    }

    public function hotProduct(){
        $product = Product::with('img', 'variant', 'category')->where('hot', 1)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Hot sản phẩm',
            'data' => $product
        ],200);
    }

    public function viewProduct(){
        $product = Product::with('img', 'variant', 'category')->where('view', 1)->get();
        return response()->json([
            'status' => 200,
            'message' => 'View sản phẩm',
            'data' => $product
        ],200);
    }

    public function category(){
        $category = Category::with('product')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách danh mục',
            'data' => $category
        ],200);
    }

    public function productById($id){
        $product = Product::with('img', 'variant', 'category')->where('id', $id)->first();
        if($product){
            return response()->json([
                'status' => 200,
                'message' => 'Chi tiết sản phẩm',
                'data' => $product
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ],404);
        }
    }

    public function searchProduct(Request $request){
        $search = $request->input('search');
        $product = Product::with('img', 'variant', 'category')
            ->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->get();
        if($product->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ],404);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Tôi dei',
                'data' => $product
            ],200);
        }
    }

    public function productByCategory($id){
        $product = Product::with('img', 'variant', 'category')->where('category_id', $id)->get();
        if($product->isEmpty()){
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ],404);
        }else{
            return response()->json([
                'status' => 200,
                'message' => 'Danh sách sản phẩm theo danh mục',
                'data' => $product
            ],200);
        }
    }

    public function productByprice($price)
    {
    if (!is_numeric($price)) {
        return response()->json([
            'status' => 400,
            'message' => 'Giá không hợp lệ',
        ], 400);
    }

    $product = Product::with(['img', 'variant', 'category'])
        ->whereHas('variant', function($query) use ($price) {
            $query->whereRaw('COALESCE(sale_price, price) <= ?', [$price]);
        })
        ->get();

    if ($product->isEmpty()) {
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy sản phẩm',
        ], 404);
    }

    return response()->json([
        'status' => 200,
        'message' => 'Danh sách sản phẩm theo giá',
        'data' => $product
    ], 200);
}

    public function SortByPrice(Request $request)
    {
        $price = $request->input('price');
        $sort = $request->input('sort', 'asc');

        if (!$price || !is_numeric($price)) {
            return response()->json([
                'status' => 400,
                'message' => 'Giá không hợp lệ',
            ], 400);
        }

        if (!in_array(strtolower($sort), ['asc', 'desc'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Sort không hợp lệ',
            ], 400);
        }

        $products = Product::select('products.*')
            ->join('variant', 'products.id', '=', 'variant.product_id')
            ->with(['img', 'variant', 'category'])
            ->whereRaw('COALESCE(variant.sale_price, variant.price) <= ?', [$price])
            ->orderByRaw('COALESCE(variant.sale_price, variant.price) ' . $sort)
            ->distinct()
            ->get();
            return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm theo giá',
            'data' => $products
        ], 200);
    }
}
