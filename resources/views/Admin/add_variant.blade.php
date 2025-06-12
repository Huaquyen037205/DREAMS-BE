@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold">Thêm Biến Thể</h2>
            <a href="{{ url('/admin/product/list') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 text-sm">
                Danh sách biến thể
            </a>
        </div>

        {{-- Thông báo --}}
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="/admin/variant/add" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            {{-- Mã Sản Phẩm --}}
            <div>
            <label class="block text-sm font-medium text-gray-700">Chọn Sản Phẩm</label>
                <select name="product_id" class="mt-1 w-full border px-3 py-2 rounded">
                    <option value="">-- Chọn sản phẩm --</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Chọn Ảnh</label>
                <select name="img_id" class="mt-1 w-full border px-3 py-2 rounded">
                    <option value="">-- Chọn ảnh --</option>
                    @foreach($images as $img)
                        <option value="{{ $img->id }}">Ảnh ID: {{ $img->id }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Hiển thị lỗi nếu có --}}

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                {{-- Size --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Size</label>
                    <select name="size" class="mt-1 w-full border px-3 py-2 rounded">
                        <option value="">Chọn Size</option>
                        @foreach (['S', 'M', 'L', 'XL'] as $size)
                            <option value="{{ $size }}" {{ $variant->size == $size ? 'selected' : '' }}>{{ $size }}</option>
                        @endforeach
                    </select>
                    @error('size')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Số lượng --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Số Lượng</label>
                    <input type="number" name="stock_quantity" min="1" value="{{ $variant->stock_quantity }}" class="mt-1 w-full border px-3 py-2 rounded">
                    @error('stock_quantity')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror

                </div>

                {{-- Giá --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Giá</label>
                    <input type="number" name="price" min="0" value="{{ $variant->price }}" class="mt-1 w-full border px-3 py-2 rounded">
                    @error('price')
                        <div class="text-red-500 text-sm">{{ $message }}</div>
                    @enderror
                </div>

                {{-- Giá Giảm --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Giá Giảm</label>
                    <input type="number" name="sale_price" min="0" value="{{ $variant->sale_price }}" class="mt-1 w-full border px-3 py-2 rounded">
                </div>

                {{-- Trạng Thái Hoạt Động --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Trạng Thái Hoạt Động</label>
                    <select name="active" class="mt-1 w-full border px-3 py-2 rounded">
                        <option value="on" {{ $variant->active == 'on' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="off" {{ $variant->active == 'off' ? 'selected' : '' }}>Đang cập nhật</option>
                    </select>
                </div>

                {{-- Tình Trạng Hàng --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700">Tình Trạng</label>
                    <select name="status" class="mt-1 w-full border px-3 py-2 rounded">
                        <option value="còn hàng" {{ $variant->status == 'còn hàng' ? 'selected' : '' }}>Còn hàng</option>
                        <option value="hết hàng" {{ $variant->status == 'hết hàng' ? 'selected' : '' }}>Hết hàng</option>
                    </select>
                </div>
            </div>

            {{-- Nút hành động --}}
            <div class="pt-4">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 text-white px-5 py-2 rounded text-sm">Thêm Biến Thể</button>
                <a href="{{ url('/admin/product/list') }}" class="ml-3 text-gray-600 hover:text-indigo-500 text-sm">Hủy</a>
            </div>
        </form>
    </div>

</main>
@endsection
