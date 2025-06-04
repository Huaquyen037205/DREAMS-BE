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
        </div>
    </div>

    @if(session('success'))
        <div class="flex items-center bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <svg class="w-5 h-5 mr-2 text-green-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
            </svg>
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->has('name'))
        <div class="flex items-center bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <svg class="w-5 h-5 mr-2 text-red-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
            </svg>
            <span class="block sm:inline">{{ $errors->first('name') }}</span>
        </div>
    @endif

    <!-- Variants Table -->
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-semibold">Danh Sách Biến Thể</div>
            <a href="{{ url('/admin/add/variant') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
            + Thêm biến thể
        </a>
    </div>

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
                    <th class="p-3 border">Ngày cập nhật</th>
                    <th class="p-3 border">Hành động</th>
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

                        <td class="p-3 border text-center">
                            @if($variant->active === 'on')
                                <span class="bg-green-100 text-green-700 px-2 py-1 rounded-full text-sm">Hoạt động</span>
                            @else
                                <span class="bg-yellow-100 text-red-700 px-2 py-1 rounded-full text-sm">Đang cập nhật</span>
                            @endif
                        </td>

                        <td class="p-3 border text-center">{{ optional($variant->updated_at)->format('d-m-Y H:i') }}</td>

                        <td class="p-3 border text-center">
                            <a href="{{ url('/admin/variant/edit/' . $variant->id) }}" class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                <i class="ph ph-pencil"></i>
                            </a>
                        </td>
                    </tr>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>

<div class="bg-gray-50 p-4 rounded shadow mb-8 mt-4">
    <h3 class="font-semibold mb-2">Thêm ảnh sản phẩm</h3>
    <form action="{{ url('/admin/product/add-img') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <input type="file" name="name" accept="image/*" required class="border px-2 py-1 rounded mb-2">
        <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">Thêm ảnh</button>
    </form>
</div>


<div class="grid grid-cols-3 gap-4 mb-4">
    @foreach($product->img as $img)
        <div class="flex flex-col items-center justify-center text-center">
            <img src="{{ asset('img/' . $img->name) }}"
                 class="rounded-md border shadow-sm aspect-square object-cover w-full max-w-[350px] mb-2" />

            <!-- Form sửa ảnh -->
            <form action="{{ url('/admin/product/edit-img/' . $img->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col items-center gap-2 w-full">
                @csrf
                @method('POST')
                <input type="file" name="name" accept="image/*" required class="border px-2 py-1 rounded w-full max-w-[200px]">
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 text-sm">
                    Sửa ảnh
                </button>
            </form>
        </div>
    @endforeach
</div>



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
