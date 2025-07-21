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


public function adminDetail($id)
{
    $post = Post::with(['author', 'product'])->findOrFail($id);

    // Tổng số reaction theo loại
    // $reactions = \App\Models\PostReaction::where('post_id', $id)
    //     ->select('reaction', \DB::raw(value: 'count(*) as total'))
    //     ->groupBy('reaction')
    //     ->get();
$reactionTypes = ['like', 'love', 'haha', 'wow', 'sad', 'angry', 'dislike'];

$reactionCounts = \App\Models\PostReaction::where('post_id', $id)
    ->select('reaction', \DB::raw('count(*) as total'))
    ->groupBy('reaction')
    ->pluck('total', 'reaction') // lấy dạng key-value
    ->toArray();

// Merge vào để đảm bảo có đủ các loại reaction, nếu không có thì mặc định là 0
$reactions = [];
foreach ($reactionTypes as $type) {
    $reactions[$type] = $reactionCounts[$type] ?? 0;
}

    // Tổng số comment
    $commentsCount = \App\Models\Comment::where('post_id', $id)->count();

    // Danh sách comment chi tiết
    $comments = \App\Models\Comment::with('user')->where('post_id', $id)->orderByDesc('created_at')->get();

    return view('Admin.post_detail', compact('post', 'reactions', 'commentsCount', 'comments'));
}

public function getAISuggestions(Request $request)
{
    $request->validate([
        'keyword' => 'required|string|min:3|max:255',
    ]);

    $keyword = $request->input('keyword');
    $apiKey = env('OPENROUTER_API_KEY');

    if (empty($apiKey)) {
        return response()->json(['success' => false, 'message' => 'API key chưa cấu hình'], 500);
    }

    $prompt = <<<EOT
Viết một bài viết với tiêu đề: "{$keyword}". Trả về JSON đúng định dạng sau:

{
  "excerpt": "Tóm tắt",
  "content": "Nội dung bài viết",
  "tags": "tag1, tag2, tag3",
  "meta_title": "Tiêu đề SEO",
  "meta_description": "Mô tả SEO"
}
Chỉ trả về JSON, không có bất kỳ văn bản nào khác.
EOT;

    try {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $apiKey,
            'HTTP-Referer' => 'http://localhost:8000',
            'X-Title' => 'Laravel Post AI',
        ])->post('https://openrouter.ai/api/v1/chat/completions', [
            'model' => 'mistral/mixtral-8x7b-instruct',
            'messages' => [
                ['role' => 'user', 'content' => $prompt],
            ],
        ]);

        $result = $response->json();
        $text = $result['choices'][0]['message']['content'] ?? null;

        // Sửa chỗ parse JSON bằng regex
        preg_match('/\{(?:[^{}]|(?R))*\}/', $text, $matches);
        $json = $matches[0] ?? null;

        if ($json === null) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy JSON trong phản hồi AI',
                'raw' => $text
            ], 422);
        }

        $parsed = json_decode($json, true);

        if (json_last_error() === JSON_ERROR_NONE) {
            return response()->json(['success' => true, 'suggestions' => [$parsed]]);
        }

        return response()->json(['success' => false, 'message' => 'Lỗi JSON khi decode', 'raw' => $text], 422);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Lỗi AI: ' . $e->getMessage()], 500);
    }
}


}
