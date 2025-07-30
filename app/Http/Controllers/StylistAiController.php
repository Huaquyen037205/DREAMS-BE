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
        $sizeAsked = null;
        $answers = $request->input('answers', []);
        if (!is_array($answers)) $answers = [$answers];

        if (!$productName) {
            foreach ($answers as $ans) {
                if (preg_match('/sản phẩm\s+(.+)/iu', $ans, $m)) {
                    $productName = trim($m[1]);
                    $productName = preg_replace('/(còn\s+size\s+\w+\s*không.*)/iu', '', $productName);
                    $productName = preg_replace('/(size\s+\w+)/iu', '', $productName);
                    $productName = trim($productName);
                    break;
                }
            }

            if (!$productName && !empty($answers[0]) && !preg_match('/(phối|set đồ|đi chơi|du lịch|outfit|mix and match|giảm giá|flash sale|ưu đãi)/iu', $answers[0])) {
                $productName = trim($answers[0]);
                $productName = preg_replace('/(còn\s+size\s+\w+\s*không.*)/iu', '', $productName);
                $productName = preg_replace('/(size\s+\w+)/iu', '', $productName);
                $productName = trim($productName);
            }

            if (!$sizeAsked) {
                foreach ($answers as $ans) {
                   if (preg_match('/sản phẩm\s+(.+)/iu', $ans, $m)) {
                        $productName = trim($m[1]);
                        $productName = preg_replace('/(còn\s+size\s+\w+\s*không.*)/iu', '', $productName);
                        $productName = preg_replace('/(size\s+\w+)/iu', '', $productName);
                        $productName = trim($productName);
                        break;
                    }
                }
            }
        }

        foreach ($answers as $ans) {
            if (preg_match('/size\s+(\w+)/iu', $ans, $match)) {
                $sizeAsked = strtoupper(trim($match[1]));
                break;
            } elseif (preg_match('/cỡ\s+(\w+)/iu', $ans, $match)) {
                $sizeAsked = strtoupper(trim($match[1]));
                break;
            }
        }

        if ($productName) {
                // Log::info("Product name guessed: " . $productName);
            $product = Product::whereRaw('LOWER(name) = ?', [mb_strtolower(trim($productName))])->first();
            if ($product) {
                $images = DB::table('img')
                    ->where('product_id', $product->id)
                    ->orderBy('id')
                    ->pluck('name')
                    ->map(fn($img) => asset('img/' . $img));
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

                if ($sizeAsked) {
                    $variant = $product->variant()->where('size', $sizeAsked)->first();
                    if ($variant) {
                        return response()->json([
                            'message' => "Sản phẩm {$product->name} size {$sizeAsked} còn {$variant->stock_quantity} sản phẩm trong kho nha khách iu ơiiiiii. Khách yêu tranh thủ lựa chọn ngay nha.",
                            'stock_quantity' => $variant->stock_quantity,
                            'size' => $sizeAsked,
                            'status' => $variant->status,
                        ]);
                    } else {
                        return response()->json([
                            'message' => "Sản phẩm {$product->name} hiện tại không có size {$sizeAsked}.",
                            'stock_quantity' => 0,
                            'size' => $sizeAsked,
                            'status' => 'not_found',
                        ]);
                    }
                }

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

        //  giảm giá/flash sale
        $isDiscountQuestion = false;
        foreach ($answers as $ans) {
            if (preg_match('/(giảm giá|flash sale|ưu đãi)/iu', $ans)) {
                $isDiscountQuestion = true;
                break;
            }
        }
        if ($isDiscountQuestion) {
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
        }

        // phối đồ (mix and match)
        $mixAndMatch = false;
            foreach ($answers as $ans) {
                if (preg_match('/(phối đồ|set đồ|đi chơi|du lịch|outfit|mix and match)/iu', $ans)) {
                    $mixAndMatch = true;
                    break;
                }
            }

            // AI phối đồ hoặc style
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
                - Gợi ý một set phối đồ hoàn chỉnh (chỉ gồm các sản phẩm có trong cửa hàng, mỗi loại sản phẩm chỉ xuất hiện 1 lần, phối hợp phụ kiện như túi, mũ nếu phù hợp. Đảm bảo set đồ hợp lý, đủ các món cơ bản cho 1 outfit)";
            }else {
            $shopProducts = Product::with('category')->get()->map(function($p) {
                return [
                    'name' => $p->name,
                    'category' => optional($p->category)->name,
                    'description' => $p->description,
                ];
            });

            $prompt = "Danh sách sản phẩm hiện có trong shop, đề suất phối đồ cho người dùng (chỉ được đề xuất các sản phẩm này): " . json_encode($shopProducts, JSON_UNESCAPED_UNICODE) . "\n";
            $prompt .= "Dưới đây là thông tin gu thời trang của một người dùng: " . json_encode($answers, JSON_UNESCAPED_UNICODE) . "\n";
            $prompt .= "Dựa vào đó, hãy:
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
                - Gợi ý một set phối đồ hoàn chỉnh (chỉ gồm các sản phẩm có trong cửa hàng, mỗi loại sản phẩm chỉ xuất hiện 1 lần, phối hợp phụ kiện như túi, mũ nếu phù hợp. Đảm bảo set đồ hợp lý, đủ các món cơ bản cho 1 outfit)
                - Trả về JSON có 5 trường: name, desc, keywords, message, mix_and_match (mix_and_match là mảng các tên sản phẩm đề xuất).";
            } else {
                $prompt .= "
                - Trả về JSON có 4 trường: name, desc, keywords, message.";
            }

            $prompt .= "
            Chỉ trả JSON, không thêm giải thích, không bọc ```json```.";
        }

        $apiKey = env('GEMINI_API_KEY');

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey, [
            'contents' => [[ 'parts' => [['text' => $prompt]] ]]
        ]);

        $text = $response->json('candidates.0.content.parts.0.text');
        Log::info("Gemini raw response: " . $text);

        if (preg_match('/```json(.*?)```/s', $text, $matches)) {
            $json = trim($matches[1]);
        } elseif (preg_match('/```(.*?)```/s', $text, $matches)) {
            $json = trim($matches[1]);
        } else {
            $json = trim($text);
        }
        $result = json_decode($json, true);

        if (!is_array($result)) {
            $result = [
                'name' => null,
                'desc' => $text,
                'keywords' => [],
            ];
        }

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

        $products = Product::query()
            ->where(function ($q) use ($finalKeywords) {
                foreach ($finalKeywords as $word) {
                    $q->orWhere('name', 'like', '%' . $word . '%')
                      ->orWhere('description', 'like', '%' . $word . '%');
                }
            })
            ->take(12)
            ->get();

        $productsWithImage = $products->map(function ($product) {
            $image = DB::table('img')->where('product_id', $product->id)->orderBy('id')->value('name');
            return [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => optional($product->variant()->orderBy('price')->first())->price,
                'image' => $image ? url('img/' . $image) : null,
            ];
        });

        $message = $result['message'] ?? '';
        $message = preg_replace('/\*+\s*/u', '', $message);

        return response()->json([
            'message' => $message,
            'style_name' => $result['name'] ?? 'Gu thời trang của bạn',
            'description' => $result['desc'] ?? '',
            'keywords' => $rawKeywords,
            'products' => $productsWithImage,
            'mix_and_match' => $result['mix_and_match'] ?? null,
        ]);
    }
}
