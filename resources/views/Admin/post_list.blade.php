@extends('template.admin')

@section('content')
<main class="p-6">
    <h2 class="text-2xl font-bold mb-4">Thêm bài viết mới</h2>

    <form action="{{ url('/admin/posts') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Title --}}
        <div class="mb-4">
            <label class="block mb-1">Tiêu đề</label>
            <input type="text" name="title" class="border rounded w-full p-2" required>
        </div>

        {{-- Slug --}}
        <div class="mb-4">
            <label class="block mb-1">Slug (tự sinh nếu bỏ trống)</label>
            <input type="text" name="slug" class="border rounded w-full p-2">
        </div>

        {{-- Type --}}
        <div class="mb-4">
            <label class="block mb-1">Loại</label>
            <select name="type" class="border rounded w-full p-2" required>
                <option value="product">Sản phẩm</option>
                <option value="event">Sự kiện</option>
            </select>
        </div>

        {{-- Product ID --}}
        <div class="mb-4">
            <label class="block mb-1">Sản phẩm liên kết (ID)</label>
            <input type="number" name="product_id" class="border rounded w-full p-2">
        </div>

        {{-- Trạng thái --}}
        <div class="mb-4">
            <label class="block mb-1">Trạng thái</label>
            <select name="status" class="border rounded w-full p-2">
                <option value="draft">Nháp</option>
                <option value="published">Công khai</option>
            </select>
        </div>

        {{-- Is featured --}}
        <div class="mb-4">
            <label class="block mb-1">Nổi bật?</label>
            <select name="is_featured" class="border rounded w-full p-2">
                <option value="0">Không</option>
                <option value="1">Có</option>
            </select>
        </div>

        {{-- Tags --}}
        <div class="mb-4">
            <label class="block mb-1">Tags (phân cách bằng dấu phẩy)</label>
            <input type="text" name="tags" class="border rounded w-full p-2">
        </div>

        {{-- Content --}}
        <div class="mb-4">
            <label class="block mb-1">Nội dung</label>
            <textarea name="content" class="border rounded w-full p-2" required></textarea>
        </div>

        {{-- Ảnh chính --}}
        <div class="mb-4">
            <label class="block mb-1">Ảnh chính</label>
            <input type="file" name="image" class="border rounded w-full p-2">
        </div>

        {{-- Thumbnail --}}
        <div class="mb-4">
            <label class="block mb-1">Thumbnail</label>
            <input type="file" name="thumbnail" class="border rounded w-full p-2">
        </div>

        {{-- Ngày bắt đầu --}}
        <div class="mb-4">
            <label class="block mb-1">Ngày bắt đầu (nếu là sự kiện)</label>
            <input type="date" name="start_date" class="border rounded w-full p-2">
        </div>

        {{-- Ngày kết thúc --}}
        <div class="mb-4">
            <label class="block mb-1">Ngày kết thúc</label>
            <input type="date" name="end_date" class="border rounded w-full p-2">
        </div>

        {{-- Meta title --}}
        <div class="mb-4">
            <label class="block mb-1">Meta Title</label>
            <input type="text" name="meta_title" class="border rounded w-full p-2">
        </div>

        {{-- Meta description --}}
        <div class="mb-4">
            <label class="block mb-1">Meta Description</label>
            <input type="text" name="meta_description" class="border rounded w-full p-2">
        </div>

        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded">
            Thêm bài viết
        </button>
    </form>
</main>
@endsection
