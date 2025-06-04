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
   <div class="p-6 text-2xl font-bold text-purple-600">
        <a href="/admin/dashboard"> DREAMS  </a></div>
      <nav class="mt-8">

      <ul>
        <a href="/admin/dashboard" >
            <li class="px-6 py-3 bg-purple-100 text-purple-700 flex items-center gap-2">
            <i class="ph ph-gauge"></i> Dashboard
            </li>
        </a>
        <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
          <i class="ph ph-storefront"></i> Vendors
        </li>

        <div class="group">
          <div onclick="toggleSubMenu('users-submenu')" class="py-2.5 px-6 text-gray-700 font-medium cursor-pointer flex items-center gap-2">
            <a href="/admin/user/list"><i class="ph ph-users"></i> Người dùng </a>
          </div>
          <div id="users-submenu" class="hidden flex-col">
            {{-- <a href="/admin/user/list" class="block py-2 px-12 hover:text-indigo-600">Danh sách người dùng</a>
            <a href="" class="block py-2 px-12 hover:text-indigo-600">Cập nhật người dùng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Thêm người dùng mới</a> --}}
          </div>
        </div>

        <div class="group">
          <div onclick="toggleSubMenu('products-submenu')" class="py-2.5 px-6 text-gray-700 font-medium cursor-pointer flex items-center gap-2">
               <a href="/admin/product/list"><i class="ph ph-package"></i> Sản Phẩm </a>
          </div>
          <div id="products-submenu" class="hidden flex-col">
            {{-- <a href="/admin/product/list" class="block py-2 px-12 hover:text-indigo-600">Danh sách sản phẩm</a> --}}
            {{-- <a href="/admin/product/edit/{id}" class="block py-2 px-12 hover:text-indigo-600">Cập nhật sản phẩm</a> --}}
            {{-- <a href="/admin/product/add" class="block py-2 px-12 hover:text-indigo-600">Thêm sản phẩm mới</a> --}}
          </div>
        </div>

        <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
          <i class="ph ph-heart"></i> Wishlist
        </li>

        <div class="group">
          <div onclick="toggleSubMenu('orders-submenu')" class="py-2.5 px-6 text-gray-700 font-medium cursor-pointer flex items-center gap-2">
            <i class="ph ph-truck"></i> Đơn Hàng
          </div>
          {{-- <div id="orders-submenu" class="hidden flex-col">
            <a href="orderList.html" class="block py-2 px-12 hover:text-indigo-600">Danh sách đơn hàng</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Cập nhật đơn hàng</a>
          </div> --}}
        </div>

        <div class="group">
          <div onclick="toggleSubMenu('discounts-submenu')" class="py-2.5 px-6 text-gray-700 font-medium cursor-pointer flex items-center gap-2">
            <i class="ph ph-percent"></i> Mã Giảm giá <i class="ph ph-caret-down ml-auto"></i>
          </div>
          <div id="discounts-submenu" class="hidden flex-col">
            <a href="variant.html" class="block py-2 px-12 hover:text-indigo-600">Danh sách mã giảm giá</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Cập nhật mã giảm giá</a>
            <a href="#" class="block py-2 px-12 hover:text-indigo-600">Thêm mã giảm giá</a>
          </div>
        </div>

        <div class="group">
            <div onclick="toggleSubMenu('flashsale-submenu')" class="py-2.5 px-6 text-gray-700 font-medium cursor-pointer flex items-center gap-2">
                <i class="ph ph-lightning"></i> Flash-Sale <i class="ph ph-caret-down ml-auto"></i>
            </div>
            <div id="flashsale-submenu" class="hidden flex-col">
                <a href="/admin/flash-sale" class="block py-2 px-12 hover:text-indigo-600">Danh sách FlSale</a>
                <a href="/admin/flash-sale/create" class="block py-2 px-12 hover:text-indigo-600">Thêm chương trình FlSale</a>
                {{-- <a href="/admin/flash-sale/{{ $flashSale->id }}/products">Thêm sản phẩm</a> --}}
            </div>
        </div>

        <a href="{{ url('/admin/categories') }}" class="px-6 py-3 hover:bg-purple-50 flex items-center gap-2 text-gray-700 font-semibold">
            <i class="ph ph-grid-four"></i> Danh Mục Sản Phẩm
        </a>

          <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
            <i class="ph ph-gear"></i> Cài đặt
          </li>
          <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
            <a href="/admin/message"><i class="ph ph-chat-circle-text"></i> Tin nhắn</a>
          </li>
          <li class="px-6 py-3 hover:bg-purple-50 cursor-pointer flex items-center gap-2">
            <i class="ph ph-copy"></i> Pages
          </li>
        </ul>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">
      <!-- Top Bar -->
      <div class="flex justify-between items-center mb-6">
        <input type="text" placeholder="Search" class="px-4 py-2 border rounded-md w-1/3" />
        <div class="flex items-center space-x-4">
          <span class="bg-purple-200 text-purple-800 rounded-full px-3 py-1 text-sm">Admin DREAMS</span>
        </div>
      </div>

        <div class="flex justify-between items-center mb-6">
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="bg-indigo-500 text-white px-4 py-2 rounded hover:bg-indigo-600">
                    Đăng xuất
                </button>
            </form>
        </div>

      <!-- Stats Cards -->
      @yield('content')



</body>
<script>

    function toggleSubMenu(id) {
        const submenu = document.getElementById(id);
        submenu.classList.toggle('hidden');
    }


</script>
</html>
