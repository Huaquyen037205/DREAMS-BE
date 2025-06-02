@extends('template.admin')
@section('content')
<main class="p-6 bg-gray-50 min-h-screen">
    <h1 class="text-2xl font-semibold mb-4 text-gray-800">Sản phẩm trong danh mục: <span class="text-indigo-600">{{ $category->name }}</span></h1>

    @if($category->product->isEmpty())
        <p class="text-gray-500 text-lg">Danh mục chưa có sản phẩm nào.</p>
    @else
        <table class="min-w-full bg-white rounded shadow overflow-hidden">
            <thead class="bg-indigo-100 text-indigo-700">
                <tr>
                    <th class="py-2 px-4 text-left">STT</th>
                    <th class="py-2 px-4 text-left">Ảnh</th>
                    <th class="py-2 px-4 text-left">Tên sản phẩm</th>
                    <th class="py-2 px-4 text-left">Mô tả</th>
                    <th class="py-2 px-4 text-left">Giá</th>
                </tr>
            </thead>
            <tbody>
                @foreach($category->product as $index => $product)
                <tr class="border-b last:border-b-0">
                    <td class="py-2 px-4 align-middle">{{ $index + 1 }}</td>
                    <td class="py-2 px-4">
                        @if($product->img && $product->img->first())
                            <img src="{{ asset('img/' . $product->img->first()->name) }}" alt="{{ $product->name }}" class="w-16 h-16 object-cover rounded">
                        @else
                            <div class="w-16 h-16 bg-gray-200 flex items-center justify-center text-gray-400 text-sm rounded">
                                Không có ảnh
                            </div>
                        @endif
                    </td>
                    <td class="py-2 px-4 align-middle">{{ $product->name }}</td>
                    <td class="py-2 px-4 text-gray-600 align-middle">
                        {{ Str::limit($product->description ?? 'Không có mô tả', 100) }}
                    </td>
                    <td class="py-2 px-4 font-semibold text-indigo-600 align-middle">
                        @if($product->variant && $product->variant->first())
                            {{ number_format($product->variant->first()->price, 0, ',', '.') }} đ
                        @endif
                    </td>
                @endforeach
            </tbody>
        </table>
    @endif

    <div class="mt-6">
        <a href="{{ url('admin/categories') }}" class="text-indigo-600 hover:underline">&larr; Quay lại danh sách danh mục</a>
    </div>
</main>
@endsection
