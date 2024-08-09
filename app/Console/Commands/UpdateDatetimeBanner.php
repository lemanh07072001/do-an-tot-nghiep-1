<?php

namespace App\Console\Commands;

use App\Models\Banner;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateDatetimeBanner extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-datetime-banner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cập nhật trạng thái hết hạn cho các bản ghi có ngày kết thúc nhỏ hơn hoặc bằng ngày hôm nay';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();
        Banner::where('date_end', '<=', $today)
            ->update(['is_expired' => 'false']);
    }
}
