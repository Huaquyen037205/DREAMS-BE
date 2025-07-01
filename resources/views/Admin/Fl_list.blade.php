@extends('template.admin')

@section('content')
<main class="flex-1 px-4 md:px-8 py-6 overflow-y-auto bg-gray-50 min-h-screen">
    <div class="flex justify-between items-center flex-wrap gap-4 mb-8">
        <h2 class="text-2xl md:text-3xl font-bold text-gray-800 flex items-center gap-2">
            ⚡ Danh Sách Flash Sale
        </h2>
        <a href="{{ url('/admin/flash-sale/create') }}"
           class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow transition text-sm font-semibold">
            ➕ Tạo Chương Trình
        </a>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md hover:shadow-lg transition overflow-x-auto border border-gray-100">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-indigo-50 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="p-3 font-semibold">#</th>
                    <th class="p-3 font-semibold">Tên Chương Trình</th>
                    <th class="p-3 font-semibold">Bắt Đầu</th>
                    <th class="p-3 font-semibold">Kết Thúc</th>
                    <th class="p-3 font-semibold">Trạng Thái</th>
                    <th class="p-3 text-center font-semibold">Hành Động</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-gray-700">
                @foreach ($flashSales as $index => $sale)
                <tr class="hover:bg-gray-50 transition group cursor-pointer"
                    onclick="window.location='{{ url('/admin/flash-sale/'.$sale->id) }}'">
                    <td class="p-3">{{ $index + 1 }}</td>
                    <td class="p-3 font-semibold text-gray-800 group-hover:underline">{{ $sale->name }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($sale->start_time)->format('d/m/Y H:i') }}</td>
                    <td class="p-3">{{ \Carbon\Carbon::parse($sale->end_time)->format('d/m/Y H:i') }}</td>
                    <td class="p-3">
                        @php
                            $start = \Carbon\Carbon::parse($sale->start_time);
                            $end = \Carbon\Carbon::parse($sale->end_time);
                        @endphp
                        @if(now()->between($start, $end))
                            <span class="text-green-600 font-semibold bg-green-100 px-2 py-1 rounded-md text-xs">Đang diễn ra</span>
                        @elseif(now()->lt($start))
                            <span class="text-yellow-700 font-semibold bg-yellow-100 px-2 py-1 rounded-md text-xs">Sắp diễn ra</span>
                        @else
                            <span class="text-red-600 font-semibold bg-red-100 px-2 py-1 rounded-md text-xs">Đã kết thúc</span>
                        @endif
                    </td>
                    <td class="p-3 text-center">
                        <div class="flex items-center justify-center gap-2 text-sm" onclick="event.stopPropagation();">
                            <a href="{{ url('/admin/flash-sale/'.$sale->id.'/edit') }}"
                               class="text-blue-600 hover:underline">✏️ Sửa</a>

                            <a href="/admin/flash-sale/{{ $sale->id }}/products"
                               class="bg-indigo-500 hover:bg-indigo-600 text-white px-3 py-1 rounded-lg text-xs font-semibold shadow-sm">
                                ➕ Sản phẩm
                            </a>

                            <form method="POST" action="{{ url('/admin/flash-sale/'.$sale->id) }}"
                                  onsubmit="return confirm('Bạn có chắc muốn xoá?')" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:underline">🗑️ Xoá</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach

                @if($flashSales->isEmpty())
                <tr>
                    <td colspan="6" class="text-center text-gray-400 py-6 italic">Không có chương trình Flash Sale nào.</td>
                </tr>
                @endif
            </tbody>
        </table>

        <div class="mt-6">
            {{ $flashSales->links('pagination::tailwind') }}
        </div>
    </div>
</main>
@endsection
