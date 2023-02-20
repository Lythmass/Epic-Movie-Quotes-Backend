<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    public function index(Request $request)
    {
        $user_id = $request['id'];
        $notifications = Notification::where('user_id', $user_id)->get();
        return response()->json(['notifications' => $notifications]);
    }
}
