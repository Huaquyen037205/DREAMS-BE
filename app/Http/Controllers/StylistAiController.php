<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class StylistAiController extends Controller
{
    public function analyzeStyle(Request $request)
    {
        $answers = $request->input('answers');

        $prompt = "Dưới đây là thông tin gu thời trang của một người dùng: " . json_encode($answers, JSON_UNESCAPED_UNICODE) . "
            Dựa vào đó, hãy:
            - Đặt tên gu thật sang chảnh (tiếng Việt)
            - Mô tả ngắn phong cách này
            - Gợi ý tối đa 3 từ khóa style (tiếng Việt hoặc tiếng Anh, định dạng mảng)

            Trả về JSON có 3 trường: name, desc, keywords.
            Chỉ trả JSON, không thêm giải thích, không bọc ```json```.";

        $apiKey = env('GEMINI_API_KEY');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey, [
            'contents' => [[ 'parts' => [['text' => $prompt]] ]]
        ]);

        Log::info('Gemini API raw response:', $response->json());

        $text = $response->json('candidates.0.content.parts.0.text');
        Log::info('Gemini API raw text:', ['text' => $text]);

        // Tách JSON ra nếu Gemini vẫn bọc ```json
        if (preg_match('/```json(.*?)```/s', $text, $matches)) {
            $json = trim($matches[1]);
            Log::info('Matched ```json block```:', ['json' => $json]);
        } elseif (preg_match('/```(.*?)```/s', $text, $matches)) {
            $json = trim($matches[1]);
            Log::info('Matched ``` block```:', ['json' => $json]);
        } else {
            $json = trim($text);
            Log::info('No wrapping, using raw:', ['json' => $json]);
        }

        $result = json_decode($json, true);

        if (!is_array($result)) {
            Log::warning('JSON decode failed.', ['json' => $json]);
            $result = [
                'name' => null,
                'desc' => $text,
                'keywords' => [],
            ];
        }

        // --- Giai đoạn tách từ ---
        $rawKeywords = $result['keywords'] ?? [];
        $finalKeywords = [];

        foreach ($rawKeywords as $kw) {
            $words = preg_split('/\s+/', $kw);
            foreach ($words as $word) {
                $word = trim($word);
                if (mb_strlen($word) >= 2) {
                    $finalKeywords[] = $word;
                }
            }
        }

        $finalKeywords = array_unique($finalKeywords);

        // Log::info('Expanded keywords for search:', $finalKeywords);
        $products = Product::query()
            ->where(function ($q) use ($finalKeywords) {
                foreach ($finalKeywords as $word) {
                    $q->orWhere('name', 'like', '%' . $word . '%')
                      ->orWhere('description', 'like', '%' . $word . '%');
                }
            })
            ->take(12)
            ->get();

        Log::info('Products found:', $products->pluck('name')->toArray());

        return response()->json([
            'style_name' => $result['name'] ?? 'Gu thời trang của bạn',
            'description' => $result['desc'] ?? '',
            'keywords' => $rawKeywords,
            'products' => $products,
        ]);
    }
}
