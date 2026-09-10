<?php

namespace App\Http\Controllers;

use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false], 401);
        }

        if ($request->has('id') && $request->id > 0) {
            Notifikasi::where('id', $request->id)
                ->where('user_id', $user->id)
                ->update(['dibaca' => true]);
        } else {
            Notifikasi::where('user_id', $user->id)
                ->update(['dibaca' => true]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi ditandai dibaca.',
        ]);
    }
}

