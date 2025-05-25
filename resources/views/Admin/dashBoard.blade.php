@extends('template.admin')
@section('content')
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Total Sells</div>
          <div class="text-xl font-bold">$654.66k</div>
          <div class="text-green-500 text-sm mt-2">+16.24%</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Total Orders</div>
          <div class="text-xl font-bold">$854.66k</div>
          <div class="text-red-500 text-sm mt-2">-80.00%</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Daily Visitors</div>
          <div class="text-xl font-bold">$987.21M</div>
          <div class="text-blue-500 text-sm mt-2">+80.00%</div>
        </div>
        <div class="bg-white p-4 shadow rounded">
          <div class="text-gray-500">Daily Visitors</div>
          <div class="text-xl font-bold">$987.21M</div>
          <div class="text-yellow-500 text-sm mt-2">+80.00%</div>
        </div>
      </div>

      <!-- Charts and Stats -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div class="bg-white p-4 shadow rounded">
          <div class="flex justify-between mb-4">
            <h2 class="text-lg font-semibold">Total Sales</h2>
            <div>
              <button class="px-2 py-1 text-sm">7 Days</button>
              <button class="px-2 py-1 text-sm bg-yellow-400 text-white rounded">Monthly</button>
              <button class="px-2 py-1 text-sm">Yearly</button>
            </div>
          </div>
          <canvas id="salesChart"></canvas>
        </div>

        <div class="bg-white p-4 shadow rounded">
          <h2 class="text-lg font-semibold mb-4">Monthly Statistics</h2>
          <canvas id="statsChart"></canvas>
        </div>
      </div>
    </main>
  </div>

  <script>
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    new Chart(salesCtx, {
      type: 'line',
      data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
          label: 'Sales',
          data: [20, 18, 30, 45, 55, 65, 50, 60, 55, 50, 35, 40],
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

    const statsCtx = document.getElementById('statsChart').getContext('2d');
    new Chart(statsCtx, {
      type: 'bar',
      data: {
        labels: [...Array(12).keys()].map(i => `Week ${i + 1}`),
        datasets: [
          { label: 'Profit', backgroundColor: '#FACC15', data: [60, 70, 80, 75, 90, 95, 85, 100, 95, 85, 90, 100] },
          { label: 'Refunds', backgroundColor: '#818CF8', data: [40, 50, 60, 55, 70, 65, 60, 80, 70, 75, 60, 70] },
          { label: 'Expenses', backgroundColor: '#34D399', data: [50, 60, 70, 65, 85, 80, 75, 90, 85, 80, 70, 85] },
        ]
      },
      options: {
        responsive: true,
        plugins: {
          legend: { position: 'top' }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100
          }
        }
      }
    });
  </script>
@endsection
