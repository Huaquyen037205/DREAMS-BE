@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-semibold mb-4">Thêm Sản Phẩm</h2>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tên Sản Phẩm</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" placeholder="Nhập tên sản phẩm...">
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Danh Mục</label>
                <select name="category_id" class="w-full border px-3 py-2 rounded">
                    <option value="">Chọn Danh Mục</option>
                    <option value="1">Bomber</option>
                    <option value="2">Áo thun</option>
                    <option value="3">Quần</option>
                    <option value="3">Hoddie</option>
                    <option value="3">Túi sách</option>
                </select>
            </div>

            <!-- Description -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Mô Tả</label>
                <textarea name="description" rows="3" class="w-full border px-3 py-2 rounded" placeholder="Nhập mô tả..."></textarea>
            </div>

            <!-- Status -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Trạng Thái</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="còn hàng">còn hàng</option>
                    <option value="hết hàng">hết hàng</option>
                </select>
            </div>

            <!-- Image Upload -->
            {{-- <div class="mb-4">
                <label class="block text-gray-700 mb-1">Ảnh Sản Phẩm</label>
                <input type="file" name="image" class="w-full border px-3 py-2 rounded">
            </div> --}}

            <!-- Submit -->
            <div class="mt-6">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-4 py-2 rounded">Thêm Sản Phẩm</button>
                <a href="#" class="ml-3 text-gray-600 hover:text-indigo-500">Hủy</a>
            </div>
        </form>
    </div>
</main>
@endsection
