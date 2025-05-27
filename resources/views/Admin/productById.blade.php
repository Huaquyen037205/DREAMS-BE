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
@endsection
