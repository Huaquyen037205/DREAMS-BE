<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Img;
use App\Models\Variant;
use App\Models\Category;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function productAdmin(){
        $product = Product::with('img', 'variant', 'category')->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Product List',
            'data' => $product
        ],200);
    }


    public function updateProduct(Request $request, $id){
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Product Not Found',
            ], 404);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'required|boolean',
            'category_id' => 'required|exists:categories,id',
            'imgs' => 'required|array',
            'imgs.*' => 'required|string',
            'variants' => 'required|array',
            'variants.*.size' => 'required|string',
            'variants.*.color' => 'required|string',
            'variants.*.quantity' => 'required|integer',
        ]);

        $product->update($validatedData);

        foreach ($request->imgs as $imgUrl) {
            Img::create([
                'product_id' => $id,
                'url' => $imgUrl
            ]);
        }

        foreach ($request->variants as $variant) {
            Variant::create([
                'product_id' => $id,
                'size' => $variant['size'],
                'color' => $variant['color'],
                'quantity' => $variant['quantity']
            ]);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Product and related data updated successfully',
            'data' => Product::with('img', 'variant')->find($id)
        ], 200);
    }

      public function addProduct(Request $request){
        $product = Product::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Thêm sản phẩm thành công',
            'data' => $product
        ],200);
    }

     public function editProduct($id){
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

    public function deleteProduct($id){
        $product = Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa sản phẩm thành công',
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ],404);
        }
    }

    public function categoryAdmin(){
        $category = Category::all();
        return response()->json([
            'status' => 200,
            'message' => 'Category List',
            'data' => $category
        ],200);
    }

    public function addCategory(Request $request){
        $category = Category::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Category Created',
            'data' => $category
        ],200);
    }

    public function editCategory(Request $request,$id){

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        if($category){
            $category->name = $request->name;
        }
        if($category->save()){
            return response()->json([
                'status' => 200,
                'message' => 'Category Found',
                'data' => $category
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Category Not Found',
            ],404);
        }
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        if($category){
            $category->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa danh mục thành công',
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy danh mục',
            ],404);
        }
    }

     public function searchProductAdmin(Request $request){
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
                'message' => 'Tôi đai',
                'data' => $product
            ],200);
        }
    }

    public function addVariant(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'img_id' => 'required|exists:img,id',
            'size' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);
        $variant = Variant::create($request->all());
        // Log::info($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Thêm biển thể sản phẩm thành công',
            'data' => $variant
        ],200);
    }

    public function editVariant(Request $request, $id){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'img_id' => 'required|exists:img,id',
            'size' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'status' => 'required|string|max:255',
        ]);
        $variant = Variant::find($id);
        if($variant){
            $variant->update($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật biến thể sản phẩm thành công',
                'data' => $variant
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy biến thể sản phẩm',
            ],404);
        }
    }

    public function deleteVariant($id){
        $variant = Variant::find($id);
        if($variant){
            $variant->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa biến thể sản phẩm thành công',
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy biến thể sản phẩm',
            ],404);
        }
    }

    public function addImg(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'url' => 'required|string|max:255',
        ]);
        $img = Img::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Thêm ảnh sản phẩm thành công',
            'data' => $img
        ],200);
    }
}
