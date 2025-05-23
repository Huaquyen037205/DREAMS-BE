<!DOCTYPE html>
<html>
<head>
    <title>Đăng Nhập</title>
</head>
<body>
    <h2>Đăng Nhập</h2>
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Mật khẩu:</label><br>
        <input type="password" name="password" required><br><br>

        <button type="submit">Đăng nhập</button>
    </form>

</body>
</html>
