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

    // Gửi ảnh và sản phẩm sang AI service (Python Flask hoặc HuggingFace)
    $response = Http::attach(
        'photo', file_get_contents(storage_path('app/public/' . $photoPath)), $photo->getClientOriginalName()
    )->post('http://localhost:5000/tryon', [
        'product_image' => $product->img->first()->name, // hoặc đường dẫn ảnh sản phẩm
    ]);

    if ($response->successful()) {
        // Lưu ảnh kết quả vào CDN hoặc storage
        $resultUrl = $response->json()['result_url'];
        // Trả về FE
        return response()->json(['result_url' => $resultUrl]);
    } else {
        return response()->json(['message' => 'Xử lý AI thất bại'], 500);
    }
}
}
