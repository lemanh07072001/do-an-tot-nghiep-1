<?php

namespace App\Providers;

use App\Models\Setting;
use App\Listeners\SendMessage;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            SendMessage::class
        );

        $email = Setting::where('setting_key', 'setting_email_address')->value('setting_value')??'';
        $password = Setting::where('setting_key', 'setting_passEmail')->value('setting_value')??'';

        if ($email ) {
            // Đặt các giá trị từ database vào cấu hình của ứng dụng
            Config::set('mail.username', $email);
            Config::set('mail.password', $password);
        }
    }
}
