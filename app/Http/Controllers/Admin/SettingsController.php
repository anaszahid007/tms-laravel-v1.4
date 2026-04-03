<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Setting;

class SettingsController extends Controller
{
    public function index()
    {
        $settings = [
            'site_name' => Setting::get('site_name', 'TailorOnDesk'),
            'contact_phone' => Setting::get('contact_phone', '0339842374834'),
            'contact_email' => Setting::get('contact_email', 'admin@tailorondesk.com'),
            'maintenance_mode' => Setting::get('maintenance_mode', false),
            'allow_registration' => Setting::get('allow_registration', true),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'contact_email' => 'required|email|max:255',
            'maintenance_mode' => 'nullable|string', // Checkbox gives 'on' or null
            'allow_registration' => 'nullable|string',
        ]);

        Setting::set('site_name', $validated['site_name']);
        Setting::set('contact_phone', $validated['contact_phone']);
        Setting::set('contact_email', $validated['contact_email']);
        Setting::set('maintenance_mode', isset($request->maintenance_mode) ? 'true' : 'false', 'boolean');
        Setting::set('allow_registration', isset($request->allow_registration) ? 'true' : 'false', 'boolean');

        return back()->with('success', 'Settings updated successfully.');
    }
}
