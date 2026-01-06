<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FreeTranslationMail;

class FreeTransController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'mobile' => 'required|string|max:20',
            'file' => 'required|file|max:5120', // ✅ 5MB (5120 KB)
        ]);

        $file = $request->file('file');

        Mail::to('info@transgateacd.com')
            ->send(new FreeTranslationMail(
                $request->name,
                $request->email,
                $request->mobile,
                $file
            ));

        return response()->json([
            'message' => 'Email sent successfully!'
        ]);
    }
}
