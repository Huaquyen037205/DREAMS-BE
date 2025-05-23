<p>DREAMS, xin chào {{ $user->name }},</p>
<p>Bạn vừa yêu cầu đặt lại mật khẩu. Nhấn vào link dưới đây để đặt lại mật khẩu:</p>
<p>
    <a href="{{ url('/reset-password?token=' . $token . '&email=' . urlencode($user->email)) }}">
        Đặt lại mật khẩu
    </a>
</p>
<p>Nếu bạn không yêu cầu, hãy bỏ qua email này.</p>
