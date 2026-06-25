<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email'],
            'message'    => ['required', 'string', 'min:10'],
        ]);

        // Log the contact message (email sending requires SMTP)
        Log::info('Contact form submission', $request->only([
            'first_name', 'last_name', 'email', 'phone', 'subject', 'message'
        ]));

        return back()->with('contact_success', true);
    }
}
