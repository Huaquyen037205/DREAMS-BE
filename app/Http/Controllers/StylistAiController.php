<?php

namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StylistAiController extends Controller
{
    public function analyzeStyle(Request $request)
    {
        $answers = $request->input('answers');
        $prompt = "Dựa trên các câu trả lời sau, hãy phân tích gu thời trang, đặt tên gu thật sang chảnh (tiếng Việt), mô tả ngắn và gợi ý 3 từ khóa style: " . json_encode($answers);

        $geminiResponse = $this->callGeminiApi($prompt);

        // Giả sử Gemini trả về: ['name' => 'Soft Boy Winter', 'desc' => '...', 'keywords' => ['soft boy', 'winter', 'layer']]
        $styleName = $geminiResponse['name'] ?? 'Gu thời trang của bạn';
        $keywords = $geminiResponse['keywords'] ?? [];
        $desc = $geminiResponse['desc'] ?? '';

        $products = Product::where(function($q) use ($keywords) {
            foreach ($keywords as $kw) {
                $q->orWhere('style_tags', 'like', "%$kw%");
            }
        })->take(12)->get();

        return response()->json([
            'style_name' => $styleName,
            'description' => $desc,
            'products' => $products,
        ]);
    }

    private function callGeminiApi($prompt)
    {
        $apiKey = env('GEMINI_API_KEY');
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key' . $apiKey, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        // Parse response (giả sử Gemini trả về JSON chuẩn)
        $content = $response->json('candidates.0.content.parts.0.text');
        $result = json_decode($content, true);

        // Nếu không phải JSON, fallback: tách chuỗi thủ công nếu cần
        if (!$result) {
            $result = [
                'name' => null,
                'desc' => $content,
                'keywords' => [],
            ];
        }

        return $result;
    }
}
