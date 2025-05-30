{{-- filepath: resources/views/Admin/Fl_list.blade.php --}}
@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="flex justify-between items-center mb-6">
        <div class="text-2xl font-semibold">Danh Sách Flash Sale</div>
        <a href="{{ url('/admin/flash-sale/create') }}" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
            + Chương Trình Flash Sale
        </a>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <table class="min-w-full table-auto text-left">
            <thead>
                <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                    <th class="p-2">STT</th>
                    <th class="p-2">Tên Chương Trình</th>
                    <th class="p-2">Thời Gian Bắt Đầu</th>
                    <th class="p-2">Thời Gian Kết Thúc</th>
                    <th class="p-2">Trạng Thái</th>
                    <th class="p-2">Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flashSales as $index => $sale)
                <tr class="border-t hover:bg-gray-50"
                    style="cursor:pointer"
                    onclick="window.location='{{ url('/admin/flash-sale/'.$sale->id) }}'">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $sale->name }}</td>
                    <td class="p-2">{{ $sale->start_time }}</td>
                    <td class="p-2">{{ $sale->end_time }}</td>
                    <td class="p-2">
                    @php
                        $start = \Carbon\Carbon::parse($sale->start_time);
                        $end = \Carbon\Carbon::parse($sale->end_time);
                    @endphp
                    @if(now()->between($start, $end))
                        <span class="text-green-600 text-sm">Đang diễn ra</span>
                    @elseif(now()->lt($start))
                        <span class="text-yellow-600 text-sm">Sắp diễn ra</span>
                    @else
                        <span class="text-red-600 text-sm">Đã kết thúc</span>
                    @endif
                    </td>
                    <td class="p-2 flex gap-2" onclick="event.stopPropagation();">
                        <a href="{{ url('/admin/flash-sale/'.$sale->id.'/edit') }}" class="text-blue-500">Sửa</a>
                        <a href="/admin/flash-sale/{{ $sale->id }}/products" class="bg-indigo-500 text-white px-3 py-1 rounded">Thêm sản phẩm</a>
                        <form method="POST" action="{{ url('/admin/flash-sale/'.$sale->id) }}">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xoá?')" class="text-red-500">Xoá</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $flashSales->links() }}
        </div>
    </div>
</main>
@endsection
