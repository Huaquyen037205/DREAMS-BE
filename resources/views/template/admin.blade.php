<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard UI</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/@phosphor-icons/web"></script>
</head>
<body class="bg-gray-100 font-sans">
  <div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg overflow-y-auto">
      <div class="p-6 text-2xl font-bold text-purple-600 flex justify-center">
        <a href="/admin/dashboard">
            <img src="{{ asset('img/dr2025.png') }}" alt="" class="w-32 h-auto">
        </a>
      </div>
      <ul>
        <a href="/admin/dashboard">
            <li class="px-6 py-3 bg-purple {{ request()->is('admin/dashboard') ? 'bg-purple-100 text-purple-700' : '' }} text-gray-700 font-medium flex items-center gap-2">
            <i class="ph ph-gauge"></i> Dashboard
            </li>
        </a>
        {{-- <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
          <i class="ph ph-storefront"></i> Vendors
        </li> --}}

        <div class="group">
          <div onclick="toggleSubMenu('users-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('admin/user*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
            <a href="/admin/user/list"><i class="ph ph-users"></i> Người dùng </a>
          </div>
          <div id="users-submenu" class="hidden flex-col">
            {{-- <a href="/admin/user/list" class="block py-2 px-12 hover:text-indigo-600">Danh sách người dùng</a>
            <a href="" class="block py-2 px-12 hover:text-indigo-600">Cập nhật người dùng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Thêm người dùng mới</a> --}}
          </div>
        </div>

        <div class="group">
          <div onclick="toggleSubMenu('products-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('admin/product/list*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
               <a href="/admin/product/list"><i class="ph ph-package"></i> Sản Phẩm </a>
          </div>
          <div id="products-submenu" class="hidden flex-col">
            {{-- <a href="/admin/product/list" class="block py-2 px-12 hover:text-indigo-600">Danh sách sản phẩm</a> --}}
            {{-- <a href="/admin/product/edit/{id}" class="block py-2 px-12 hover:text-indigo-600">Cập nhật sản phẩm</a> --}}
            {{-- <a href="/admin/product/add" class="block py-2 px-12 hover:text-indigo-600">Thêm sản phẩm mới</a> --}}
          </div>
        </div>

        <div class="group">
          <div onclick="toggleSubMenu('orders-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('admin/order*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
            <a href="/admin/order"><i class="ph ph-truck"></i> Đơn Hàng</a>
          </div>
          {{-- <div id="orders-submenu" class="hidden flex-col">
            <a href="orderList.html" class="block py-2 px-12 hover:text-indigo-600">Danh sách đơn hàng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Cập nhật đơn hàng</a>
          </div> --}}
        </div>

        <!-- Mã Giảm giá -->
        <div class="group">
          <div onclick="toggleSubMenu('discounts-submenu')" class="py-2.5 px-6 text-gray-700 hover:bg-purple-50 {{ request()->is('admin/coupons*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
            <i class="ph ph-percent"></i> Mã Giảm giá <i class="ph ph-caret-down ml-auto"></i>
          </div>
          <div id="discounts-submenu" class="hidden flex-col">
            <a href="{{ url('/admin/coupons') }}" class="block py-2 px-12 hover:text-indigo-600 hover:bg-purple-50">Danh sách mã giảm giá</a>
            <a href="{{ url('/admin/coupons/create') }}" class="block py-2 px-12 hover:text-indigo-600 hover:bg-purple-50">Thêm mã giảm giá</a>
          </div>
        </div>

        <!-- Chương trình giảm giá -->
        <div class="group">
          <div onclick="toggleSubMenu('disscounts-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('admin/discount*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
            <a href="/admin/discount"><i class="ph ph-tag"></i> Chương trình giảm giá</a>
          </div>
          {{-- <div id="orders-submenu" class="hidden flex-col">
            <a href="orderList.html" class="block py-2 px-12 hover:text-indigo-600">Danh sách đơn hàng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Cập nhật đơn hàng</a>
          </div> --}}
        </div>

        <!-- Flash-Sale -->
        <div class="group">
            <div onclick="toggleSubMenu('flashsale-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('admin/flash-sale*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
                <i class="ph ph-lightning"></i> Flash-Sale <i class="ph ph-caret-down ml-auto"></i>
            </div>
            <div id="flashsale-submenu" class="hidden flex-col">
                <a href="/admin/flash-sale" class="block py-2 px-12 hover:bg-purple-50 hover:text-indigo-600">Danh sách FlSale</a>
                <a href="/admin/flash-sale/create" class="block py-2 px-12 hover:bg-purple-50 hover:text-indigo-600">Thêm chương trình FlSale</a>
                {{-- <a href="/admin/flash-sale/{{ $flashSale->id }}/products">Thêm sản phẩm</a> --}}
            </div>
        </div>

        <a href="{{ url('/admin/categories') }}" class="px-6 py-3 hover:bg-purple-50 {{ request()->routeIs('categories.*') ? 'bg-purple-100 text-purple-700' : '' }} flex items-center gap-2 text-gray-700 font-semibold">
            <i class="ph ph-grid-four"></i> Danh Mục Sản Phẩm
        </a>

         <div class="group">
          <div onclick="toggleSubMenu('notification-submenu')" class="py-2.5 px-6 hover:bg-purple-50 {{ request()->is('/admin/notifications*') ? 'bg-purple-100 text-purple-700' : 'text-gray-700' }} font-medium cursor-pointer flex items-center gap-2">
            <a href="/admin/notifications"><i class="ph ph-bell"></i> Thông Báo</a>
          </div>
          {{-- <div id="orders-submenu" class="hidden flex-col">
            <a href="orderList.html" class="block py-2 px-12 hover:text-indigo-600">Danh sách đơn hàng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Cập nhật đơn hàng</a>
          </div> --}}
        </div>
        <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
            <a href="/admin/posts/manage"><i class="ph ph-chat-circle-text"></i> Tin Tức</a>
        </li>
        <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
            <i class="ph ph-copy"></i> Pages
        </li>
      </ul>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">
      <!-- Top Bar -->
    <div class="flex justify-between items-center mb-6 relative">
  <!-- Left: Search or Logo -->
  <div class="flex items-center gap-4">
    <span class="bg-purple-200 text-purple-800 rounded-full px-3 py-1 text-sm">
      {{ (Auth::user()->name ?? 'Admin DREAMS')  . ', ADMIN DREAMS'}}
    </span>
  </div>

  <!-- Right: Notifications + Logout -->
  <div class="flex items-center gap-4 relative">
    <!-- Notification Bell -->
    <div class="relative">
      <button onclick="toggleNotificationDropdown()" class="relative cursor-pointer hover:text-purple-600 text-gray-600 focus:outline-none">
        <i class="ph ph-bell text-2xl"></i>
            @if($unreadCount > 0)
                <span class="absolute -top-1 -right-1 flex items-center justify-center h-5 w-5 rounded-full bg-red-500 text-white text-xs font-bold border-2 border-white">
                    {{ $unreadCount > 9 ? '9+' : $unreadCount }}
                </span>
            @endif
      </button>

      <!-- Dropdown -->
      <div id="notification-dropdown" class="hidden absolute right-0 mt-3 w-72 bg-white shadow-lg rounded-lg ring-1 ring-gray-200 z-50">
        <div class="p-4 font-semibold text-gray-700 border-b">🔔 Thông báo</div>
            <ul class="max-h-60 overflow-y-auto divide-y divide-gray-100">
                @forelse($notifications as $noti)
                    <li class="px-4 py-2 hover:bg-gray-50 text-sm cursor-pointer">
                        {!! $noti->message !!}
                    </li>
                @empty
                    <li class="px-4 py-2 text-sm text-gray-400">Không có thông báo</li>
                @endforelse
            </ul>
        <div class="p-2 text-center text-sm text-indigo-600 hover:underline hover:bg-gray-50 cursor-pointer">
          <a href="/admin/notifications">Xem tất cả</a>
        </div>
      </div>
    </div>

    <!-- Logout -->
    <form id="logout-form" action="{{ url('/logout') }}" method="POST">
      @csrf
      <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600 transition">
        Đăng xuất
      </button>
    </form>
  </div>
</div>
      <!-- Stats Cards -->
      @yield('content')
    </main>
  </div>

<script>
function toggleSubMenu(id) {
    const submenu = document.getElementById(id);
    if (submenu) {
        submenu.classList.toggle('hidden');
    }
}
</script>

</body>
<script>
    function toggleSubMenu(id) {
    const submenu = document.getElementById(id);
    if (submenu) {
        submenu.classList.toggle('hidden');
    }
}

  function toggleNotificationDropdown() {
    const dropdown = document.getElementById('notification-dropdown');
    dropdown.classList.toggle('hidden');

    if (!dropdown.classList.contains('hidden')) {
        fetch("{{ route('admin.notifications.read') }}", {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                "Accept": "application/json"
            }
        }).then(res => {
            if (res.ok) {
                document.querySelectorAll('.ph-bell + span').forEach(e => e.style.display = 'none');
            }
        });
    }
}
</script>
</html>
