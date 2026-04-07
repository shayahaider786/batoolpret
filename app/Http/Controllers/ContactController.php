<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Mail\ContactFormNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    /**
     * Store a new contact message.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|min:10',
        ]);

        $contact = Contact::create([
            'first_name' => $validated['fname'],
            'last_name' => $validated['lname'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        // Send email notification to all admin users
        try {
            $adminUsers = User::where('type', 1)->get(); // type 1 = admin
            
            foreach ($adminUsers as $admin) {
                Mail::to($admin->email)->send(new ContactFormNotification($contact));
            }
        } catch (\Exception $e) {
            // Log the error but don't fail the contact submission
            \Log::error('Failed to send contact form notification email: ' . $e->getMessage());
        }

        return redirect()->back()
            ->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
