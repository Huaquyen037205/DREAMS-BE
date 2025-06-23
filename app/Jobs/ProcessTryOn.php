<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessTryOn implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public string $imagePath;

    public function __construct($imagePath)
    {
        $this->imagePath = $imagePath;
    }

    public function handle(): void
    {
        Log::info("🔧 Đang xử lý ảnh trong Job: " . $this->imagePath);

        // Demo giả xử lý
        sleep(2);
        Log::info("✅ Xử lý ảnh hoàn tất: " . $this->imagePath);
    }
}
