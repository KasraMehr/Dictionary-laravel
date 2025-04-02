<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        // اعتبارسنجی داده‌ها
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'message' => 'required|string|min:10',
        ]);

        // ذخیره اطلاعات در دیتابیس
        $contact = Contact::create($validatedData);

        // ارسال ایمیل (اختیاری)
        Mail::raw("New contact message from {$request->name} - {$request->email}: {$request->message}", function ($message) use ($request) {
            $message->to('kasramehrali@gmail.com')
                ->subject('New Contact Message');
        });

        return response()->json(['message' => 'پیام شما با موفقیت ارسال شد!']);
    }
}
