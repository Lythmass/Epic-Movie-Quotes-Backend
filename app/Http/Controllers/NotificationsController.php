<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', auth()->user()->id)->latest()->get();
        return response()->json(['notifications' => $notifications]);
    }

    public function update()
    {
        Notification::where('user_id', auth()->user()->id)->update(['is_read' => true]);
        return response()->json(['message' => 'nice']);
    }
}
