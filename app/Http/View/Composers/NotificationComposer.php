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
            // Get the 5 most recent unread notifications for the dropdown
            $unreadNotifications = $user->unreadNotifications()->latest()->take(5)->get();
            // Count all unread notifications for the badge
            $unreadNotificationsCount = $user->unreadNotifications()->count();

            $view->with(compact('unreadNotifications', 'unreadNotificationsCount'));
        } else {
            // Provide default values if the user is not logged in
            $view->with(['unreadNotifications' => collect(), 'unreadNotificationsCount' => 0]);
        }
    }
}
