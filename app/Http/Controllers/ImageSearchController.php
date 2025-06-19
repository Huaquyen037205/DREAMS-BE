<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageSearchController extends Controller
{
public function search(Request $request)
{
    $request->validate(['image' => 'required|image|max:5120']);

    $path = $request->file('image')->store('temp', 'local');

    if (!Storage::disk('local')->exists($path)) {
        return response()->json([
            'error' => 'Ảnh không được lưu hoặc sai đường dẫn',
            'path' => $path
        ], 500);
    }

    $response = Http::attach('image', Storage::disk('local')->get($path), basename($path))
        ->post('http://localhost:9000/search');

    Storage::disk('local')->delete($path);

    if ($response->successful()) {
        return response()->json($response->json());
    }

    return response()->json(['error' => 'Lỗi xử lý AI'], 500);
}




}
