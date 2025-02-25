<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class UserMessageController extends Controller
{
    public function index()
    {
        return view('user.contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email',
            'number' => 'required|string|max:12',
            'msg' => 'required|string|max:500',
        ]);

        Message::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'email' => $request->email,
            'number' => $request->number,
            'message' => $request->msg,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}