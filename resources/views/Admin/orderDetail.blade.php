@extends('template.admin')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">🧾 Chi Tiết Đơn Hàng: {{ $orderInfo->vnp_TxnRef }}</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">👤 Thông Tin Khách Hàng</h3>
            <p><strong>Họ tên:</strong> {{ $orderInfo->user->name }}</p>
            <p><strong>Email:</strong> {{ $orderInfo->user->email }}</p>
            <p><strong>Điện thoại:</strong> {{ $orderInfo->user->phone ?? 'N/A' }}</p>
            <p><strong>Địa chỉ:</strong> {{ $orderInfo->address->adress ?? 'N/A' }}</p>
        </div>

        <div class="bg-white p-6 rounded-2xl shadow-md">
            <h3 class="text-xl font-semibold text-gray-700 mb-4">Thông Tin Đơn Hàng</h3>
            @if ($orderInfo->vnp_TxnRef)
                <p><strong>Mã giao dịch:</strong> {{ $orderInfo->vnp_TxnRef }}</p>
            @else
                <p><strong>Mã giao dịch:</strong> {{ $orderInfo->order_code }} </p>
            @endif
            <p><strong>Ngày đặt:</strong> {{ $orderInfo->created_at->format('d/m/Y H:i') }}</p>
            <p><strong>Trạng thái:</strong>
                @if($orderInfo->status === 'pending')
                    <span class="text-yellow-600 font-medium">Chờ xử lý</span>
                @elseif($orderInfo->status === 'processing')
                    <span class="text-blue-600 font-medium">Đang giao</span>
                @elseif($orderInfo->status === 'paid')
                    <span class="text-green-600 font-medium">Hoàn tất</span>
                @else
                    <span class="text-red-600 font-medium">Đã huỷ</span>
                @endif
            </p>
            <p><strong>Mã giảm giá:</strong> {{$orderInfo->coupons->name ?? 'Không áp dụng'}}</p>
            <p><strong>Phí vận chuyển:</strong> {{ number_format($orderInfo->shipping_fee)}}₫</p>
            <p><strong>Tổng tiền:</strong> <span class="text-lg font-semibold text-green-600">{{ number_format($orderInfo->total_price) }}₫</span></p>
        </div>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-4">Cập Nhật Trạng Thái Đơn Hàng</h3>
        <form action="{{url('/admin/order/update-status/'. $orderInfo->id) }}" method="POST" class="flex items-center gap-4">
            @csrf
            @method('PUT')
            <select name="status" class="border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-200 px-4 py-2">
                <option value="pending" {{ $orderInfo->status === 'pending' ? 'selected' : '' }}>🕒 Chờ xử lý</option>
                <option value="processing" {{ $orderInfo->status === 'processing' ? 'selected' : '' }}>🚚 Đang giao</option>
                <option value="paid" {{ $orderInfo->status === 'paid' ? 'selected' : '' }}>✅ Hoàn tất</option>
                <option value="cancelled" {{ $orderInfo->status === 'cancelled' ? 'selected' : '' }}>❌ Đã huỷ</option>
            </select>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 shadow">
                Lưu thay đổi
            </button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-2xl shadow-md mb-8">
        <h3 class="text-xl font-semibold text-gray-700 mb-6">🛒 Sản Phẩm</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full table-auto border-collapse">
                <thead class="bg-gray-100 text-gray-600 text-sm uppercase">
                    <tr>
                        <th class="p-3 text-left">Ảnh</th>
                        <th class="p-3 text-left">Sản phẩm</th>
                        <th class="p-3 text-left">Size</th>
                        <th class="p-3 text-center">Số lượng</th>
                        <th class="p-3 text-right">Đơn giá</th>
                        <th class="p-3 text-right">Thành tiền</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm">
                    @foreach($orderInfo->order_items as $item)
                        <tr class="border-t">
                            <td class="p-3">
                                @if(isset($item->variant->product->img[0]))
                                    <img src="{{ asset('img/' . $item->variant->product->img[0]->name) }}" alt="Ảnh" class="w-14 h-14 object-cover rounded-md border">
                                @else
                                    <span class="text-gray-400 italic">Không ảnh</span>
                                @endif
                            </td>
                            <td class="p-3">{{ $item->variant->product->name ?? '---' }}</td>
                            <td class="p-3">{{ $item->variant->size ?? '---' }}</td>
                            <td class="p-3 text-center">{{ $item->quantity }}</td>
                            <td class="p-3 text-right">{{ number_format($item->price) }}₫</td>
                            <td class="p-3 text-right font-semibold">{{ number_format($item->quantity * $item->price) }}₫</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="text-left">
        <a href="{{ url('/admin/order') }}" class="inline-flex items-center gap-2 bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded-md shadow">
            ← Quay lại danh sách
        </a>
    </div>

    <div class="text-right">
        <a href="{{ route('admin.order.invoice', $orderInfo->id) }}" target="_blank" class="btn btn-primary">In hóa đơn</a>
    </div>

    <a href="{{ route('admin.order.sendInvoice', $orderInfo->id) }}" class="btn btn-success">Gửi hóa đơn qua email</a>
</div>
@endsection
