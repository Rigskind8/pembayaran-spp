<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

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
    public function boot(): void
    {
        session()->forget(['ui_locale', 'ui_theme']);

        app()->setLocale('id');
        Carbon::setLocale('id');

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            if (\Illuminate\Support\Facades\Auth::check()) {
                $user = \Illuminate\Support\Facades\Auth::user();
                $userNotifications = \App\Models\Notifikasi::where('user_id', $user->id)
                    ->latest()
                    ->take(8)
                    ->get();
                $unreadCount = \App\Models\Notifikasi::where('user_id', $user->id)
                    ->where('dibaca', false)
                    ->count();

                if ($userNotifications->isEmpty()) {
                    try {
                        $announcements = \App\Models\Pengumuman::latest()->take(5)->get();
                        $userNotifications = $announcements->map(function($ann) {
                            return (object)[
                                'id'         => 0,
                                'judul'      => $ann->judul ?? $ann->title ?? 'Pengumuman Sekolah',
                                'pesan'      => substr(strip_tags($ann->konten ?? $ann->content ?? ''), 0, 80) . '...',
                                'tipe'       => 'pengumuman',
                                'dibaca'     => false,
                                'created_at' => $ann->created_at,
                            ];
                        });
                        $unreadCount = $userNotifications->count();
                    } catch (\Throwable $e) {
                        $userNotifications = collect();
                        $unreadCount = 0;
                    }
                }

                $view->with('globalNotifications', $userNotifications);
                $view->with('globalUnreadCount', $unreadCount);
            }
        });
    }
}