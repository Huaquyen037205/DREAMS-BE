@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Danh Sách Mã Giảm Giá</h2>
        <a href="{{ route('discounts.create') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
            + Mã Giảm Giá
        </a>
    </div>

    <form method="GET" action="{{ route('discounts.index') }}" class="mb-4 flex items-center gap-2">
        <input type="text" name="keyword" placeholder="Tìm mã giảm giá..." class="border px-3 py-2 rounded w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">STT</th>
                <th class="py-2 px-4 border">Mã Code</th>
                <th class="py-2 px-4 border">Phần Trăm</th>
                <th class="py-2 px-4 border">Ngày Bắt Đầu</th>
                <th class="py-2 px-4 border">Ngày Kết Thúc</th>
                <th class="py-2 px-4 border">Tình Trạng</th>
                <th class="py-2 px-4 border">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($discounts as $index => $discount)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                    <td class="py-2 px-4 border">{{ $discount->code }}</td>
                    <td class="py-2 px-4 border">{{ $discount->percentage }}%</td>
                    <td class="py-2 px-4 border">{{ $discount->start_day }}</td>
                    <td class="py-2 px-4 border">{{ $discount->end_day }}</td>
                    <td class="py-2 px-4 border">
                        @if(now()->between($discount->start_day, $discount->end_day))
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Đang hoạt động</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Hết hạn</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border flex justify-center gap-2">
                        <a href="{{ route('discounts.edit', $discount->id) }}" class="bg-green-500 text-white px-2 py-1 rounded">✏️</a>
                        <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xoá?')">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded">🗑️</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
