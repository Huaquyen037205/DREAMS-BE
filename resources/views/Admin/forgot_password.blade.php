<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Quên Mật Khẩu</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-indigo-600 mb-6 text-center">Quên Mật Khẩu</h2>
        @if(session('error'))
        <div class="mb-4 text-red-600 text-center">
            {{ session('error') }}
        </div>
        @endif
        @if(session('status'))
            <div class="mb-4 text-green-600 text-center">
                {{ session('status') }}
            </div>
        @endif
    <form action="{{ url('/admin/forgotPassword') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Email</label>
        <input
          type="email"
          name="email"
          placeholder="Nhập email đã đăng ký"
          class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400"
          required
        >
      </div>

      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">
        Gửi liên kết đặt lại mật khẩu
      </button>
    </form>

    <div class="text-center mt-4">
      <a href="{{ url('admin/login') }}" class="text-sm text-indigo-600 hover:underline">Quay lại đăng nhập</a>
    </div>
  </div>
</body>
</html>
