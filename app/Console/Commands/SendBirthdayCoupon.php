<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class SendBirthdayCoupon extends Command
{
    protected $signature = 'coupon:birthday';
    protected $description = 'Gửi mã giảm giá sinh nhật cho user';

    public function handle()
    {
        $this->info('🔍 Đang kiểm tra user có sinh nhật hôm nay...');

        $today = now()->format('m-d');

        $users = User::whereNotNull('day_of_birth')
            ->whereRaw("DATE_FORMAT(day_of_birth, '%m-%d') = ?", [$today])
            ->get();

        if ($users->isEmpty()) {
            $this->info('🚫 Không có user nào sinh nhật hôm nay.');
            return;
        }

        foreach ($users as $user) {
            $code = 'BDAY' . strtoupper(Str::limit(Str::slug($user->name, ''), 3, '')) . rand(1000, 9999);

            $coupon = Coupon::create([
                'code' => $code,
                'discount_value' => 100000,
                'expiry_date' => now()->addDays(7),
                'is_public' => 1
            ]);

            DB::table('coupons_user')->insert([
                'user_id' => $user->id,
                'coupon_id' => $coupon->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            Mail::raw(
                "🎉 Chúc mừng sinh nhật {$user->name}!\n\nBạn nhận được mã giảm giá đặc biệt: {$code}.\nTrị giá: {$coupon->discount_value}đ\nHạn dùng đến: {$coupon->expiry_date->format('d/m/Y')}\n\nChúc bạn một ngày tuyệt vời!",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('🎂 Quà sinh nhật dành cho bạn!');
                }
            );

            $this->info("✅ Đã gửi mã {$code} cho {$user->email}");
        }

        $this->info('🎁 Hoàn tất gửi mã sinh nhật cho tất cả user hôm nay.');
    }
}
