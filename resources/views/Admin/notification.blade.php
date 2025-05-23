
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Liên kết đã được gửi</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-md rounded-lg p-8 w-full max-w-md">
    <h1 class="text-3xl font-extrabold text-indigo-600 text-center mb-4">DREAMS</h1>

    <h2 class="text-xl font-semibold text-gray-800 text-center mb-2">
        Chúng tôi nhận thấy yêu cầu đặt lại mật khẩu từ bạn.
    </h2>

    <p class="text-gray-600 text-center mb-6">
        Đây là mật khẩu của bạn:  {{ $newPassword }}
    </p>

    <h2 class="text-xl font-semibold text-gray-800 text-center mb-2">
        Khi bạn đã đăng nhập, hãy thay đổi mật khẩu của bạn. DREAMS xin cảm ơn.
    </h2>

    <a href="{{ url('admin/login') }}"
       class="block text-center bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition duration-200">
      Quay lại đăng nhập
    </a>

  </div>
</body>
</html>

