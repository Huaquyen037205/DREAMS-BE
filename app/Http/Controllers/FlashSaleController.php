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
            'variant_id' => 'required|exists:variant,id',
            'sale_price' => 'required|numeric|min:0',
            'flash_quantity' => 'required|integer|min:1',
        ]);

        Flash_Sale_Variant::updateOrCreate(
            [
                'flash_sale_id' => $id,
                'variant_id' => $request->variant_id,
            ],
            [
                'sale_price' => $request->sale_price,
                'flash_quantity' => $request->flash_quantity,
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





public function apiProducts($id)
{
    $flashSale = Flash_Sale::findOrFail($id);

    // Lấy tất cả variant thuộc chương trình flash sale này
    $variants = DB::table('flash_sale_variants')
    ->join('variant', 'flash_sale_variants.variant_id', '=', 'variant.id')
    ->join('products', 'variant.product_id', '=', 'products.id')
    ->leftJoin('img', 'products.id', '=', 'img.product_id')
    ->where('flash_sale_variants.flash_sale_id', $id)
    ->select(
        'products.id as product_id',
        'products.name as product_name',
        'variant.id as variant_id',
        'variant.price as original_price',
        'flash_sale_variants.sale_price as flash_sale_price',
        'flash_sale_variants.flash_quantity',
        'flash_sale_variants.flash_sold',
        DB::raw('MIN(img.name) as image') // chỉ lấy 1 ảnh đại diện
    )
    ->groupBy(
        'products.id',
        'products.name',
        'variant.id',
        'variant.price',
        'flash_sale_variants.sale_price',
        'flash_sale_variants.flash_quantity',
        'flash_sale_variants.flash_sold'
    )
    ->get();

    return response()->json([
        'flash_sale_id' => $flashSale->id,
        'flash_sale_name' => $flashSale->name,
        'start_time' => $flashSale->start_time,
        'end_time' => $flashSale->end_time,
        'variants' => $variants
    ]);
}
}
