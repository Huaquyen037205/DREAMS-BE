@extends('template.admin')

@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">⚡ Danh Sách Flash Sale</h2>
        <a href="{{ url('/admin/flash-sale/create') }}"
           class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-lg shadow transition">
            ➕ Chương Trình Flash Sale
        </a>
    </div>

    <div class="bg-white p-6 rounded-lg shadow-md overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 text-sm text-left">
            <thead class="bg-gray-100 text-gray-700 uppercase tracking-wider">
                <tr>
                    <th class="p-3">STT</th>
                    <th class="p-3">Tên Chương Trình</th>
                    <th class="p-3">Bắt Đầu</th>
                    <th class="p-3">Kết Thúc</th>
                    <th class="p-3">Trạng Thái</th>
                    <th class="p-3">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($flashSales as $index => $sale)
                <tr class="hover:bg-gray-50 transition cursor-pointer"
                    onclick="window.location='{{ url('/admin/flash-sale/'.$sale->id) }}'">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3 font-medium text-gray-800">{{ $sale->name }}</td>
                    <td class="p-3 text-gray-600">{{ $sale->start_time }}</td>
                    <td class="p-3 text-gray-600">{{ $sale->end_time }}</td>
                    <td class="p-3">
                        @php
                            $start = \Carbon\Carbon::parse($sale->start_time);
                            $end = \Carbon\Carbon::parse($sale->end_time);
                        @endphp
                        @if(now()->between($start, $end))
                            <span class="text-green-600 font-semibold">Đang diễn ra</span>
                        @elseif(now()->lt($start))
                            <span class="text-yellow-600 font-semibold">Sắp diễn ra</span>
                        @else
                            <span class="text-red-600 font-semibold">Đã kết thúc</span>
                        @endif
                    </td>
                    <td class="p-3">
                        <div class="flex items-center gap-2" onclick="event.stopPropagation();">
                            <a href="{{ url('/admin/flash-sale/'.$sale->id.'/edit') }}" class="text-blue-600 hover:underline">Sửa</a>
                            <a href="/admin/flash-sale/{{ $sale->id }}/products"
                               class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded text-sm">➕ Sản phẩm</a>
                            <form method="POST" action="{{ url('/admin/flash-sale/'.$sale->id) }}" onsubmit="return confirm('Bạn có chắc muốn xoá?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Xoá</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if($flashSales->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-gray-500 p-4">Không có chương trình Flash Sale nào.</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="mt-4">
            {{ $flashSales->links() }}
        </div>
    </div>
</main>
@endsection
