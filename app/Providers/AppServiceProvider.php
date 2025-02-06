<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        // Chuyển tất cả URL thành HTTPS khi ứng dụng chạy trên môi trường sản xuất
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
