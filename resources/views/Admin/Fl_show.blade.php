{{-- filepath: resources/views/Admin/Fl_show.blade.php --}}
@extends('template.admin')
@section('content')
<main class="flex-1 p-6 overflow-y-auto">
    <div class="text-2xl font-semibold mb-6">Chi Tiết Chương Trình Flash Sale</div>

    <div class="bg-white p-4 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-2">{{ $flashSale->name }}</h2>
        <div><b>Thời gian bắt đầu:</b> {{ $flashSale->start_time }}</div>
        <div><b>Thời gian kết thúc:</b> {{ $flashSale->end_time }}</div>
    </div>

    <div class="bg-white p-4 rounded shadow">
        <h3 class="text-lg font-semibold mb-4">Danh sách sản phẩm trong chương trình</h3>
        <table class="min-w-full table-auto text-left">
            <thead>
                <tr>
                    <th class="p-2">Tên sản phẩm</th>
                    <th class="p-2">Size</th>
                    <th class="p-2">Giá Flash Sale</th>
                    <th class="p-2">Số lượng</th>
                    <th class="p-2">Đã bán</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($flashSale->variants as $item)
                    <tr>
                        <td class="p-2">{{ $item->variant->product->name ?? '' }}</td>
                        <td class="p-2">{{ $item->variant->size ?? '' }}</td>
                        <td class="p-2">{{ number_format($item->sale_price) }}</td>
                        <td class="p-2">{{ $item->flash_quantity }}</td>
                        <td class="p-2">{{ $item->flash_sold ?? 0 }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
