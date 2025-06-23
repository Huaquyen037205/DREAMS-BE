<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class VirtualTryOnController extends Controller
{
    public function tryOn(Request $request)
{
    $request->validate([
        'image' => 'required|image',
        'cloth' => 'required|image',
    ]);

    $response = Http::attach(
        'image', fopen($request->file('image')->getRealPath(), 'r'), 'image.jpg'
    )->attach(
        'cloth', fopen($request->file('cloth')->getRealPath(), 'r'), 'cloth.jpg'
    )->post('http://localhost:5000/api/tryon');

    if (!$response->successful()) {
        $error = $response->json('error') ?? 'AI server lỗi';
        return response()->json(['error' => $error], 500);
    }

    $data = $response->json();

    if (!isset($data['result_url'])) {
        return response()->json(['error' => 'Không nhận được ảnh kết quả từ AI'], 500);
    }

    return response()->json([
        'result_url' => $data['result_url']
    ]);
}
    public function getResult($id)
    {
        $path = "output/{$id}.png";

        if (!Storage::disk('public')->exists($path)) {
            return response()->json(['error' => 'Không tìm thấy ảnh kết quả'], 404);
        }

        $url = asset("storage/{$path}");

        return response()->json([
            'result_url' => $url
        ]);
    }
}
