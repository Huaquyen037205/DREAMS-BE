<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Coupon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SendBirthdayCoupon extends Command
{
    protected $signature = 'coupon:birthday';
    protected $description = 'Gửi mã giảm giá sinh nhật cho user';

    public function handle()
    {
        $this->info('Đang kiểm tra user sinh nhật hôm nay...');

        $today = now()->format('m-d');
        $users = User::whereNotNull('day_of_birth')
            ->whereRaw("DATE_FORMAT(day_of_birth, '%m-%d') = ?", [$today])
            ->get();

        if ($users->isEmpty()) {
            $this->info('Không có user nào sinh nhật hôm nay.');
            return;
        }

        foreach ($users as $user) {
            $code = 'BDAY' . strtoupper(substr($user->name, 0, 3)) . rand(1000, 9999);
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
                "Chúc mừng sinh nhật {$user->name}! Mã giảm giá của bạn: {$code}, trị giá {$coupon->discount_value}, hạn dùng đến {$coupon->expiry_date}.",
                function ($message) use ($user) {
                    $message->to($user->email)
                        ->subject('Chúc mừng sinh nhật! Nhận mã giảm giá đặc biệt');
                }
            );
            $this->info("Đã gửi mã $code cho user {$user->email}");
        }
        $this->info('Đã hoàn thành gửi mã giảm giá sinh nhật!');
    }
}
