@extends('template.admin')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-2xl font-bold">Danh Sách Đơn Hàng</h2>
    </div>

    <form method="GET" action="/admin/search/order" class="mb-4 flex items-center gap-2">
        <input type="text" name="keyword" placeholder="Tìm theo mã đơn hàng hoặc email..." class="border px-3 py-2 rounded w-1/3">
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Tìm kiếm</button>
    </form>

    <table class="min-w-full bg-white border rounded">
        <thead class="bg-gray-100">
            <tr class="bg-gray-100 text-gray-600 text-sm uppercase">
                <th class="p-2">STT</th>
                <th class="p-2">Mã Đơn</th>
                <th class="p-2">Khách Hàng</th>
                <th class="p-2">Email</th>
                <th class="p-2">Tổng Tiền</th>
                <th class="p-2">Trạng Thái</th>
                <th class="p-2">Ngày Đặt</th>
                <th class="p-2">Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
                <tr class="text-center">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $order->vnp_TxnRef }}</td>
                    <td class="p-2">{{ $order->user->name }}</td>
                    <td class="p-2">{{ $order->user->email }}</td>
                    <td class="p-2">{{ number_format($order->total_price) }}₫</td>
                    <td class="p-2">
                        @if($order->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-sm">Chờ xử lý</span>
                        @elseif($order->status === 'processing')
                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-sm">Đang giao</span>
                        @elseif($order->status === 'paid')
                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-sm">Hoàn tất</span>
                        @else
                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-sm">Đã huỷ</span>
                        @endif
                    </td>
                    <td class="p-2 border">{{ $order->created_at->format('d/m/Y') }}</td>
                    <td class="p-2 border flex justify-center gap-2">
                        <a href="{{url('/admin/order/'. $order->id)}}" class="bg-green-100 text-green-500 px-2 py-1 rounded"><i class="ph ph-eye"></i></a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
     <div class="mt-4">
        {{ $orders->links() }}
    </div>
</div>
@endsection
