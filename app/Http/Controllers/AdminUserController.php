<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('user_type', 'user')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate(10);

        $userCounts = User::selectRaw("
            COUNT(CASE WHEN user_type = 'admin' THEN 1 END) as admin_count,
            COUNT(CASE WHEN user_type != 'admin' AND status = '1' THEN 1 END) as active_count,
            COUNT(CASE WHEN user_type != 'admin' AND status = '0' THEN 1 END) as inactive_count
        ")->first();

        return view('admin.users.index', [
            'users' => $users,
            'activeUsersCount' => $userCounts->active_count,
            'inactiveUsersCount' => $userCounts->inactive_count,
            'adminUsersCount' => $userCounts->admin_count
        ]);
    }

    public function updateOrCreateUsers(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'password' => $request->id ? 'nullable|confirmed' : 'required|confirmed',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'required|in:1,0',
            'user_type' => 'required|in:user,admin'
        ]);

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
            'user_type' => $request->user_type,
        ];

        if ($request->password) {
            $userData['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('image')) {
            if ($request->id && $user = User::find($request->id)) {
                if ($user->image) {
                    Storage::disk('public')->delete($user->image);
                }
            }
            $imagePath = $request->file('image')->store('images/user_image', 'public');
            $userData['image'] = $imagePath;
        }

        User::updateOrCreate(
            ['id' => $request->id],
            $userData
        );

        $message = $request->id ? 'User updated successfully' : 'User created successfully';
        return redirect()->route('admin.users.index')->with('success', $message);
    }

    public function updateUserActiveStatus(Request $request, User $user)
    {
        $newStatus = $user->status == '1' ? '0' : '1';
        $user->update(['status' => $newStatus]);

        return response()->json(['success' => true]);
    }

    public function destroy(User $user)
    {
        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully!');
    }
}