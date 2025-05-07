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
        $product = Product::with('img', 'variant', 'category')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Product List',
            'data' => $product
        ],200);
    }

    public function productById($id){
        $product = Product::with('img', 'variant', 'category')->where('id', $id)->first();
        if($product){
            return response()->json([
                'status' => 200,
                'message' => 'Product Found',
                'data' => $product
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found',
            ],404);
        }
    }
}
