<h2>HÓA ĐƠN ĐƠN HÀNG :{{ $order->vnp_TxnRef }}</h2>
<h2>Mã Đơn Hàng :{{ $order->id }}</h2>
<p><strong>Khách hàng:</strong> {{ $order->user->name }}</p>
<p><strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
{{-- <p><strong>Địa chỉ:</strong> {{ $order->address }}</p> --}}
<table border="1" cellpadding="5" cellspacing="0" width="100%">
    <tr>
        <th>Sản phẩm</th>
        <th>Số lượng</th>
        <th>Giá</th>
        <th>Thành tiền</th>
    </tr>
    @foreach($order->order_items as $item)
    <tr>
        <td>{{ $item->variant->product->name ?? '' }}</td>
        <td>{{ $item->quantity }}</td>
        <td>{{ number_format($item->price) }}₫</td>
        <td>{{ number_format($item->price * $item->quantity) }}₫</td>
    </tr>
    @endforeach
</table>
<p><strong>Tổng cộng:</strong> {{ number_format($order->total_price) }}₫</p>
