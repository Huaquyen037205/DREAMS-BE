<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Product;

class AIChatController extends Controller
{
    public function chat(Request $request)
    {
        $apiKey = config('services.gemini.api_key');
        $message = $request->input('message');

        // Danh sách từ khóa liên quan đến outfit
        $keywords = ['outfit', 'mặc gì', 'phối đồ', 'trang phục', 'quần áo', 'áo', 'quần', 'giày', 'thời trang', 'stylist','đồ'];

        // Kiểm tra xem message có chứa từ khóa outfit không
        $needProduct = false;
        foreach ($keywords as $keyword) {
            if (stripos($message, $keyword) !== false) {
                $needProduct = true;
                break;
            }
        }

        $prompt = '';
        $products = [];

        if ($needProduct) {
            // Lấy sản phẩm liên quan
            $products = Product::with('img')
                ->where('name', 'like', '%' . $message . '%')
                ->orWhere('description', 'like', '%' . $message . '%')
                ->limit(5)
                ->get();

            if ($products->isEmpty()) {
                $products = Product::with('img')->latest()->limit(5)->get();
            }

            $productDescriptions = $products->map(function ($product) {
                $img = $product->img->first();
                $imgUrl = $img && $img->name
                    ? asset('img/' . $img->name)
                    : 'Không có ảnh';

                return "- {$product->name}: {$product->description} (Ảnh: {$imgUrl})";
            })->implode("\n");

            $prompt = "Bạn là stylist ảo. Hãy gợi ý outfit phù hợp với yêu cầu: \"$message\".\n"
                    . "Dưới đây là một số sản phẩm trong kho:\n{$productDescriptions}";
        } else {
            // Nếu không liên quan đến thời trang, gửi nguyên message
            $prompt = $message;
        }

        // Gửi đến Gemini
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}", [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if (!$response->successful()) {
            return response()->json([
                'error' => 'Lỗi từ Gemini',
                'details' => $response->json()
            ], 500);
        }

        $data = $response->json();
        $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Không có phản hồi từ Gemini.';

        return response()->json([
            'reply' => $reply,
            'products' => $needProduct ? $products : []
        ]);
    }
}
