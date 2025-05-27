@extends('template.admin')
@section('content')
     <main class="flex-1 p-6 overflow-y-auto">
            <!-- Top bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="text-2xl font-semibold">Danh Sách Biến Thể</div>
                <a href="{{ url('/admin/add/variant') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                    + Thêm biến thể
                </a>
            </div>

            <!-- Table -->
            <div class="bg-white p-4 rounded shadow">
                <div class="flex justify-between items-center mb-4">
                    <div>Showing
                        <select class="border px-2 py-1 rounded ml-2">
                            <option>10</option>
                            <option>20</option>
                        </select>
                    </div>

                    <form action="/admin/search/variant" method="GET" class="flex items-center">
                        <div>
                            <input type="text" name="search" class="border px-2 py-1 rounded" placeholder="Tìm kiếm biến thể..." >
                            <button class="ml-2 bg-indigo-500 text-white px-3 py-1 rounded">Tìm kiếm</button>
                        </div>
                    </form>

                </div>

                <table class="min-w-full table-auto text-left">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm font-semibold uppercase tracking-wider">
                            <th class="p-3"><input type="checkbox"></th>
                            <th class="p-3">ID</th>
                            <th class="p-3">Tên Sản Phẩm</th>
                            <th class="p-3">Size</th>
                            <th class="p-3">Số Lượng</th>
                            <th class="p-3">Giá</th>
                            <th class="p-3">Giá Giảm</th>
                            <th class="p-3">Tình Trạng</th>
                            <th class="p-3">Trạng Thái</th>
                            <th class="p-3">Ngày Tạo</th>
                            <th class="p-3">Ngày Cập nhật</th>
                            <th class="p-3">Hành Động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Sample row -->
                        @foreach ($variants as $variant)
                            <tr class="border-t hover:bg-gray-50 text-sm text-gray-700 leading-relaxed">
                                <td class="p-3"><input type="checkbox"></td>
                                <td class="p-3 font-medium text-indigo-600">{{ $variant->id }}</td>
                                <td class="p-3">{{ $variant->product->name ?? 'N/A' }}</td>
                                <td class="p-3">{{ $variant->size }}</td>
                                <td class="p-3">{{ $variant->stock_quantity }}</td>
                                <td class="p-3 text-gray-600 whitespace-nowrap" >{{ number_format($variant->price, 0, ',', '.') }} ₫</td>
                                @if ($variant->sale_price == 0)
                                    <td class="p-3 text-red-500 whitespace-nowrap">---₫</td>
                                @else
                                    <td class="p-3 text-red-500 whitespace-nowrap">{{ number_format($variant->sale_price, 0, ',', '.') }} ₫</td>
                                @endif

                                <td class="p-3">
                                    @if ($variant->status == 'còn hàng')
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Còn hàng</span>
                                    @else
                                        <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded">Hết hàng</span>
                                    @endif
                                </td>
                                <td class="p-3 whitespace-nowrap">
                                    @if ($variant->active == 'on')
                                        <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded">Hoạt động</span>
                                    @elseif ($variant->active == 'off')
                                        <span class="bg-yellow-100 text-yellow-700 text-xs px-2 py-1 rounded">Đang cập nhật</span>
                                    @else
                                        {{-- <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded">Không hoạt động</span> --}}
                                    @endif
                                </td>
                                <td class="p-3">{{ optional($variant->created_at)->format('d-m-Y H:i') }}</td>
                                <td class="p-3">{{ optional($variant->updated_at)->format('d-m-Y H:i') }}</td>
                                <td class="p-3 flex gap-2">
                                    <a href="{{ url('/admin/variant/edit/' . $variant->id) }}" class="bg-green-100 text-green-600 px-2 py-1 rounded text-xs">
                                        <i class="ph ph-pencil"></i>
                                    </a>
                                    <button class="bg-red-100 text-red-600 px-2 py-1 rounded text-xs">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach


                        <!-- Repeat rows as needed -->
                    </tbody>
                </table>
                <div class="mt-4">
                    {{ $variants->links() }}
                </div>
            </div>
        </main>
@endsection
