<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all of the user's notifications.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Lấy tất cả thông báo và phân trang
        $notifications = Auth::user()->notifications()->latest()->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Mark a specific notification as read.
     *
     * @param  \Illuminate\Notifications\DatabaseNotification  $notification
     * @return \Illuminate\Http\Response
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Đảm bảo người dùng chỉ có thể tương tác với thông báo của chính họ
        if (Auth::id() !== $notification->notifiable_id) {
            abort(403);
        }

        $notification->markAsRead();

        // Chuyển hướng người dùng đến URL được đính kèm trong thông báo
        return redirect($notification->data['url'] ?? route('dashboard'));
    }

    /**
     * Mark all of the user's unread notifications as read.
     *
     * @return \Illuminate\Http\Response
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'All notifications marked as read.');
    }
}
