<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            "first_name" => "required|string",
            "last_name" => "required|string",
            "user_email" => "required|email",
            "subject" => "required|string",
            "message" => "required|string"
        ]);

        $toEmail = "rofaidaessa6@gmail.com"; // ✅ ايميلك للتجربة

        Mail::raw(
            "Name: {$request->first_name} {$request->last_name}\nEmail: {$request->user_email}\n\nMessage:\n{$request->message}",
            function ($mail) use ($request, $toEmail) {
                $mail->to($toEmail)
                    ->subject($request->subject);
            }
        );

        return response()->json(["message" => "✅ Message sent successfully"]);
    }
}
