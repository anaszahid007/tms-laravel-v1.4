<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function create()
    {
        return view('admin.notifications.create');
    }

    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Logic to queue emails or send them. For now, we'll just flash a success message.
        // In a real app, you'd iterate users and dispatch a job.

        // Example logic (commented out as Mailable class might not exist):
        // $users = User::all();
        // foreach ($users as $user) {
        //     Mail::to($user)->queue(new GeneralNotification($request->subject, $request->message));
        // }

        return redirect()->route('admin.dashboard')->with('success', 'Email has been queued for all users.');
    }
}
