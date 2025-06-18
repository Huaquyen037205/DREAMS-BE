@extends('template.admin')
@section('content')
<div class="container mx-auto max-w-4xl px-6 py-10">
    <h2 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
        Chỉnh Sửa Chương Trình Giảm Giá
    </h2>

    @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
            <strong>⚠️ Đã xảy ra lỗi:</strong>
            <ul class="mt-2 list-disc list-inside space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ url('/admin/edit/discount/' . $discount->id) }}" method="POST" class="bg-white p-8 rounded-2xl shadow-md border border-gray-200 space-y-6">
        @csrf
        @method('PUT')

        <!-- Tên & Phần trăm -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-semibold text-gray-700 mb-1">Tên Chương Trình</label>
                <input type="text" name="name" id="name" value="{{ old('name', $discount->name) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('name')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="percentage" class="block text-sm font-semibold text-gray-700 mb-1">Phần Trăm Giảm (%)</label>
                <input type="number" name="percentage" id="percentage" min="1" max="100" value="{{ old('percentage', $discount->percentage) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('percentage')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Ngày bắt đầu / kết thúc -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="start_day" class="block text-sm font-semibold text-gray-700 mb-1">Ngày Bắt Đầu</label>
                <input type="date" name="start_day" id="start_day" value="{{ old('start_day', \Carbon\Carbon::parse($discount->start_day)->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('start_day')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="end_day" class="block text-sm font-semibold text-gray-700 mb-1">Ngày Kết Thúc</label>
                <input type="date" name="end_day" id="end_day" value="{{ old('end_day', \Carbon\Carbon::parse($discount->end_day)->format('Y-m-d')) }}" class="w-full border-gray-300 rounded-lg px-4 py-2 shadow-sm focus:ring-2 focus:ring-purple-500 focus:outline-none">
                @error('end_day')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <!-- Chọn sản phẩm -->
        <div>
    <label class="block text-sm font-semibold text-gray-700 mb-2">Chọn Sản Phẩm Áp Dụng</label>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 max-h-64 overflow-y-auto border border-gray-200 p-4 rounded-lg bg-gray-50">
        @foreach($allProducts as $product)
            <label class="flex items-center space-x-2 text-sm text-gray-700">
                <input type="checkbox" name="products[]" value="{{ $product->id }}"
                       {{ $discount->products->contains('id', $product->id) ? 'checked' : '' }}
                       class="text-purple-600 focus:ring-purple-500 border-gray-300 rounded">
                <span>{{ $product->name }}</span>
            </label>
        @endforeach
    </div>

    <p class="text-xs text-gray-500 mt-1">Tích chọn những sản phẩm bạn muốn áp dụng chương trình giảm giá.</p>
        <div class="flex items-center justify-start gap-4 pt-4">
            <button type="submit" class="bg-purple-600 hover:bg-purple-700 transition text-white font-semibold py-2 px-6 rounded-lg shadow-md">
                Cập Nhật
            </button>
            <a href="{{ url('/admin/discount') }}" class="text-sm text-gray-600 hover:text-purple-600 transition underline underline-offset-2">
                ← Quay lại danh sách
            </a>
        </div>
    </form>
</div>
@endsection
