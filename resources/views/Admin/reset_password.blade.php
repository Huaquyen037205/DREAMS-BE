<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Change Password - DREAMS</title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen">

  <div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-md">
    <div class="text-center">
      <h1 class="text-3xl font-bold text-purple-600 mb-2">DREAMS</h1>
      <p class="text-gray-600 mb-6">Đổi mật khẩu</p>
    </div>

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
    <form action="/admin/change-password" method="POST" class="space-y-4">
        @csrf
        <div>
            <label for="oldPassword" class="block text-gray-700 font-medium mb-1">Mật khẩu cũ</label>
            <input type="password" id="oldPassword" name="old_password" required placeholder="Nhập mật khẩu cũ"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
        </div>

        <div>
            <label for="newPassword" class="block text-gray-700 font-medium mb-1">Mật khẩu mới</label>
            <input type="password" id="newPassword" name="new_password" required placeholder="Nhập mật khẩu mới"
            class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-purple-500" />
        </div>

        <button type="submit"
            class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 rounded-full transition">
            Đổi mật khẩu
        </button>
    </form>

    <div class="mt-6 text-center">
      <a href="/admin/dashboar" class="text-sm text-purple-500 hover:underline">← Quay lại bảng điều khiển</a>
    </div>
  </div>

</body>

</html>
