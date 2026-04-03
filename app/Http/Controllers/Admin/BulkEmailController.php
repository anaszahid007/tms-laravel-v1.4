<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\Admin\SendBulkEmailToShops;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BulkEmailController extends Controller
{
    /**
     * Show the bulk email form
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $totalShops = Shop::where('status', 'active')->count();
        
        return view('admin.bulk-email.create', compact('totalShops'));
    }

    /**
     * Send bulk email to all shops
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function send(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        $admin = Auth::user();
        $subject = $request->input('subject');
        $content = $request->input('content');

        // Dispatch the bulk email job
        SendBulkEmailToShops::dispatch($subject, $content, $admin);

        return redirect()->route('admin.bulk-email.create')
            ->with('success', 'Bulk email has been queued and will be sent to all active shops shortly.');
    }

    /**
     * Preview the bulk email
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function preview(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string|min:10',
        ]);

        $admin = Auth::user();
        $subject = $request->input('subject');
        $content = $request->input('content');

        // Get a sample shop for preview
        $sampleShop = Shop::with('owner')->where('status', 'active')->first();
        
        if (!$sampleShop) {
            return response()->json(['error' => 'No active shops found for preview'], 404);
        }

        return view('emails.admin-announcement', [
            'subject' => $subject,
            'content' => $content,
            'shop' => $sampleShop,
            'owner' => $sampleShop->owner,
            'admin' => $admin
        ]);
    }
}