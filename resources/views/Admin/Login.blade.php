<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Đăng Nhập</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold text-indigo-600 mb-6 text-center">Đăng Nhập</h2>

    @if(session('error'))
        <div class="mb-4 text-red-600 text-center">
            {{ session('error') }}
        </div>
    @endif
    <form action="{{ url('admin/login') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Email</label>
        <input type="email" name="email" class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
      </div>
      <div class="mb-4">
        <label class="block text-gray-700 mb-1">Mật Khẩu</label>
        <input type="password" name="password" class="w-full border border-gray-300 px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-indigo-400" required>
      </div>
      <div class="text-right mb-4">
        <a href="{{ url('/admin/email-forgot-password')}}" class="text-sm text-indigo-600 hover:underline">Quên mật khẩu?</a>
      </div>
      <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded hover:bg-indigo-700">Đăng Nhập</button>
    </form>
    <p class="text-center text-sm text-gray-600 mt-4">
      <a href="/admin/change-password" class="text-indigo-600 hover:underline">Đổi mật khẩu</a>
    </p>
  </div>
</body>
</html>
