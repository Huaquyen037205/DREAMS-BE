@extends('template.admin')

@section('content')
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Chỉnh sửa bài viết: {{ $post->title }}</h2>

    <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
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
</main>
@endsection
