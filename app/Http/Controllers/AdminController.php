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
            'message' => 'Danh sách sản phẩm',
            'data' => $product
        ],200);
    }

      public function addProduct(Request $request){
        $product = Product::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Thêm sản phẩm thành công',
            'data' => $product
        ],200);
    }

     public function updateProduct(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'view' => 'nullable|integer',
            'hot' => 'nullable|integer',
        ]);

        $product = Product::find($id);
        if($product){
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->view = $request->view;
            $product->hot = $request->hot;
            if($product->save()){
                return response()->json([
                    'status' => 200,
                    'message' => 'Cập nhật sản phẩm thành công',
                    'data' => $product
                ],200);
            }else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy sản phẩm',
                ],404);
            }
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
            'message' => 'Danh sách danh mục',
            'data' => $category
        ],200);
    }

    public function addCategory(Request $request){
        $category = Category::create($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Tạo danh mục thành công',
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
                'message' => 'Cập nhật danh mục thành công',
                'data' => $category
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy danh mục',
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

    public function variantAdmin(){
        $variant = Variant::with('product', 'img')->paginate(12);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách biến thể sản phẩm',
            'data' => $variant
        ],200);
    }

    public function addVariant(Request $request){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'img_id' => 'required|exists:img,id',
            'size' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
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
            'sale_price' => 'nullable|numeric',
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
        // $request->validate([
        //     'product_id' => 'required|exists:products,id',
        //     'name' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        // ]);
            $img = new Img();
            $img->product_id = $request->product_id;
            $img->name = $request->name;

            if ($img->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Thêm hình ảnh thành công',
                    'data' => $img,
                ], 200);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Thêm hình ảnh thất bại',
                ], 500);
            }
        }

    public function editImg(Request $request, $id){
        $img = Img::find($id);
        if($img){
            $img->update($request->all());
            return response()->json([
                'status' => 200,
                'message' => 'Cập nhật hình ảnh thành công',
                'data' => $img
            ],200);
        }
            else{
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy hình ảnh',
                ],404);
            }
    }

    public function deleteImg($id){
        $img = Img::find($id);
        if($img){
            $img->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa hình ảnh thành công',
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy hình ảnh',
            ],404);
        }
    }
}
