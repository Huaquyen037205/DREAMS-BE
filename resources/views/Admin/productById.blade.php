@extends('template.admin')

@section('content')
<main class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold mb-6 text-indigo-700">Chi tiết sản phẩm: {{ $product->name }}</h1>
        <a href="{{ url('/admin/product/list') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
            Danh sách sản phẩm
        </a>
    </div>

    <!-- Product Info Card -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="mb-2"><strong class="text-gray-700">Danh mục:</strong> {{ $product->category->name ?? 'Không có' }}</p>
                <p class="mb-2"><strong class="text-gray-700">Mô tả:</strong> {{ $product->description }}</p>
                <p class="mb-2"><strong class="text-gray-700">Ngày tạo:</strong> {{ optional($product->created_at)->format('d-m-Y H:i') }}</p>
            </div>
            <div>
                @if(isset($product->images) && count($product->images))
                    <div class="grid grid-cols-3 gap-2">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/'.$img->url) }}" class="rounded-md border shadow-sm h-24 w-full object-cover" />
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 italic">Không có ảnh đại diện</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Variants Table -->
    <h2 class="text-xl font-semibold mb-3 text-gray-800">Danh sách biến thể</h2>
    <div class="overflow-x-auto">
        <table class="w-full table-auto border border-gray-200 rounded-md">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="p-3 border">Size</th>
                    <th class="p-3 border">Số lượng</th>
                    <th class="p-3 border">Giá</th>
                    <th class="p-3 border">Giá giảm</th>
                    <th class="p-3 border">Trạng thái hàng</th>
                    <th class="p-3 border">Trạng thái</th>
                </tr>
            </thead>
            <tbody>
                @foreach($product->variant as $variant)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="p-3 border text-center">{{ $variant->size }}</td>
                        <td class="p-3 border text-center">{{ $variant->stock_quantity }}</td>
                        <td class="p-3 border text-center text-green-600 font-semibold">{{ number_format($variant->price) }} đ</td>
                        <td class="p-3 border text-center text-red-500">
                            {{ $variant->sale_price ? number_format($variant->sale_price).' đ' : '---' }}
                        </td>
                        <td class="p-3 border text-center">
                            @if($variant->status === 'còn hàng')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">Còn hàng</span>
                            @else
                                <span class="bg-red-100 text-red-700 px-2 py-1 rounded-full text-sm">Hết hàng</span>
                            @endif
                        </td>

                        </td>
                        <td class="p-3 border text-center">
                            @if($variant->active === 'on')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">Hoạt động</span>
                            @else
                                <span class="bg-yellow-100 text-red-700 px-2 py-1 rounded-full text-sm">Đang cập nhật</span>
                            @endif
                        </td>
                    </tr>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<!-- Hiển thị đánh giá và bình luận -->
<h2 class="text-xl font-semibold mt-8 mb-3 text-gray-800">Đánh giá & Bình luận của khách hàng</h2>
<div class="mb-6">
    @if($product->reviews && count($product->reviews))
        @foreach($product->reviews as $review)
            <div class="mb-4 border-b pb-3">
                <div class="flex items-center gap-2">
                    <span class="font-semibold text-indigo-700">{{ $review->user->name ?? 'Ẩn danh' }}</span>
                    <span class="text-yellow-500">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa{{ $i <= $review->rating ? 's' : 'r' }} fa-star"></i>
                        @endfor
                    </span>
                    <span class="text-xs text-gray-500 ml-2">{{ $review->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="mt-1 text-gray-800">{{ $review->comment }}</div>
            </div>
        @endforeach
    @else
        <p class="text-gray-500 italic">Chưa có đánh giá nào cho sản phẩm này.</p>
    @endif
</div>

<!-- Form gửi đánh giá -->
{{-- <div class="bg-gray-50 p-4 rounded shadow mb-8">
    <h3 class="font-semibold mb-2">Gửi đánh giá của bạn</h3>
    <form action="{{ url('/product/'.$product->id.'/review') }}" method="POST">
        @csrf
        <div class="mb-2">
            <label class="block mb-1 font-medium">Số sao</label>
            <select name="rating" class="border px-2 py-1 rounded" required>
                <option value="">Chọn số sao</option>
                @for($i=5; $i>=1; $i--)
                    <option value="{{ $i }}">{{ $i }} sao</option>
                @endfor
            </select>
        </div>
        <div class="mb-2">
            <label class="block mb-1 font-medium">Bình luận</label>
            <textarea name="comment" rows="3" class="w-full border px-2 py-1 rounded" required></textarea>
        </div>
        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Gửi đánh giá</button>
    </form>
</div> --}}
@endsection
