<?php

namespace App\Http\View\Composers;

use App\Models\Notifikasi;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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
            $notifications = Notifikasi::where('user_id', $user->id)
                ->latest()
                ->take(10)
                ->get();
            $view->with('globalNotifications', $notifications);
        }
    }
}