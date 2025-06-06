@extends('template.admin')
@section('content')
<div class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-2xl mt-10 space-y-8">
    <h1 class="text-3xl font-extrabold text-gray-800 border-b pb-3">Chi Tiết Chương Trình Giảm Giá</h1>

    <!-- Thông tin chung -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-700 text-base">
        <div>
            <p><span class="font-semibold">Tên chương trình:</span> {{ $discount->name }}</p>
        </div>
        <div>
            <p><span class="font-semibold">Phần trăm giảm:</span> <span class="text-red-600 font-bold">{{ $discount->percentage }}%</span></p>
        </div>
        <div>
            <p><span class="font-semibold">Ngày bắt đầu:</span> {{ \Carbon\Carbon::parse($discount->start_day)->format('d/m/Y') }}</p>
        </div>
        <div>
            <p><span class="font-semibold">Ngày kết thúc:</span> {{ \Carbon\Carbon::parse($discount->end_day)->format('d/m/Y') }}</p>
        </div>
        <div class="md:col-span-2">
            <p><span class="font-semibold">Trạng thái:</span>
                @if(\Carbon\Carbon::now()->lt($discount->start_day))
                    <span class="text-blue-600 font-semibold">Sắp diễn ra</span>
                @elseif(\Carbon\Carbon::now()->between($discount->start_day, $discount->end_day))
                    <span class="text-green-600 font-semibold">Đang diễn ra</span>
                @else
                    <span class="text-gray-500 font-semibold">Đã kết thúc</span>
                @endif
            </p>
        </div>
    </div>

    <!-- Sản phẩm áp dụng -->
    <div>
        <h2 class="text-xl font-bold text-purple-700 mb-4 border-b pb-2">Danh sách sản phẩm áp dụng</h2>

        @if($discount->products->count())
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
            @foreach($discount->products as $product)
            <div class="flex items-center gap-4 bg-gray-50 hover:bg-gray-100 transition rounded-lg p-4 shadow-sm border border-gray-200">
                @if($product->img->first())
                    <img src="{{ asset('img/' . $product->img->first()->name) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded-md border">
                @else
                    <div class="w-20 h-20 bg-gray-200 flex items-center justify-center text-gray-500 rounded-md border">No Image</div>
                @endif
                <div class="flex-1">
                    <p class="font-semibold text-gray-800">{{ $product->name }}</p>
                </div>
                <p class="text-sm text-gray-500 mt-1">
                    Giá gốc: <span class="line-through text-gray-400">{{ number_format($product->variant->first()->price ?? 0, 0, ',', '.') }}₫</span><br>
                    Giá giảm: <span class="text-red-500 font-medium">{{ number_format($product->discounted_price ?? 0, 0, ',', '.') }}₫</span>
                </p>
            </div>
            @endforeach
        </div>
        @else
            <p class="text-gray-500 italic">Chưa có sản phẩm nào áp dụng chương trình này.</p>
        @endif
    </div>
    <a href="{{ url('/admin/discount') }}" class="text-gray-600 hover:text-purple-600 transition">← Quay lại</a>
</div>
@endsection
