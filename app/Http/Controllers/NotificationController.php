<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())->where('is_read', false)->get();
        return Inertia::render('Notifications', ['notifications' => $notifications]);
    }
    
    public function markAsRead($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->is_read = true;
        $notification->save();
        return redirect()->back();
    }
    
}
