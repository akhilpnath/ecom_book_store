<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('update_profile');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:100',
            // 'email' => 'required|email|unique:users,email,' . $user->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'update_pass' => 'nullable|string|min:6',
            'new_pass' => 'nullable|string|min:6',
            'confirm_pass' => 'nullable|string|min:6|same:new_pass',
        ]);

        $user->name = $request->name;
        // $user->email = $request->email;

        if ($request->hasFile('image')) {
            if ($user->image) {
                Storage::disk('public')->delete($user->image); // Delete old image
            }
            $imagePath = $request->file('image')->store('uploaded_img', 'public');
            $user->image = $imagePath;
        }

        if ($request->filled('update_pass') && $request->filled('new_pass') && $request->filled('confirm_pass')) {
            if (!Hash::check($request->update_pass, $user->password)) {
                return redirect()->back()->withErrors(['update_pass' => 'Old password is incorrect.']);
            }
            $user->password = Hash::make($request->new_pass);
        }

        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }
}
