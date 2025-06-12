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
        $path = $request->file('image')->store('temp');
        $fullPath = storage_path('app/' . $path);

        $response = Http::attach('image', file_get_contents($fullPath), basename($fullPath))
            ->post('http://localhost:8000/search');

        Storage::delete($path);

        if ($response->successful()) {
            return response()->json($response->json());
        }

        return response()->json(['error' => 'Lỗi xử lý AI'], 500);
    }

}
