<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class virtualTryOn extends Controller
{
   public function virtualTryOn(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|max:5120',
            'product_id' => 'required|exists:products,id',
        ]);
        // Lưu ảnh gốc
        $photo = $request->file('photo');
        $photoPath = $photo->store('tryon/original', 'public');
        // Lấy thông tin sản phẩm (ví dụ: ảnh quần áo)
        $product = Product::find($request->product_id);
        $productImagePath = $product->img->first()->name ?? null;
        if (!$productImagePath) {
            return response()->json(['message' => 'Không tìm thấy ảnh sản phẩm'], 404);
        }
        // Gửi ảnh và sản phẩm sang AI service (FastAPI)
        $response = Http::attach(
            'photo', file_get_contents(storage_path('app/public/' . $photoPath)), $photo->getClientOriginalName()
        )->attach(
            'product_image', file_get_contents(storage_path('app/public/' . $productImagePath)), basename($productImagePath)
        )->post('http://localhost:5000/tryon');

        if ($response->successful()) {
            // Lưu ảnh kết quả vào storage
            $resultPath = 'tryon/result/' . uniqid() . '.jpg';
            Storage::disk('public')->put($resultPath, $response->body());
            $resultUrl = Storage::url($resultPath);

            // Trả về FE
            return response()->json(['result_url' => $resultUrl]);
        } else {
            return response()->json(['message' => 'Xử lý AI thất bại'], 500);
        }
    }
}
