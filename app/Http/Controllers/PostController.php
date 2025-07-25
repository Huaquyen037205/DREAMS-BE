<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    /**
     * Hiển thị form tạo bài viết mới.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('Admin.post_list');
    }

    /**
     * Lấy danh sách tất cả bài viết đã công khai (public API).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $posts = Post::with(['product.variant', 'product.img', 'author'])
                     ->where('status', 'published')
                     ->orderByDesc('created_at')
                     ->get();
        return response()->json($posts);
    }

    /**
     * Hiển thị chi tiết một bài viết cụ thể (public API).
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $post = Post::with(['product.variants', 'product.img', 'author'])
                    ->where('id', $id)
                    ->where('status', 'published')
                    ->firstOrFail();
        return response()->json($post);
    }

    /**
     * Lưu bài viết mới vào cơ sở dữ liệu.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:product,event',
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['author_id'] = auth()->id() ?? null;

        // Xử lý tải lên hình ảnh chính
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } else {
            $validated['image'] = $request->input('image') === null ? null : ($validated['image'] ?? null);
        }

        // Xử lý tải lên hình ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        } else {
            $validated['thumbnail'] = $request->input('thumbnail') === null ? null : ($validated['thumbnail'] ?? null);
        }

        $post = Post::create($validated);

        return redirect()->route('admin.posts.manage')->with('success', 'Bài viết đã được tạo thành công!');
    }

    /**
     * Hiển thị form chỉnh sửa bài viết.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('Admin.post_edit', compact('post'));
    }

    /**
     * Cập nhật thông tin bài viết.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'type' => 'required|in:product,event',
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:posts,slug,' . $id,
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tags' => 'nullable|string|max:255',
            'status' => 'nullable|in:draft,published',
            'is_featured' => 'nullable|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $validated['author_id'] = auth()->id() ?? $post->author_id;

        // Xử lý cập nhật hình ảnh chính
        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } elseif ($request->input('image') === null) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = null;
        } else {
            unset($validated['image']);
        }

        // Xử lý cập nhật hình ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        } elseif ($request->input('thumbnail') === null) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = null;
        } else {
            unset($validated['thumbnail']);
        }

        $post->update($validated);

        return redirect()->route('admin.posts.manage')->with('success', 'Bài viết đã được cập nhật thành công!');
    }

    /**
     * Xóa bài viết khỏi cơ sở dữ liệu.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $post = Post::findOrFail($id);

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }
        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();
        return response()->json(['message' => 'Đã xóa bài viết']);
    }

    /**
     * Hiển thị trang quản lý tất cả bài viết (dành cho Admin).
     *
     * @return \Illuminate\View\View
     */
    public function managePosts()
    {
        $posts = Post::with(['product.variant', 'product.img', 'author'])->orderByDesc('created_at')->get();
        return view('Admin.post_manage', compact('posts'));
    }

    /**
     * Cập nhật trạng thái (ẩn/hiện) của một bài viết.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function toggleStatus(Request $request, $id)
    {
        $post = Post::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:draft,published',
        ]);

        $post->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Trạng thái bài viết đã được cập nhật.', 'new_status' => $post->status]);
    }

    public function adminDetail($id)
    {
        $post = Post::with(['author', 'product'])->findOrFail($id);

        $reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry', 'dislike'];

        $reactionCounts = \App\Models\PostReaction::where('post_id', $id)
            ->select('reaction', \DB::raw('count(*) as total'))
            ->groupBy('reaction')
            ->pluck('total', 'reaction')
            ->toArray();

        $reactions = [];
        foreach ($reactionTypes as $type) {
            $reactions[$type] = $reactionCounts[$type] ?? 0;
        }

        $commentsCount = \App\Models\Comment::where('post_id', $id)->count();
        $comments = \App\Models\Comment::with('user')->where('post_id', $id)->orderByDesc('created_at')->get();

        return view('Admin.post_detail', compact('post', 'reactions', 'commentsCount', 'comments'));
    }

    /**
     * Tải ảnh từ URL và lưu vào storage
     *
     * @param  string  $imageUrl
     * @param  string  $folder
     * @return string|null
     */
    private function downloadAndSaveImage($imageUrl, $folder = 'posts/ai-generated')
    {
        try {
            // Tải ảnh từ URL
            $response = Http::timeout(30)->get($imageUrl);

            if (!$response->successful()) {
                return null;
            }

            // Tạo tên file unique
            $extension = 'jpg'; // Mặc định là jpg
            $filename = uniqid() . '_' . time() . '.' . $extension;
            $path = $folder . '/' . $filename;

            // Lưu ảnh vào storage
            Storage::disk('public')->put($path, $response->body());

            return $path;
        } catch (\Exception $e) {
            Log::error('Error downloading image', [
                'url' => $imageUrl,
                'error' => $e->getMessage()
            ]);
            return null;
        }
    }

    /**
     * Lấy gợi ý AI cho bài viết từ Google AI (Gemini) bao gồm cả ảnh
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAISuggestions(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|min:3|max:255',
            ]);

            $title = $validated['title'];
            $apiKey = env('POST_KEY');

            if (empty($apiKey)) {
                return response()->json([
                    'success' => false,
                    'message' => 'API key chưa được cấu hình'
                ], 500);
            }

            // Tạo prompt cho Google AI
            $prompt = "Dựa vào tiêu đề '{$title}', hãy tạo nội dung cho một bài viết blog. Trả về JSON với định dạng sau:

{
  \"content\": \"Nội dung bài viết chi tiết, ít nhất 3 đoạn văn\",
  \"tags\": \"tag1, tag2, tag3, tag4, tag5\",
  \"meta_title\": \"Tiêu đề SEO tối ưu\",
  \"meta_description\": \"Mô tả SEO ngắn gọn và hấp dẫn\",
  \"image_prompt\": \"Mô tả chi tiết cho ảnh minh họa bài viết bằng tiếng Anh\"
}

Viết bằng tiếng Việt, nội dung chuyên nghiệp và hữu ích. image_prompt phải bằng tiếng Anh và mô tả cụ thể. Chỉ trả về JSON, không có văn bản khác.";

            // Gọi Google AI API (Gemini)
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-pro:generateContent?key={$apiKey}", [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $prompt
                            ]
                        ]
                    ]
                ]
            ]);

            if (!$response->successful()) {
                Log::error('Google AI API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Lỗi khi gọi API Google AI'
                ], 500);
            }

            $result = $response->json();

            if (!isset($result['candidates'][0]['content']['parts'][0]['text'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Phản hồi API không hợp lệ'
                ], 422);
            }

            $generatedText = $result['candidates'][0]['content']['parts'][0]['text'];
            $suggestions = null;

            // Tìm và parse JSON từ response
            if (preg_match('/\{(?:[^{}]|(?R))*\}/', $generatedText, $matches)) {
                $jsonString = $matches[0];
                $suggestions = json_decode($jsonString, true);
            }

            // Nếu không parse được JSON hoặc thiếu nội dung, tạo fallback
            if (json_last_error() !== JSON_ERROR_NONE || !isset($suggestions['content'])) {
                $suggestions = [
                    'content' => "Đây là nội dung chi tiết về \"{$title}\". Bài viết này sẽ cung cấp thông tin hữu ích và chuyên sâu về chủ đề này.\n\nNội dung được viết một cách dễ hiểu và thu hút người đọc, bao gồm các thông tin cần thiết và quan trọng.\n\nKết luận: \"{$title}\" là một chủ đề đáng quan tâm và có nhiều giá trị thực tiễn.",
                    'tags' => str_replace(' ', ', ', strtolower($title)) . ', thông tin, hữu ích, chuyên sâu',
                    'meta_title' => $title . ' - Thông tin chi tiết và hữu ích',
                    'meta_description' => "Tìm hiểu chi tiết về {$title}. Bài viết cung cấp thông tin đầy đủ, chính xác và hữu ích cho người đọc.",
                    'image_prompt' => "High quality professional image related to " . $title . ", modern style, clean background"
                ];
            }

            // Tạo ảnh từ Unsplash API (miễn phí) hoặc service khác
            $imageUrls = $this->generateImages($suggestions['image_prompt'] ?? $title);

            return response()->json([
                'success' => true,
                'suggestions' => $suggestions,
                'images' => $imageUrls
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('AI Suggestions Error', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Đã xảy ra lỗi không mong muốn: ' . $e->getMessage()
            ], 500);
        }
    }
}
