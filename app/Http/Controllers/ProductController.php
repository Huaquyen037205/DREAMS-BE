<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Img;
use App\Models\Variant;
use App\Models\Category;
use App\Models\User;
use App\Models\Discount;
use App\Models\Review;
use App\Models\Order;
use App\Models\Discount_user;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{

    public function product() {
    $now = now();

    // Lấy danh sách product_id đang thuộc flash sale đang hoạt động
    $flashSaleProductIds = DB::table('flash_sale_variants')
        ->join('flash_sales', 'flash_sale_variants.flash_sale_id', '=', 'flash_sales.id')
        ->join('variant', 'flash_sale_variants.variant_id', '=', 'variant.id')
        ->where('flash_sales.start_time', '<=', $now)
        ->where('flash_sales.end_time', '>=', $now)
        ->pluck('variant.product_id')
        ->unique();

    // Lấy sản phẩm KHÔNG nằm trong chương trình flash sale đang hoạt động
    $product = Product::with('img', 'variant', 'category')
        ->whereNotIn('id', $flashSaleProductIds)
        ->paginate(12);

    return response()->json([
        'status' => 200,
        'message' => 'Danh sách sản phẩm',
        'data' => $product
    ], 200);
}


public function hotProduct() {
    $now = now();

    // Lấy danh sách product_id đang thuộc flash sale đang hoạt động
    $flashSaleProductIds = DB::table('flash_sale_variants')
        ->join('flash_sales', 'flash_sale_variants.flash_sale_id', '=', 'flash_sales.id')
        ->join('variant', 'flash_sale_variants.variant_id', '=', 'variant.id')
        ->where('flash_sales.start_time', '<=', $now)
        ->where('flash_sales.end_time', '>=', $now)
        ->pluck('variant.product_id')
        ->unique();

    // Lấy nhiều sản phẩm có lượt hot >= 10, KHÔNG nằm trong chương trình flash sale, sắp xếp theo hot giảm dần
    $products = Product::with('img', 'variant', 'category')
        ->where('hot', '>=', 10)
        ->whereNotIn('id', $flashSaleProductIds)
        ->orderByDesc('hot')
        ->get();

    return response()->json([
        'status' => 200,
        'message' => 'Hot sản phẩm',
        'data' => $products
    ], 200);
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

    public function discountUser(Request $request){
       $validate = $request->validate([
            'code' => 'required|string|max:255',
        ]);

        $user = auth()->user;
        $discount = Discount::where('code', $request->code)
        ->whereDate('start_day', '<=', now())
        ->whereDate('end_day', '>=', now())
        ->first();
        if (!$discount) {
            return response()->json([
                'status' => 404,
                'message' => 'Mã giảm giá không hợp lệ hoặc đã hết hạn',
            ], 404);
        }

        $discount_user = Discount_user::where('user_id', $user->id)
        ->where('discount_id', $discount->id)
        ->first();
        if ($discount_user) {
            return response()->json([
                'status' => 400,
                'message' => 'Bạn đã sử dụng mã giảm giá này',
            ], 400);
        }

        Discount_user::create([
            'user_id' => $user->id,
            'discount_id' => $discount->id,
            'used_at' => now(),
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Áp dụng mã giảm giá thành công',
            'discount' => $discount
        ], 200);
    }

    public function productById($id) {
    $product = Product::with('img', 'variant', 'category')->where('id', $id)->first();

    if (!$product) {
        return response()->json([
            'status' => 404,
            'message' => 'Không tìm thấy sản phẩm',
        ], 404);
    }

    $now = now();
    $variantIds = $product->variant->pluck('id')->toArray();

    // Lấy tất cả flash sale variant của sản phẩm này
    $flashSaleVariants = DB::table('flash_sale_variants')
        ->join('flash_sales', 'flash_sale_variants.flash_sale_id', '=', 'flash_sales.id')
        ->whereIn('flash_sale_variants.variant_id', $variantIds)
        ->where('flash_sales.start_time', '<=', $now)
        ->where('flash_sales.end_time', '>=', $now)
        ->select('flash_sale_variants.sale_price')
        ->get();

    if ($flashSaleVariants->count() > 0) {
        // Lấy giá flash sale đầu tiên (áp dụng cho tất cả size)
        $flashSalePrice = $flashSaleVariants->first()->sale_price;
        foreach ($product->variant as $variant) {
            $variant->final_price = $flashSalePrice;
            $variant->price_type = 'flash_sale';
        }
    } else {
        foreach ($product->variant as $variant) {
            if (!empty($variant->sale_price)) {
                $variant->final_price = $variant->sale_price;
                $variant->price_type = 'sale_price';
            } else {
                $variant->final_price = $variant->price;
                $variant->price_type = 'origin';
            }
        }
    }

    // Lọc trùng theo 'size' để tránh lặp lại size giống nhau
    $product->variant = $product->variant->unique('size')->values();

    return response()->json([
        'status' => 200,
        'message' => 'Chi tiết sản phẩm',
        'data' => $product
    ], 200);
}

        public function productByPrice(Request $request)
    {
        $min = $request->input('min', 0);
        $max = $request->input('max', null);

        if (!is_numeric($min) || ($max !== null && !is_numeric($max))) {
            return response()->json([
                'status' => 400,
                'message' => 'Giá không hợp lệ',
            ], 400);
        }

        $products = Product::with(['img', 'variant', 'category'])
            ->whereHas('variant', function($query) use ($min, $max) {
                $query->whereRaw('COALESCE(sale_price, price) >= ?', [$min]);
                if ($max !== null) {
                    $query->whereRaw('COALESCE(sale_price, price) <= ?', [$max]);
                }
            })
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm theo khoảng giá',
            'data' => $products
        ], 200);
    }

    public function filterAll(Request $request)
    {
        $size = strtoupper($request->input('size', null));
        $min = $request->input('min', 0);
        $max = $request->input('max', null);
        $sort = $request->input('sort', 'asc'); // 'asc' hoặc 'desc'

        if (!in_array($sort, ['asc', 'desc'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Tham số sắp xếp không hợp lệ. Chỉ chấp nhận asc hoặc desc.',
            ], 400);
        }

        if ($size && !in_array($size, ['S', 'M', 'L', 'XL'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Size không hợp lệ. Chỉ chấp nhận S, M, L, XL.',
            ], 400);
        }

        $query = Product::with([
            'img',
            'category',
            'variant' => function ($q) use ($size, $sort) {
                if ($size) {
                    $q->where('size', $size);
                }
                $q->orderByRaw('COALESCE(sale_price, price) ' . $sort);
            }
        ]);

        // Lọc theo size
        if ($size) {
            $query->whereHas('variant', function ($q) use ($size) {
                $q->where('size', $size);
            });
        }

        // Lọc theo giá
        $query->whereHas('variant', function ($q) use ($min, $max) {
            $q->whereRaw('COALESCE(sale_price, price) >= ?', [$min]);
            if ($max !== null) {
                $q->whereRaw('COALESCE(sale_price, price) <= ?', [$max]);
            }
        });

        $products = $query->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm phù hợp.',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm đã lọc.',
            'data' => $products
        ], 200);
    }

    public function filterBySize(Request $request)
    {
        $size = strtoupper($request->input('size'));

        // Chỉ cho phép S, M, L
        if (!in_array($size, ['S', 'M', 'L', 'XL'])) {
            return response()->json([
                'status' => 400,
                'message' => 'Size không hợp lệ. Chỉ chấp nhận S, M, L, XL',
            ], 400);
        }

        $products = Product::with(['img', 'variant' => function($query) use ($size) {
                $query->where('size', $size);
            }, 'category'])
            ->whereHas('variant', function($query) use ($size) {
                $query->where('size', $size);
            })
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Không tìm thấy sản phẩm với size này',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách sản phẩm theo size',
            'data' => $products
        ], 200);
    }


    public function getReviews(Request $request)
    {
        $product_id = $request->query('product_id');
        $query = Review::with('user');
        if ($product_id) {
            $query->where('product_id', $product_id);
        }
        $reviews = $query->orderByDesc('created_at')->get();
        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đánh giá',
            'data' => $reviews
        ], 200);
    }

    public function reviewByProductId($product_id)
    {
        $reviews = Review::with('user')
            ->where('product_id', $product_id)
            ->orderByDesc('created_at')
            ->get();

        if ($reviews->isEmpty()) {
            return response()->json([
                'status' => 404,
                'message' => 'Không có đánh giá cho sản phẩm này',
            ], 404);
        }

        return response()->json([
            'status' => 200,
            'message' => 'Danh sách đánh giá cho sản phẩm',
            'data' => $reviews
        ], 200);
    }

    public function reviews(Request $request){
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000'
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['status' => 401, 'message' => 'Unauthenticated'], 401);
        }

       $hasPurchased = Order::where('user_id', $user->id)
        ->where('status', 'paid')
        ->whereHas('order_items', function($query) use ($request) {
            $query->whereHas('variant', function($q) use ($request) {
                $q->where('product_id', $request->product_id);
            });
        })
        ->exists();
        if (!$hasPurchased) {
            return response()->json([
                'status' => 403,
                'message' => 'Bạn phải mua sản phẩm này mới có thể đánh giá',
            ], 403);
        }

        $review = new Review();
        $review->product_id = $request->product_id;
        $review->user_id = $user->id;
        $review->rating = $request->rating;
        $review->comment = $request->comment;
        $review->save();
        return response()->json([
            'status' => 201,
            'message' => 'Đánh giá sản phẩm thành công',
            'data' => $review
        ], 200);
    }
public function productsByCategoryId(Request $request)
{
    $categoryId = $request->query('category_id');
    if (!$categoryId) {
        return response()->json([
            'status' => 400,
            'message' => 'Thiếu category_id'
        ], 400);
    }

    $products = Product::with(['variant', 'img', 'category'])
        ->where('category_id', $categoryId)
        ->get();

    return response()->json([
        'status' => 200,
        'message' => 'Danh sách sản phẩm theo category',
        'data' => $products
    ], 200);
}
    public function deleteReview(Request $request, $id){
        $review = Review::findOrFail($id);
        if ($review->user_id !== auth()->id()) {
            return response()->json([
                'status' => 403,
                'message' => 'Bạn không có quyền xóa đánh giá này',
            ], 403);
        }
        $review->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Đánh giá đã được xóa thành công',
        ], 200);
    }
}
