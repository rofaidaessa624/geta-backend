<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Mail\FreeTranslationMail;
use Illuminate\Support\Facades\Mail;


class FreeTranslationController extends Controller
{
   public function store(Request $request)
{
    $request->validate([
        "name" => "required|string|max:255",
        "email" => "required|email",
        "mobile" => "required|string|max:20",
        "source_language" => "required|string|max:50",
        "target_language" => "required|string|max:50",
        "file" => "required|file|max:10240",
    ]);

    // ✅ upload file
    $filePath = $request->file("file")->store("free_translation", "public");
    $fileUrl = asset("storage/" . $filePath);

    // ✅ save database (لو عندك Model)
    // FreeTranslationRequest::create([...]);

    // ✅ send mail
    Mail::to(env('CONTACT_RECEIVER_EMAIL'))->send(new FreeTranslationMail([
        "name" => $request->name,
        "email" => $request->email,
        "mobile" => $request->mobile,
        "source_language" => $request->source_language,
        "target_language" => $request->target_language,
        "file_url" => $fileUrl
    ]));

    return response()->json([
        "success" => true,
        "message" => "Request sent successfully!",
        "file" => $fileUrl
    ]);
}

}
