<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\User; // Đảm bảo import model User nếu bạn sử dụng quan hệ author
use Illuminate\Support\Facades\Http;
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
        // Chỉ lấy các bài viết có trạng thái là 'published' cho API công khai
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
        // Chỉ hiển thị bài viết đã công khai
        $post = Post::with(['product.variants', 'product.img', 'author'])
                    ->where('id', $id)
                    ->where('status', 'published')
                    ->firstOrFail(); // Sử dụng firstOrFail để áp dụng điều kiện where
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

        // Lấy ID của người dùng hiện tại, hoặc null nếu không có
        $validated['author_id'] = auth()->id() ?? null;

        // Xử lý tải lên hình ảnh chính
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public'); // Lưu vào thư mục 'posts' trên đĩa 'public'
        } else {
            // Nếu không có file được tải lên, và trường 'image' không được gửi hoặc gửi là null, đảm bảo nó là null
            $validated['image'] = $request->input('image') === null ? null : ($validated['image'] ?? null);
        }

        // Xử lý tải lên hình ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public'); // Lưu vào thư mục 'posts/thumbnails'
        } else {
            // Tương tự cho thumbnail
            $validated['thumbnail'] = $request->input('thumbnail') === null ? null : ($validated['thumbnail'] ?? null);
        }

        $post = Post::create($validated);

        // Chuyển hướng về trang quản lý bài viết sau khi tạo thành công
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

        // Giữ nguyên author_id nếu không có người dùng đăng nhập, hoặc cập nhật nếu có
        $validated['author_id'] = auth()->id() ?? $post->author_id;

        // Xử lý cập nhật hình ảnh chính
        if ($request->hasFile('image')) {
            // Xóa hình ảnh cũ nếu tồn tại
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        } elseif ($request->input('image') === null) {
            // Nếu trường 'image' được gửi rõ ràng là null, xóa hình ảnh cũ và đặt là null
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = null;
        } else {
            // Nếu trường 'image' không được gửi trong request, giữ nguyên giá trị hiện có
            unset($validated['image']);
        }

        // Xử lý cập nhật hình ảnh thumbnail
        if ($request->hasFile('thumbnail')) {
            // Xóa thumbnail cũ nếu tồn tại
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('posts/thumbnails', 'public');
        } elseif ($request->input('thumbnail') === null) {
            // Nếu trường 'thumbnail' được gửi rõ ràng là null, xóa thumbnail cũ và đặt là null
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $validated['thumbnail'] = null;
        } else {
            // Nếu trường 'thumbnail' không được gửi trong request, giữ nguyên giá trị hiện có
            unset($validated['thumbnail']);
        }

        $post->update($validated);

        // Chuyển hướng về trang quản lý bài viết sau khi cập nhật thành công
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

        // Xóa hình ảnh liên quan khi xóa bài viết
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
        // Lấy tất cả bài viết cùng với thông tin sản phẩm và tác giả (không lọc trạng thái để quản lý)
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
            'status' => 'required|in:draft,published', // Chỉ chấp nhận 'draft' hoặc 'published'
        ]);

        $post->update(['status' => $validated['status']]);

        return response()->json(['message' => 'Trạng thái bài viết đã được cập nhật.', 'new_status' => $post->status]);
    }

  public function getAISuggestions(Request $request)
{
    $request->validate([
        'keyword' => 'required|string|min:3|max:255',
    ]);

    $keyword = $request->input('keyword');
    $openaiApiKey = env('OPENAI_API_KEY');

    if (empty($openaiApiKey)) {
        return response()->json([
            'success' => false,
            'message' => 'OPENAI_API_KEY chưa được cấu hình.'
        ], 500);
    }

    // Prompt rõ ràng: Yêu cầu trả đúng JSON, không text thừa
    $prompt = <<<EOT
Viết một bài viết với tiêu đề: "{$keyword}".
Chỉ trả về **JSON THUẦN TÚY** theo đúng format sau, không thêm bất kỳ văn bản nào khác:

{
  "excerpt": "Tóm tắt bài viết",
  "content": "Nội dung chi tiết",
  "tags": "tag1, tag2, tag3",
  "meta_title": "Tiêu đề SEO",
  "meta_description": "Mô tả SEO"
}
EOT;

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $openaiApiKey,
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                ['role' => 'system', 'content' => 'Bạn là một chuyên gia SEO & viết bài content. Luôn trả về JSON thuần túy, không bao giờ thêm văn bản thừa.'],
                ['role' => 'user', 'content' => $prompt],
            ],
            'temperature' => 0.7,
        ]);

        $result = $response->json();
        $text = $result['choices'][0]['message']['content'] ?? null;

        // Gỡ bỏ những ký tự markdown không mong muốn nếu có
        $start = strpos($text, '{');
        $end = strrpos($text, '}');

        if ($start !== false && $end !== false) {
            $jsonString = substr($text, $start, $end - $start + 1);
            $parsed = json_decode($jsonString, true);

            if (json_last_error() === JSON_ERROR_NONE) {
                return response()->json([
                    'success' => true,
                    'suggestions' => [$parsed],
                ]);
            }
        }

        // Nếu lỗi thì log lại raw response để debug
        \Log::warning('GPT trả kết quả không đúng JSON:', ['text' => $text]);

        return response()->json([
            'success' => false,
            'message' => 'Không thể phân tích kết quả từ AI. Vui lòng thử lại.',
            'raw' => $text,
        ], 422);
    } catch (\Exception $e) {
        \Log::error('Lỗi khi gọi OpenAI: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Lỗi kết nối AI: ' . $e->getMessage(),
        ], 500);
    }
}


}
