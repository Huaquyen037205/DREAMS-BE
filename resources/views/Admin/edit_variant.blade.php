@extends('template.admin')

@section('content')
<div class="bg-white shadow-md rounded p-6 max-w-2xl mx-auto mt-10">
    <h2 class="text-2xl font-bold mb-6">Chỉnh sửa biến thể sản phẩm</h2>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 border border-red-300 rounded p-4">
            <strong>Lỗi:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @if (session('success'))
        <div class="mb-4 bg-green-100 text-green-700 border border-green-300 rounded p-4">
            <strong>Thành công:</strong> {{ session('success') }}
        </div>
    @endif
    <form action="{{ url('/admin/variant/edit/' . $variant->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Tên sản phẩm (readonly hoặc select nếu cần thay đổi) --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Sản phẩm</label>
            <input type="text" value="{{ $variant->product->name ?? '---' }}" readonly
                class="w-full border border-gray-300 rounded px-3 py-2 bg-gray-100">
            <input type="hidden" name="product_id" value="{{ $variant->product_id }}">
        </div>

        {{-- Size --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Size</label>
            <input type="text" name="size" value="{{ old('size', $variant->size) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        {{-- Số lượng --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Số lượng</label>
            <input type="number" name="stock_quantity" value="{{ old('stock_quantity', $variant->stock_quantity) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        {{-- Giá --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Giá</label>
            <input type="number" name="price" value="{{ old('price', number_format($variant->price, 0, ',', '.')) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2" required>
        </div>

        {{-- Giá giảm (nếu có) --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Giá giảm</label>
            <input type="number" name="sale_price" value="{{ old('sale_price', number_format($variant->sale_price, 0, ',', '.')) }}"
                   class="w-full border border-gray-300 rounded px-3 py-2">
        </div>

        {{-- Tình trạng --}}
        <div class="mb-4">
            <label class="block font-medium mb-1">Tình trạng</label>
            <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="còn hàng" @selected($variant->status == 'còn hàng')>còn hàng</option>
                <option value="hết hàng" @selected($variant->status == 'hết hàng')>hết hàng</option>
            </select>
        </div>

        {{-- Trạng thái hoạt động --}}
        <div class="mb-6">
            <label class="block font-medium mb-1">Trạng thái</label>
            <select name="active" class="w-full border border-gray-300 rounded px-3 py-2">
                <option value="on" @selected($variant->active == 'on')>Hoạt động</option>
                <option value="off" @selected($variant->active == 'off')>Đang cập nhật</option>
            </select>
        </div>

        <div class="flex justify-end gap-4">
            <a href="{{ url('/admin/variant/list') }}"
               class="px-4 py-2 border rounded text-gray-600 hover:bg-gray-100">Quay lại</a>
            <button type="submit"
                    class="bg-purple-600 text-white px-4 py-2 rounded hover:bg-purple-700">
                Cập nhật
            </button>
        </div>
    </form>
</div>
@endsection
