<?php

namespace App\Http\Controllers\Auth;

use App\Events\NewUserCreatedEvent;
use App\Http\Controllers\Controller;
use App\Mail\NewUserCreated;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {
            $user = Auth::user();
            if ($user->user_type === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.home');
            }
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }

    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = $request->file('image')->storeAs('images/user_image', time() . '.' . $request->file('image')->getClientOriginalExtension(), 'public');

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'image' => $imagePath,
            'user_type' => 'user',
        ]);

        // Mail::to($user->email)->cc('admin@gmail.com')->bcc('admin@gmail.com')->send(new NewUserCreated($user));

        event(new NewUserCreatedEvent($user));
        //    NewUserCreatedEvent::dispatch($user); for this one if we use the quee system

        return redirect()->route('user.home')->with('success', 'Registration successful!');

    }

    public function logout()
    {
        Auth::logout();
        return to_route('login');
    }
}
