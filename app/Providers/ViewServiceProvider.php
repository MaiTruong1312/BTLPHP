<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\NotificationComposer;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Sử dụng composer cho component notification-dropdown
        // Tên view 'components.notification-dropdown' tương ứng với file:
        // resources/views/components/notification-dropdown.blade.php
        View::composer('components.notification-dropdown', NotificationComposer::class);
    }
}
