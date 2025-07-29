<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class StylistAiController extends Controller
{
    public function analyzeStyle(Request $request)
    {
        $productName = $request->input('product_name');

    // Nếu không có product_name, thử lấy từ answers nếu có câu hỏi về sản phẩm
    if (!$productName) {
        $answers = $request->input('answers', []);
        if (is_array($answers)) {
            foreach ($answers as $ans) {
                if (preg_match('/sản phẩm\s+(.+)/iu', $ans, $m)) {
                    $productName = trim($m[1]);
                    break;
                }
            }
        }
    }

    if ($productName) {
        $product = Product::where('name', $productName)->first();
        if ($product) {
             $images = DB::table('img')
                ->where('product_id', $product->id)
                ->orderBy('id')
                ->pluck('name')
                ->map(function ($img) {
                    return asset('img/' . $img);
                });
            // Lấy tất cả biến thể
            $variants = $product->variant()->orderBy('price')->get()->map(function ($variant) {
                return [
                    'id' => $variant->id,
                    'size' => $variant->size,
                    'stock_quantity' => $variant->stock_quantity,
                    'price' => $variant->price,
                    'sale_price' => $variant->sale_price,
                    'status' => $variant->status,
                ];
            });
            return response()->json([
                'product' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'description' => $product->description,
                    'images' => $images,
                    'variants' => $variants,
                ]
            ]);
        } else {
            return response()->json(['message' => 'Không tìm thấy sản phẩm!'], 404);
        }
    }
        $answers = $request->input('answers');
        $mixAndMatch = $request->input('mix_and_match', false);

        // Kiểm tra nếu khách chỉ hỏi về giảm giá hoặc flash sale thì chỉ trả lời, không sinh từ khóa và không đề xuất sản phẩm
        $isDiscountQuestion = false;
        if (is_array($answers)) {
            foreach ($answers as $ans) {
                if (preg_match('/(giảm giá|flash sale|ưu đãi)/iu', $ans)) {
                    $isDiscountQuestion = true;
                    break;
                }
            }
        }

        $discounts = DB::table('discounts')
            ->where('start_day', '<=', now())
            ->where('end_day', '>=', now())
            ->whereNull('deleted_at')
            ->get(['name', 'percentage', 'start_day', 'end_day']);

        $flashSales = DB::table('flash_sales')
            ->where('start_time', '<=', now())
            ->where('end_time', '>=', now())
            ->where('status', 1)
            ->get(['name', 'start_time', 'end_time']);

        $discountInfo = $discounts->isNotEmpty()
            ? $discounts->map(function($d) {
                return "Chương trình: {$d->name}, giảm {$d->percentage}%, từ {$d->start_day} đến {$d->end_day}";
            })->implode("\n")
            : "Hiện tại chưa có chương trình giảm giá nào đang diễn ra.";

        $flashSaleInfo = $flashSales->isNotEmpty()
            ? $flashSales->map(function($f) {
                return "Flash Sale: {$f->name}, từ {$f->start_time} đến {$f->end_time}";
            })->implode("\n")
            : "Hiện tại chưa có chương trình flash sale nào đang diễn ra.";

        if ($isDiscountQuestion) {
            $prompt = "Khách hàng hỏi về chương trình giảm giá hoặc flash sale.
                Dữ liệu chương trình giảm giá hiện tại: $discountInfo
                Dữ liệu flash sale hiện tại: $flashSaleInfo
                Hãy trả lời thân thiện, tự nhiên như một stylist đang trò chuyện với khách (tiếng Việt).
                Trả về JSON có 1 trường: message (chỉ trả lời về chương trình, không đề xuất sản phẩm, không sinh từ khóa).
                Chỉ trả JSON, không thêm giải thích, không bọc ```json```.";

                 $apiKey = env('GEMINI_API_KEY');
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey, [
                'contents' => [[ 'parts' => [['text' => $prompt]] ]]
            ]);

            $text = $response->json('candidates.0.content.parts.0.text');
            if (preg_match('/```json(.*?)```/s', $text, $matches)) {
                $json = trim($matches[1]);
            } elseif (preg_match('/```(.*?)```/s', $text, $matches)) {
                $json = trim($matches[1]);
            } else {
                $json = trim($text);
            }
            $result = json_decode($json, true);

            return response()->json([
                'message' => $result['message'] ?? '',
            ]);
        } else {
            $prompt = "Dưới đây là thông tin gu thời trang của một người dùng: " . json_encode($answers, JSON_UNESCAPED_UNICODE) . "
                Dựa vào đó, hãy:
                - Đặt tên gu thật sang chảnh (tiếng Việt)
                - Mô tả ngắn phong cách này
                - Gợi ý tối đa 3 từ khóa style (tiếng Việt hoặc tiếng Anh, định dạng mảng)
                - Viết một lời nhận xét thân thiện, tự nhiên như một stylist đang trò chuyện với khách (tiếng Việt)
                - Nếu khách hàng hỏi về chương trình giảm giá, flash sale hoặc ưu đãi, hãy trả lời chi tiết về các chương trình này nếu có (lưu ý không tự bịa ra).
                Dữ liệu chương trình giảm giá hiện tại: $discountInfo
                Dữ liệu flash sale hiện tại: $flashSaleInfo
                Trả về JSON có 4 trường: name, desc, keywords, message.
                Chỉ trả JSON, không thêm giải thích, không bọc ```json```.";

            if ($mixAndMatch) {
                $prompt .= "
                - Gợi ý một set phối đồ hoàn chỉnh (chỉ gồm các sản phẩm có trong cửa hàng, mỗi loại sản phẩm chỉ xuất hiện 1 lần, ví dụ: nếu đã có áo khoác thì không thêm áo khoác thứ 2, phối hợp phụ kiện như túi, mũ nếu phù hợp. Đảm bảo set đồ hợp lý, đủ các món cơ bản cho 1 outfit)";
            }
            $prompt .= "
                Trả về JSON có 5 trường: name, desc, keywords, message" . ($mixAndMatch ? ", mix_and_match" : "") . ".
                Chỉ trả JSON, không thêm giải thích, không bọc ```json```.";
        }

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

            $productsWithImage = $products->map(function ($product) {
            $image = DB::table('img')->where('product_id', $product->id)->orderBy('id')->value('name');
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => optional($product->variant()->orderBy('price')->first())->price,
                'image' => $image ? url('uploads/' . $image) : null,
            ];
        });

        return response()->json([
            'message' => $result['message'] ?? '',
            'style_name' => $result['name'] ?? 'Gu thời trang của bạn',
            'description' => $result['desc'] ?? '',
            'keywords' => $rawKeywords,
            'products' => $productsWithImage,

        ]);
    }
}
