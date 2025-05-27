<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Img;
use App\Models\Variant;
use App\Models\Category;
use App\Models\User;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function productAdmin(){
        $products = Product::with('img', 'variant', 'category')->paginate(8);
        return view('Admin.productList', ['products' => $products]);
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm',
            'data' => $products
        ],200);
    }

   public function productById(Request $request, $id) {
    $product = Product::with(['variant.img'])->find($id);
    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy sản phẩm',
        ], 404);
    }
    return view('Admin.productById', [
        'product' => $product
    ]);
}

    public function addProduct(Request $request){
        $product = Product::create($request->all());
        return view('Admin.add_product', ['product' => $product]);
        if($request->wantsJson() || $request->expectsJson()){
            return response()->json([
                'status' => 200,
                'message' => 'Thêm sản phẩm thành công',
                'data' => $product
            ],200);

            return redirect()->back()->with('success', 'Thêm sản phẩm thành công');
         } else {
            if($request->expectsJson() || $request->wantsJson()){
                return response()->json([
                'status' => 404,
                'message' => 'Thêm sản phẩm thất bại',
                ],404);
            }
            return redirect()->back()->with('error', 'Thêm sản phẩm thất bại');
        }
    }

    public function editProduct(Request $request, $id){
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|integer',
            'description' => 'nullable|string',
            'status' => 'required|string',
            'active' => 'nullable|in:on,off',
            'view' => 'nullable|integer',
            'hot' => 'nullable|integer',
        ]);

        $product = Product::findOrFail($id);
        if($product){
            $product->name = $request->name;
            $product->category_id = $request->category_id;
            $product->description = $request->description;
            $product->status = $request->status;
            $product->active = $request->active;
            $product->view = $request->view;
            $product->hot = $request->hot;
            if($product->save()){
                return redirect()->back()->with('success', 'Cập nhật sản phẩm thành công');
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
                return redirect()->back()->with('error', 'Cập nhật sản phẩm thất bại');
            }
        }
    }

      public function setActiveProduct(Request $request, $id)
    {
        $request->validate([
        'active' => 'required|in:on,off',
        ]);

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => 404,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }

        $product->active = $request->active;
        $product->save();

        return response()->json([
            'status' => 200,
            'message' => $request->active === 'on' ? 'Kích hoạt sản phẩm thành công' : 'Ngừng kích sản phẩm thành công',
        ], 200);
    }

    public function setVariantActive(Request $request, $id){
        $request->validate([
        'active' => 'required|in:on,off',
        ]);

        $variant = Variant::find($id);

        if (!$variant) {
            return response()->json([
                'status' => 404,
                'message' => 'Người dùng không tồn tại',
            ], 404);
        }

        $variant->active = $request->active;
        $variant->save();

        return response()->json([
            'status' => 200,
            'message' => $request->active === 'on' ? 'Kích hoạt biến thể thành công' : 'Ngừng kích hoạt biến thể thành công',
        ], 200);
    }

    public function flashSale(Request $request){
        $product = Product::where('flash_sale', 1)->get();
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm flash sale',
            'data' => $product
        ],200);
    }

    public function addFashSale(Request $request){
        $product = Product::find($request->id);
        if($product){
            $product->flash_sale = 1;
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Thêm sản phẩm vào flash sale thành công',
                'data' => $product
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ],404);
        }
    }

    public function deleteFashSale($id){
        $product = Product::find($id);
        if($product){
            $product->flash_sale = 0;
            $product->save();
            return response()->json([
                'status' => 200,
                'message' => 'Xóa sản phẩm khỏi flash sale thành công',
                'data' => $product
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
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
            ->paginate(12);
            return view('Admin.productList', ['products' => $product]);
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
        $variant = Variant::with('product', 'img')->paginate(8);
        return view('Admin.variantList', ['variants' => $variant]);
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
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'active' => 'nullable|in:on,off',
        ]);
        $variant = Variant::create($request->all());
        return redirect()->back()->with('success', 'Thêm biến thể sản phẩm thành công');
        // Log::info($request->all());
        return response()->json([
            'status' => 200,
            'message' => 'Thêm biển thể sản phẩm thành công',
            'data' => $variant
        ],200);

    }

    public function searchVariantAdmin(Request $request){
        $search = $request->input('search');
         $variants = Variant::with('product', 'img')
            ->where(function($query) use ($search) {
                $query->whereHas('product', function($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%");
                })->orWhere('size', 'LIKE', "%{$search}%");
            })
            ->paginate(8);
            return view('Admin.variantList', ['variants' => $variants]);
            if($variant->isEmpty()){
                return response()->json([
                    'status' => 404,
                    'message' => 'Không tìm thấy biến thể sản phẩm',
                ],404);
            }else{
                return response()->json([
                    'status' => 200,
                    'message' => 'Tôi đai',
                    'data' => $variant
                ],200);
            }
        }

    public function editVariant(Request $request, $id){
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'size' => 'required|string|max:255',
            'stock_quantity' => 'required|integer',
            'price' => 'required|numeric',
            'sale_price' => 'nullable|numeric',
            'status' => 'required|string|max:255',
            'active' => 'nullable|in:on,off',
        ]);
        $variant = Variant::findOrFail($id);
        if($variant) {
            $variant->product_id = $request->product_id;
            $variant->size = $request->size;
            $variant->stock_quantity = $request->stock_quantity;
            $variant->price = $request->price;
            $variant->sale_price = $request->sale_price;
            $variant->status = $request->status;
            $variant->active = $request->active;
            if ($variant->save()) {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'status' => 200,
                        'message' => 'Cập nhật biến thể thành công',
                        'data' => $variant
                    ], 200);
                }
                return redirect()->back()->with('success', 'Cập nhật biến thể thành công');
            } else {
                if ($request->wantsJson() || $request->ajax()) {
                    return response()->json([
                        'status' => 500,
                        'message' => 'Cập nhật biến thể thất bại',
                    ], 500);
                }
                return redirect()->back()->with('error', 'Cập nhật biến thể thất bại');
            }
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

    public function addImg(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'name' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('name')) {
            $file = $request->file('name');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/img', $filename);

            $img = new Img();
            $img->product_id = $request->product_id;
            $img->name = $filename;

            if ($img->save()) {
                return response()->json([
                    'status' => 200,
                    'message' => 'Thêm hình ảnh thành công',
                    'data' => $img,
                    'image_url' => asset('storage/img/' . $filename)
                ]);
            } else {
                return response()->json([
                    'status' => 500,
                    'message' => 'Thêm hình ảnh thất bại',
                ], 500);
            }
        }

        return response()->json([
            'status' => 400,
            'message' => 'Không có file hình ảnh',
        ], 400);
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
