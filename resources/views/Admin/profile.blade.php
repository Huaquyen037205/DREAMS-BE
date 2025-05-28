@extends('template.admin')
@section('content')
    <div class="max-w-4xl mx-auto mt-8 p-6 bg-white rounded-xl shadow-md">
  <div class="flex items-center space-x-6">
    <img class="w-24 h-24 rounded-full object-cover" src="https://i.pravatar.cc/150?img=3" alt="User Avatar">
    <div>
      <h2 class="text-2xl font-bold text-gray-800">Nguyễn Văn A</h2>
      <p class="text-gray-500">nguyenvana@example.com</p>
      <span class="inline-block mt-2 px-3 py-1 text-sm bg-green-100 text-green-700 rounded-full">
        Thành viên VIP
      </span>
    </div>
  </div>

  <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
      <label class="block text-gray-600 font-semibold mb-1">Số điện thoại</label>
      <p class="text-gray-800">+84 912 345 678</p>
    </div>
    <div>
      <label class="block text-gray-600 font-semibold mb-1">Giới tính</label>
      <p class="text-gray-800">Nam</p>
    </div>
    <div>
      <label class="block text-gray-600 font-semibold mb-1">Ngày sinh</label>
      <p class="text-gray-800">15/08/1995</p>
    </div>
    <div>
      <label class="block text-gray-600 font-semibold mb-1">Địa chỉ</label>
      <p class="text-gray-800">123 Lê Lợi, Quận 1, TP.HCM</p>
    </div>
  </div>

  <div class="mt-8 text-right">
    <button class="px-5 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
      Chỉnh sửa hồ sơ
    </button>
  </div>
</div>

@endsection
