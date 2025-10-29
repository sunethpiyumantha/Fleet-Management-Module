<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            Log::info("Fetching notifications for user {$user->id}");

            $notifications = $user->notifications()->orderBy('created_at', 'desc')->get();
            $unread_count = $user->notifications()->unread()->count();
            Log::info("Found {$notifications->count()} notifications, {$unread_count} unread for user {$user->id}");

            return response()->json([
                'notifications' => $notifications->map(function ($n) {
                    $link = '#'; // Default fallback
                    if ($n->request_id) {
                        try {
                            $link = route('vehicle-requests.approvals.show', $n->request_id);
                        } catch (\Exception $e) {
                            Log::error("Route generation error for request_id {$n->request_id}: " . $e->getMessage());
                            $link = '#';
                        }
                    }
                    return [
                        'id' => $n->id,
                        'title' => $n->title ?? 'Untitled',
                        'message' => $n->message ?? '',
                        'type' => $n->type ?? 'general',
                        'request_id' => $n->request_id,
                        'is_read' => $n->is_read ?? false,
                        'created_at' => $n->created_at ? $n->created_at->toJSON() : now()->toJSON(), // Fixed: Use toJSON() for ISO string
                        'link' => $link,
                    ];
                }),
                'unread_count' => $unread_count,
            ]);
        } catch (\Exception $e) {
            Log::error("Error in NotificationController::index for user " . Auth::id() . ": " . $e->getMessage());
            return response()->json([
                'notifications' => [],
                'unread_count' => 0,
                'error' => 'Failed to load notifications'
            ], 500);
        }
    }

    public function unreadCount()
    {
        try {
            $count = Auth::user()->notifications()->unread()->count();
            Log::info("Unread count for user " . Auth::id() . ": {$count}");
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            Log::error("Error in NotificationController::unreadCount: " . $e->getMessage());
            return response()->json(['count' => 0], 500);
        }
    }

    public function markAsRead($id)
    {
        try {
            $notification = Auth::user()->notifications()->findOrFail($id);
            $notification->update(['is_read' => true]);
            Log::info("Marked notification {$id} as read for user " . Auth::id());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error marking notification {$id} as read: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark as read'], 500);
        }
    }

    public function markAllRead()
    {
        try {
            $updated = Auth::user()->notifications()->unread()->update(['is_read' => true]);
            Log::info("Marked all as read for user " . Auth::id() . ", updated {$updated} notifications");
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error("Error marking all notifications as read: " . $e->getMessage());
            return response()->json(['success' => false, 'error' => 'Failed to mark all as read'], 500);
        }
    }
}