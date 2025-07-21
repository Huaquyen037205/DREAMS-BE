@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
         <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold mb-4">Thêm Sản Phẩm</h2>
            <a href="{{ url('/admin/product/list') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                Danh sách sản phẩm
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        <form action="/admin/product/add" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Product Name -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tên Sản Phẩm</label>
                <input type="text" name="name" class="w-full border px-3 py-2 rounded" value="{{$product->name}}" placeholder="Nhập tên sản phẩm...">
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Danh Mục</label>
                <select name="category_id" class="w-full border px-3 py-2 rounded">
                    <option value="">Chọn Danh Mục</option>
                    <option value="1" {{$product->category_id == 1 ? 'selected' : ''}}>Bomber</option>
                    <option value="2" {{$product->category_id == 2 ? 'selected' : ''}}>Áo thun</option>
                    <option value="3" {{$product->category_id == 3 ? 'selected' : ''}}>Quần</option>
                    <option value="4" {{$product->category_id == 4 ? 'selected' : ''}}>Hoddie</option>
                    <option value="7" {{$product->category_id == 7 ? 'selected' : ''}}>Túi sách</option>
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
                    <option value="on" {{ $product->active == 'on' ? 'selected' : '' }}>Kích hoạt</option>
                    <option value="off" {{ $product->active == 'off' ? 'selected' : '' }}>Dừng kích hoạt</option>
                </select>
            </div>



            <div class="mb-4">
                <label class="block text-gray-700 mb-1">Tình Trạng</label>
                <select name="status" class="w-full border px-3 py-2 rounded">
                    <option value="còn hàng" {{ $product->status == 'còn hàng' ? 'selected' : '' }}>còn hàng</option>
                    <option value="hết hàng" {{ $product->status == 'hết hàng' ? 'selected' : '' }}>hết hàng</option>
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
                <a href="/admin/product/list" class="ml-3 text-gray-600 hover:text-indigo-500">Hủy</a>
            </div>
        </form>
    </div>
</main>
@endsection
