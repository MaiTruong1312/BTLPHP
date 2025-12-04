<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class NotificationComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if (Auth::check()) {
            $user = Auth::user();
            // Lấy 5 thông báo gần nhất (cả đã đọc và chưa đọc) để hiển thị trong dropdown
            $notifications = $user->notifications()->latest()->take(5)->get();
            // Đếm tổng số thông báo chưa đọc để hiển thị con số trên chuông
            $unreadNotificationsCount = $user->unreadNotifications()->count();

            $view->with(compact('notifications', 'unreadNotificationsCount'));
        } else {
            // Cung cấp giá trị mặc định nếu người dùng chưa đăng nhập
            $view->with(['notifications' => collect(), 'unreadNotificationsCount' => 0]);
        }
    }
}
