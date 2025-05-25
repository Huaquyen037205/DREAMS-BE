@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Chỉnh Sửa Sản Phẩm</h2>

        <form action="{{ url('/admin/product/edit/' . $product->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tên Sản Phẩm</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" value="{{ old('name', $product->name) }}">
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Danh Mục</label>
                <select name="category_id" class="w-full border px-3 py-2 rounded">
                    <option value="1" {{ $product->category_id == 1 ? 'selected' : '' }}>Bomber</option>
                    <option value="2" {{ $product->category_id == 2 ? 'selected' : '' }}>Áo thun</option>
                    <option value="3" {{ $product->category_id == 3 ? 'selected' : '' }}>Quần</option>
                    <option value="4" {{ $product->category_id == 4 ? 'selected' : '' }}>Hoodie</option>
                    <option value="5" {{ $product->category_id == 5 ? 'selected' : '' }}>Túi Sách</option>
                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Mô Tả Sản Phẩm</label>
                <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded">{{ old('description', $product->description) }}</textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Trạng Thái</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="còn hàng" {{ $product->status == 'còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                    <option value="hết hàng" {{ $product->status == 'hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                </select>
            </div>

            <!-- Image Upload -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Thay Đổi Ảnh</label>
                <input type="file" name="image" class="w-full border px-3 py-2 rounded">
                @if ($product->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $product->image) }}" alt="Product image" class="w-32 rounded border">
                    </div>
                @endif
            </div>

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Cập nhật sản phẩm</button>
                <a href="{{ url('/admin/product/list') }}" class="ml-3 text-gray-600 hover:text-indigo-500">Hủy</a>
            </div>
        </form>
    </div>
</main>
@endsection
