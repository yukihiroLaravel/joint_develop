<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class NotificationsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $notifications = $user->notifications()
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'reacted_by_name' => $notification->data['reacted_by_name'],
                    'reaction_label' => $notification->data['reaction_label'],
                    'url' => $notification->data['url'],
                    'read_at' => $notification->read_at,
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }

    public function markNotificationAsRead($id)
    {
        $user = Auth::user();

        $notification = $user->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (! $notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'unread_count' => $user->unreadNotifications()->count(),
        ]);
    }
}
