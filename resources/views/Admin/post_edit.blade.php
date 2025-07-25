@extends('template.admin')

@section('content')
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Chỉnh sửa bài viết: {{ $post->title }}</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        {{-- Form bên trái --}}

    <form id="post-form" action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT') {{-- Quan trọng: Sử dụng phương thức PUT cho cập nhật --}}

        {{-- Title --}}
        <div class="mb-4">
            <label class="block mb-1">Tiêu đề</label>
            <input type="text" name="title" class="border rounded w-full p-2" value="{{ old('title', $post->title) }}" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Slug --}}
        <div class="mb-4">
            <label class="block mb-1">Slug (tự sinh nếu bỏ trống)</label>
            <input type="text" name="slug" class="border rounded w-full p-2" value="{{ old('slug', $post->slug) }}">
            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Type --}}
        <div class="mb-4">
            <label class="block mb-1">Loại</label>
            <select name="type" class="border rounded w-full p-2" required>
                <option value="product" {{ old('type', $post->type) == 'product' ? 'selected' : '' }}>Sản phẩm</option>
                <option value="event" {{ old('type', $post->type) == 'event' ? 'selected' : '' }}>Sự kiện</option>
            </select>
            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Product ID --}}
        <div class="mb-4">
            <label class="block mb-1">Sản phẩm liên kết (ID)</label>
            <input type="number" name="product_id" class="border rounded w-full p-2" value="{{ old('product_id', $post->product_id) }}">
            @error('product_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Trạng thái --}}
        <div class="mb-4">
            <label class="block mb-1">Trạng thái</label>
            <select name="status" class="border rounded w-full p-2">
                <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Nháp</option>
                <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Công khai</option>
            </select>
            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Is featured --}}
        <div class="mb-4">
            <label class="block mb-1">Nổi bật?</label>
            <select name="is_featured" class="border rounded w-full p-2">
                <option value="0" {{ old('is_featured', $post->is_featured) == '0' ? 'selected' : '' }}>Không</option>
                <option value="1" {{ old('is_featured', $post->is_featured) == '1' ? 'selected' : '' }}>Có</option>
            </select>
            @error('is_featured') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Tags --}}
        <div class="mb-4">
            <label class="block mb-1">Tags (phân cách bằng dấu phẩy)</label>
            <input type="text" name="tags" class="border rounded w-full p-2" value="{{ old('tags', $post->tags) }}">
            @error('tags') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Content --}}
        <div class="mb-4">
            <label class="block mb-1">Nội dung</label>
            <textarea name="content" class="border rounded w-full p-2" required>{{ old('content', $post->content) }}</textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Ảnh chính --}}
        <div class="mb-4">
            <label class="block mb-1">Ảnh chính</label>
            @if ($post->image)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $post->image) }}" alt="Current Image" class="max-w-xs h-auto">
                    <span class="text-sm text-gray-600">Để trống nếu không muốn thay đổi. Chọn file mới để cập nhật.</span>
                </div>
            @endif
            <input type="file" name="image" class="border rounded w-full p-2">
            @error('image') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Thumbnail --}}
        <div class="mb-4">
            <label class="block mb-1">Thumbnail</label>
            @if ($post->thumbnail)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="Current Thumbnail" class="max-w-xs h-auto">
                    <span class="text-sm text-gray-600">Để trống nếu không muốn thay đổi. Chọn file mới để cập nhật.</span>
                </div>
            @endif
            <input type="file" name="thumbnail" class="border rounded w-full p-2">
            @error('thumbnail') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Ngày bắt đầu --}}
        <div class="mb-4">
            <label class="block mb-1">Ngày bắt đầu (nếu là sự kiện)</label>
            <input type="date" name="start_date" class="border rounded w-full p-2" value="{{ old('start_date', $post->start_date ? \Carbon\Carbon::parse($post->start_date)->format('Y-m-d') : '') }}">
            @error('start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Ngày kết thúc --}}
        <div class="mb-4">
            <label class="block mb-1">Ngày kết thúc</label>
            <input type="date" name="end_date" class="border rounded w-full p-2" value="{{ old('end_date', $post->end_date ? \Carbon\Carbon::parse($post->end_date)->format('Y-m-d') : '') }}">
            @error('end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Meta title --}}
        <div class="mb-4">
            <label class="block mb-1">Meta Title</label>
            <input type="text" name="meta_title" class="border rounded w-full p-2" value="{{ old('meta_title', $post->meta_title) }}">
            @error('meta_title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        {{-- Meta description --}}
        <div class="mb-4">
            <label class="block mb-1">Meta Description</label>
            <input type="text" name="meta_description" class="border rounded w-full p-2" value="{{ old('meta_description', $post->meta_description) }}">
            @error('meta_description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">
            Cập nhật bài viết
        </button>
        <a href="{{ route('admin.posts.manage') }}" class="bg-gray-500 hover:bg-gray-700 text-white px-4 py-2 rounded ml-2">
            Hủy
        </a>
    </form>

        {{-- Preview bên phải --}}
        <div class="bg-white rounded-3xl shadow-lg border border-gray-100 overflow-hidden hover:shadow-xl transition-all duration-300">
            {{-- Avatar + info --}}
            <div class="flex items-center px-6 pt-6 pb-4">
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-indigo-500 to-fuchsia-500 text-white flex items-center justify-center text-base font-bold shadow-md">
                    {{ strtoupper(substr($post->author_name ?? 'U', 0, 1)) }}
                </div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">{{ $post->author_name ?? 'Tác giả không xác định' }}</p>
                    <p class="text-xs text-gray-500">{{ now()->format('d/m/Y H:i') }}</p>
                </div>
                <div class="ml-auto text-xs text-gray-400 italic">#{{ $post->slug }}</div>
            </div>

            {{-- Ảnh chính --}}
            <img id="preview-image" class="w-full h-[300px] object-cover {{ $post->image ? '' : 'hidden' }}" src="{{ $post->image ? asset('storage/' . $post->image) : '' }}" alt="preview" />

            {{-- Nội dung bài viết --}}
            <div class="px-6 py-5">
                <h2 id="preview-title" class="text-xl font-bold mb-2 text-gray-800">{{ $post->title }}</h2>
                <p id="preview-meta-description" class="text-gray-500 italic text-sm mb-4">{{ $post->meta_description }}</p>

                <div id="preview-content" class="prose prose-sm prose-indigo max-w-none text-gray-800 mb-5">{!! $post->content !!}</div>

                {{-- Tags --}}
                <div id="preview-tags" class="flex flex-wrap gap-2 text-xs text-gray-600 mb-4">
                    @foreach(explode(',', $post->tags) as $tag)
                        <span class="bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full transition text-xs">#{{ trim($tag) }}</span>
                    @endforeach
                </div>

                <hr class="my-3">
                <div class="text-sm text-gray-400 italic">
                    <div id="preview-meta-title">Meta Title: {{ $post->meta_title }}</div>
                    <div id="preview-date-range">
                        @if ($post->start_date || $post->end_date)
                            Thời gian: {{ $post->start_date ? \Carbon\Carbon::parse($post->start_date)->format('Y-m-d') : '...' }} →
                            {{ $post->end_date ? \Carbon\Carbon::parse($post->end_date)->format('Y-m-d') : '...' }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bind = (id, cb) => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('input', () => cb(el.value));
            }
        };

        // === Title ===
        bind('title', val => {
            document.getElementById('preview-title').innerText = val || 'Tiêu đề bài viết';
        });

        // === Content (hiển thị dưới dạng HTML) ===
        bind('content', val => {
            document.getElementById('preview-content').innerHTML = val || 'Nội dung bài viết sẽ hiển thị ở đây...';
        });

        // === Tags dạng #pill ===
        bind('tags', val => {
            const tagEl = document.getElementById('preview-tags');
            tagEl.innerHTML = '';
            if (val) {
                val.split(',').forEach(tag => {
                    const span = document.createElement('span');
                    span.className = 'bg-gray-100 hover:bg-gray-200 px-3 py-1 rounded-full transition text-xs';
                    span.innerText = `#${tag.trim()}`;
                    tagEl.appendChild(span);
                });
            }
        });

        // === Meta Title ===
        bind('meta_title', val => {
            const el = document.getElementById('preview-meta-title');
            el.innerText = val ? `Meta Title: ${val}` : '';
        });

        // === Meta Description ===
        bind('meta_description', val => {
            const el = document.getElementById('preview-meta-description');
            el.innerText = val ? val : '';
        });

        // === Date range ===
        const start = document.getElementById('start_date');
        const end = document.getElementById('end_date');
        const dateEl = document.getElementById('preview-date-range');

        const updateDateRange = () => {
            const startVal = start.value;
            const endVal = end.value;
            if (startVal || endVal) {
                dateEl.innerText = `Thời gian: ${startVal || '...'} → ${endVal || '...'}`;
            } else {
                dateEl.innerText = '';
            }
        };

        if (start && end) {
            start.addEventListener('input', updateDateRange);
            end.addEventListener('input', updateDateRange);
        }

        // === Preview ảnh ===
        const imageInput = document.getElementById('image');
        const previewImg = document.getElementById('preview-image');

        if (imageInput && previewImg) {
            imageInput.addEventListener('change', (e) => {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function (event) {
                        previewImg.src = event.target.result;
                        previewImg.classList.remove('hidden');
                    };
                    reader.readAsDataURL(file);
                } else {
                    previewImg.src = '';
                    previewImg.classList.add('hidden');
                }
            });
        }
    });
</script>
@endsection
