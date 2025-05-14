<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Đăng ký Admin</title>
</head>
<body>
    <h2>Form Đăng Ký Admin</h2>
   <form action="/api/admin/register" method="POST">
    @csrf
    <label for="name">Họ tên:</label><br>
    <input type="text" id="name" name="name" required><br><br>

    <label for="phone">Số điện thoại:</label><br>
    <input type="text" id="phone" name="phone"><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" required><br><br>

    <label for="password">Mật khẩu:</label><br>
    <input type="password" id="password" name="password" required><br><br>

    <label for="password_confirmation">Xác nhận mật khẩu:</label><br>
    <input type="password" id="password_confirmation" name="password_confirmation" required><br><br>

    <button type="submit">Đăng ký</button>
</form>
</body>
</html>
