@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Danh Sách Đơn Hàng</h2>
    </div>

    <form method="GET" action="{{ route('orders.index') }}" class="mb-4 flex items-center gap-2">
        <input type="text" name="keyword" placeholder="Tìm theo mã đơn hàng hoặc email..." class="border px-3 py-2 rounded w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr>
                <th class="py-2 px-4 border">STT</th>
                <th class="py-2 px-4 border">Mã Đơn</th>
                <th class="py-2 px-4 border">Khách Hàng</th>
                <th class="py-2 px-4 border">Email</th>
                <th class="py-2 px-4 border">Tổng Tiền</th>
                <th class="py-2 px-4 border">Trạng Thái</th>
                <th class="py-2 px-4 border">Ngày Đặt</th>
                <th class="py-2 px-4 border">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
                <tr class="text-center">
                    <td class="py-2 px-4 border">{{ $index + 1 }}</td>
                    <td class="py-2 px-4 border">{{ $order->order_code }}</td>
                    <td class="py-2 px-4 border">{{ $order->customer_name }}</td>
                    <td class="py-2 px-4 border">{{ $order->email }}</td>
                    <td class="py-2 px-4 border">{{ number_format($order->total_price) }}₫</td>
                    <td class="py-2 px-4 border">
                        @if($order->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Chờ xử lý</span>
                        @elseif($order->status === 'processing')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm">Đang giao</span>
                        @elseif($order->status === 'completed')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Hoàn tất</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Đã huỷ</span>
                        @endif
                    </td>
                    <td class="py-2 px-4 border">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="py-2 px-4 border flex justify-center gap-2">
                        <a href="{{ route('orders.show', $order->id) }}" class="bg-green-500 text-white px-2 py-1 rounded">🔍</a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Bạn chắc chắn muốn xoá đơn này?')">
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
