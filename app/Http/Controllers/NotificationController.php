<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return view('notifications')->with('notifications', $notifications);
    }
    // In your NotificationController, add the 'update' method
    public function update(Request $request)
    {
        $notificationId = $request->input('id');
    
        // Update the 'read' column to true for the given notification ID
        // Replace 'YourNotificationModel' with the actual model for your notifications
        Notification::where('id', $notificationId)->update(['read' => true]);
    
        return response()->json(['success' => true]);
    }
}
