@extends('template.admin')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Tổng Doanh Thu</div>
          <div class="text-xl font-bold">{{ number_format($totalSells, 0, ',', '.') }}₫</div>
          {{-- <div class="text-green-500 text-sm mt-2">+16.24%</div> --}}
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Tổng Đơn Hàng</div>
          <div class="text-xl font-bold">{{ number_format($totalOrders) }}</div>
          {{-- <div class="text-red-500 text-sm mt-2">-80.00%</div> --}}
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Khách Hàng</div>
          <div class="text-xl font-bold">{{ number_format($dailyVisitors) }}</div>
          {{-- <div class="text-blue-500 text-sm mt-2">+80.00%</div> --}}
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Daily Visitors</div>
          <div class="text-xl font-bold">$987.21M</div>
          {{-- <div class="text-yellow-500 text-sm mt-2">+80.00%</div> --}}
        </div>
      </div>

      <!-- Charts and Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
          <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold">Tổng Doanh Thu</h2>
            <div>
              <button class="px-2 py-1 text-sm sales-range-btn" data-range="7days">7 Ngày</button>
              <button class="px-2 py-1 text-sm sales-range-btn bg-yellow-400 text-white" data-range="monthly">Tháng</button>
            </div>
          </div>
          <canvas id="salesChart"></canvas>
        </div>

        <div class="bg-white p-4 shadow rounded">
          <h2 class="text-lg font-semibold mb-4">Thống Kê Hàng Tháng</h2>
          <canvas id="monthlyStatsChart"></canvas>
        </div>
      </div>
    </main>
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
      options: { responsive: true, plugins: { legend: { display: false } } }
    });

    function formatVNDate(dateStr) {
        const d = new Date(dateStr);
        return d.toLocaleDateString('vi-VN');
    }

    document.querySelectorAll('.sales-range-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        document.querySelectorAll('.sales-range-btn').forEach(b => b.classList.remove('bg-yellow-400', 'text-white'));
        this.classList.add('bg-yellow-400', 'text-white');
        if (this.dataset.range === '7days') {
          salesChart.data.labels = salesLabels7Days.map(formatVNDate);
          salesChart.data.datasets[0].data = salesData7Days;
        } else if (this.dataset.range === 'monthly') {
          salesChart.data.labels = salesLabels;
          salesChart.data.datasets[0].data = salesData;
        }
        salesChart.update();
      });
    });

    const monthlyStats = @json($monthlyStats);
    const months = [
    'Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6',
    'Tháng 7', 'Tháng 8', 'Tháng 9', 'Tháng 10', 'Tháng 11', 'Tháng 12',
    ];

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
        plugins: { legend: { display: true } }
    }
    });
</script>
@endsection
