<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Flash_Sale;
use App\Models\Flash_Sale_Variant;
use App\Models\Variant;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class FlashSaleController extends Controller
{
    // Hiển thị danh sách các chương trình Flash Sale
    public function index()
    {
        $flashSales = Flash_Sale::orderByDesc('start_time')->paginate(10);
        return view('Admin.Fl_list', compact('flashSales'));
    }

    // Hiển thị form tạo chương trình mới
    public function create()
    {
        return view('Admin.Fl_add');
    }

    // Lưu chương trình mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ], [
            'name.required' => 'Vui lòng nhập tên chương trình.',
            'start_time.required' => 'Vui lòng chọn thời gian bắt đầu.',
            'end_time.required' => 'Vui lòng chọn thời gian kết thúc.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ]);

        Flash_Sale::create($request->only(['name', 'start_time', 'end_time']));

        return redirect('/admin/flash-sale')->with('success', 'Tạo chương trình thành công');
    }

    // Hiển thị danh sách sản phẩm để thêm vào chương trình
    public function showProducts($id)
        {
            $flashSale = Flash_Sale::findOrFail($id);

            // Lấy danh sách sản phẩm duy nhất có variant
            $products = Product::whereIn('id',
                Variant::pluck('product_id')->unique()
            )->with('img')->get();

            return view('Admin.Fl_addp', compact('flashSale', 'products'));
        }

    // Lưu sản phẩm vào chương trình Flash Sale
    public function addProduct(Request $request, $id)
{
    $request->validate([
        'product_id' => 'required|exists:products,id',
        'size' => 'required|string',
        'sale_price' => 'required|numeric|min:0',
        'flash_quantity' => 'required|integer|min:1',
    ]);

    // Lấy variant đúng theo sản phẩm và size
    $variant = \App\Models\Variant::where('product_id', $request->product_id)
        ->where('size', $request->size)
        ->first();

    if (!$variant) {
        return back()->withErrors(['Không tìm thấy biến thể size này!']);
    }

    // Kiểm tra số lượng tồn kho
    if ($request->flash_quantity > $variant->stock_quantity) {
        return back()->withErrors(['Số lượng flash sale không được lớn hơn số lượng còn lại!']);
    }

    // Lưu vào bảng flash_sale_variants
    DB::table('flash_sale_variants')->updateOrInsert(
        [
            'flash_sale_id' => $id,
            'variant_id' => $variant->id,
        ],
        [
            'sale_price' => $request->sale_price,
            'flash_quantity' => $request->flash_quantity,
            'flash_sold' => 0,
        ]
    );

    return redirect()->back()->with('success', 'Đã thêm sản phẩm vào chương trình');
}

    // Hiển thị form chỉnh sửa chương trình
    public function edit($id)
    {
        $sale = Flash_Sale::findOrFail($id);
        return view('Admin.Fl_edit', compact('sale'));
    }

    // Xoá chương trình Flash Sale
    public function destroy($id)
    {
        Flash_Sale::destroy($id);
        return redirect('/admin/flash-sale')->with('success', 'Đã xoá chương trình');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ], [
            'name.required' => 'Vui lòng nhập tên chương trình.',
            'start_time.required' => 'Vui lòng chọn thời gian bắt đầu.',
            'end_time.required' => 'Vui lòng chọn thời gian kết thúc.',
            'end_time.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ]);

        $flashSale = Flash_Sale::findOrFail($id);
        $flashSale->update($request->only(['name', 'start_time', 'end_time']));

        return redirect('/admin/flash-sale')->with('success', 'Cập nhật chương trình thành công');
    }

    public function show($id)
    {
        $flashSale = Flash_Sale::with(['variants.variant.product'])->findOrFail($id);
        return view('Admin.Fl_show', compact('flashSale'));
    }





public function apiActiveFlashSales()
{
    $now = now();

    $flashSales = Flash_Sale::where('start_time', '<=', $now)
        ->where('end_time', '>=', $now)
        ->orderByDesc('start_time')
        ->get();

    $result = [];
    foreach ($flashSales as $flashSale) {
        $variants = DB::table('flash_sale_variants')
            ->join('variant', 'flash_sale_variants.variant_id', '=', 'variant.id')
            ->join('products', 'variant.product_id', '=', 'products.id')
            ->where('flash_sale_variants.flash_sale_id', $flashSale->id)
            ->select(
                'products.id as product_id',
                'products.name as product_name',
                'variant.id as variant_id',
                'variant.size as size',                    // Size của variant
                'variant.price as original_price',         // Giá gốc của size
                'flash_sale_variants.sale_price as flash_sale_price', // Giá flash sale của size
                'flash_sale_variants.flash_quantity',
                'flash_sale_variants.flash_sold'
            )
            ->get();

        foreach ($variants as $variant) {
            $variant->images = DB::table('img')
                ->where('product_id', $variant->product_id)
                ->pluck('name');
        }

        $result[] = [
            'flash_sale_id' => $flashSale->id,
            'flash_sale_name' => $flashSale->name,
            'start_time' => $flashSale->start_time,
            'end_time' => $flashSale->end_time,
            'variants' => $variants
        ];
    }

    return response()->json($result);
}

public function updateVariant(Request $request, $flashsaleId, $variantId)
{
    $validated = $request->validate([
        'sale_price' => 'required|numeric|min:0',
        'flash_quantity' => 'required|integer|min:0',
    ]);

    $variant = Flash_Sale_Variant::where('flash_sale_id', $flashsaleId)
        ->where('id', $variantId)
        ->firstOrFail();

    $variant->update([
        'sale_price' => $validated['sale_price'],
        'flash_quantity' => $validated['flash_quantity'],
    ]);

    return redirect()->back()->with('success', 'Cập nhật thành công.');
}

// Xóa variant khỏi flash sale
public function destroyVariant($flashSaleId, $variantId)
{
    $variant = Flash_Sale_Variant::where('flash_sale_id', $flashSaleId)
        ->where('id', $variantId)
        ->firstOrFail();
    $variant->delete();
    return redirect()->route('flashsale.show', $flashSaleId)->with('success', 'Đã xóa sản phẩm khỏi chương trình!');
}


public function apiProductVariants($id)
{
    $variants = DB::table('variant')
        ->where('product_id', $id)
        ->get()
        ->map(function ($variant) {
            $img = DB::table('img')->where('id', $variant->img_id)->first();
            $variant->img = $img ? asset('img/' . $img->name) : null;
            $variant->quantity = $variant->stock_quantity;
            return $variant;
        });
    return response()->json($variants);
}
}
