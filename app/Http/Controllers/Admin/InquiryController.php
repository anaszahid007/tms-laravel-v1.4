<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    /**
     * Display a listing of inquiries.
     */
    public function index()
    {
        $inquiries = ContactUs::latest()->paginate(10);
        return view('admin.inquiries.index', compact('inquiries'));
    }

    /**
     * Delete an inquiry.
     */
    public function destroy(ContactUs $inquiry)
    {
        $inquiry->delete();
        return back()->with('success', 'Inquiry deleted successfully.');
    }
}
