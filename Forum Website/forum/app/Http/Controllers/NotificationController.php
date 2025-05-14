<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{
    public function markAsRead(Request $request, $id)
    {
        try {
            DB::table('notifications')
                ->where('id', $id)
                ->update(['read_at' => now()]);

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function markAllAsRead(Request $request)
    {
        try {
            DB::table('notifications')
                ->where('notifiable_id', Auth::id())
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            return back()->with('success', 'Tüm bildirimler okundu olarak işaretlendi.');
        } catch (\Exception $e) {
            return back()->with('error', 'Bir hata oluştu: ' . $e->getMessage());
        }
    }
}
