<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageSearchController extends Controller
{
    public function search(Request $request)
    {
        // Bước 1: Validate ảnh upload
        $request->validate([
            'image' => 'required|image|max:5120', // 5MB
        ]);

        // Bước 2: Lưu tạm ảnh vào storage/app/temp
        $path = $request->file('image')->store('temp', 'local');

        // Bước 3: Kiểm tra file có tồn tại không
        if (!Storage::disk('local')->exists($path)) {
            return response()->json([
                'error' => 'Ảnh không được lưu hoặc sai đường dẫn',
                'path' => $path
            ], 500);
        }

        // Bước 4: Gửi ảnh tới FastAPI
        $response = Http::attach(
            'image',
            Storage::disk('local')->get($path),
            basename($path)
        )->post('http://localhost:9000/search'); // đúng PORT FastAPI

        // Bước 5: Xóa ảnh tạm
        Storage::disk('local')->delete($path);

        // Bước 6: Trả kết quả về client
        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Lỗi xử lý AI'], 500);
    }
}
