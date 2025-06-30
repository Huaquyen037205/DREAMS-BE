@extends('template.admin')
@section('content')

{{-- Tổng quan --}}
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    @php
        $stats = [
            ['label' => 'Tổng Doanh Thu', 'value' => number_format($totalSells, 0, ',', '.') . '₫'],
            ['label' => 'Tổng Đơn Hàng', 'value' => number_format($totalOrders)],
            ['label' => 'Khách Hàng', 'value' => number_format($dailyVisitors)],
            ['label' => 'Tổng số sản phẩm', 'value' => number_format($totalProducts)],
        ];
    @endphp

    @foreach ($stats as $stat)
        <div class="bg-white p-4 shadow rounded h-full flex flex-col justify-center">
            <div class="text-gray-500 text-sm">{{ $stat['label'] }}</div>
            <div class="text-2xl font-bold mt-1">{{ $stat['value'] }}</div>
        </div>
    @endforeach
</div>

{{-- Charts --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="bg-white p-4 shadow rounded">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold">Tổng Doanh Thu</h2>
            <div class="flex gap-2">
                <button class="px-3 py-1 border rounded text-sm sales-range-btn" data-range="7days">7 Ngày</button>
                <button class="px-3 py-1 border rounded text-sm sales-range-btn bg-yellow-400 text-white" data-range="monthly">Tháng</button>
            </div>
        </div>
        <canvas id="salesChart" class="w-full h-64"></canvas>
    </div>

    <div class="bg-white p-4 shadow rounded">
        <h2 class="text-lg font-semibold mb-4">Thống Kê Hàng Tháng</h2>
        <canvas id="monthlyStatsChart" class="w-full h-64"></canvas>
    </div>
</div>

<div class="bg-white p-4 shadow rounded mt-6 max-h-[25rem] overflow-y-auto">
    <h2 class="text-lg font-semibold mb-4">Sản Phẩm Bán Chạy</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach($hotProduct as $product)
        <div class="border rounded p-2 flex flex-col items-center text-center text-sm">
            <img src="{{ asset('img/' . ($product->img[0]->name ?? 'no-image.png')) }}"
                 alt="{{ $product->name }}"
                 class="w-full h-20 object-contain rounded mb-2 bg-white">
            <div class="font-medium truncate w-full text-xs">{{ $product->name }}</div>
            <div class="text-gray-500 text-xs">Lượt mua: {{ $product->hot }}</div>
        </div>
        @endforeach
    </div>
</div>

<div class="bg-white p-4 shadow rounded mt-6">
    <h2 class="text-lg font-semibold mb-4">Đơn Hàng Mới Nhất</h2>
    <div class="overflow-x-auto">
        <table class="min-w-full text-sm table-auto">
            <thead>
                <tr class="bg-gray-100 text-gray-600">
                    <th class="px-3 py-2 text-left">Mã ĐH</th>
                    <th class="px-3 py-2 text-left">Khách hàng</th>
                    <th class="px-3 py-2 text-left">Tổng tiền</th>
                    <th class="px-3 py-2 text-left">Trạng thái</th>
                    <th class="px-3 py-2 text-left">Ngày tạo</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ordersToday as $order)
                <tr class="border-b hover:bg-gray-50">
                        <td class="px-3 py-2">
                            @if($order->order_code)
                                <a href="{{url('/admin/order/'. $order->id)}}">{{ $order->order_code }}</a>
                            @else
                                <a href="{{url('/admin/order/'. $order->id)}}">{{ $order->vnp_TxnRef }}</a>
                            @endif
                        </td>
                    <td class="px-3 py-2"><a href="{{url('/admin/order/'. $order->id)}}">{{ $order->user->name ?? '-' }}</a></td>
                    <td class="px-3 py-2">{{ number_format($order->total_price, 0, ',', '.') }}₫</td>
                    <td class="px-3 py-2">
                        @switch($order->status)
                            @case('pending') <span class="text-yellow-500">Chờ xử lý</span> @break
                            @case('processing') <span class="text-blue-500">Đang giao</span> @break
                            @case('paid') <span class="text-green-500">Đã thanh toán</span> @break
                            @case('cancelled') <span class="text-red-500">Đã hủy</span> @break
                            @default <span>{{ $order->status }}</span>
                        @endswitch
                    </td>
                    <td class="px-3 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $ordersToday->links() }}
    </div>
</div>

<script>
    const salesData = @json(array_values($salesByMonth));
    const salesLabels = @json(array_map(fn($m) => 'Tháng ' . $m, array_keys($salesByMonth)));

    const salesData7Days = @json(array_values($salesByDay));
    const salesLabels7Days = @json(array_keys($salesByDay));

    const salesCtx = document.getElementById('salesChart').getContext('2d');
    let salesChart = new Chart(salesCtx, {
        type: 'line',
        data: {
            labels: salesLabels,
            datasets: [{
                label: 'Doanh thu',
                data: salesData,
                borderColor: '#6366F1',
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    document.querySelectorAll('.sales-range-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.sales-range-btn').forEach(b => b.classList.remove('bg-yellow-400', 'text-white'));
            this.classList.add('bg-yellow-400', 'text-white');

            if (this.dataset.range === '7days') {
                salesChart.data.labels = salesLabels7Days.map(date => new Date(date).toLocaleDateString('vi-VN'));
                salesChart.data.datasets[0].data = salesData7Days;
            } else {
                salesChart.data.labels = salesLabels;
                salesChart.data.datasets[0].data = salesData;
            }

            salesChart.update();
        });
    });

    const monthlyStats = @json($monthlyStats);
    const months = ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
        'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12'];

    const statsCtx = document.getElementById('monthlyStatsChart').getContext('2d');
    new Chart(statsCtx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Doanh Thu',
                    backgroundColor: '#facc15',
                    data: monthlyStats.profit,
                },
                {
                    label: 'Trả Hàng',
                    backgroundColor: '#818cf8',
                    data: monthlyStats.refunds,
                },
                {
                    label: 'Chi Tiêu',
                    backgroundColor: '#34d399',
                    data: monthlyStats.expenses,
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: true }
            }
        }
    });
</script>

@endsection
