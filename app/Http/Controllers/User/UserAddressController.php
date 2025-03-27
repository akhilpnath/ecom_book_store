<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAddressController extends Controller
{
    public function viewAddress()
    {
        $addresses = Address::where('user_id', Auth::id())->latest()->get();
        return view('user.address.index', compact('addresses'));
    }

    public function createAddress()
    {
        return view('user.address.create');
    }

    public function updateOrCreateAddress(Request $request)
    {
        // Validate request data
        $validatedData = $request->validate([
            'address_line_1' => 'required|max:225',
            'address_line_2' => 'nullable|max:225',
            'city' => 'required',
            'state' => 'required',
            'country' => 'required',
            'pincode' => 'required|string|min:6',
            'phone_number' => 'required|string|min:10',
        ]);

        // Use updateOrCreate to update if exists, otherwise create new
        $address = Address::updateOrCreate(
            ['id' => $request->address_id, 'user_id' => Auth::id()], // Search condition
            $validatedData // Update or insert data
        );

        $message = $request->address_id ? 'Address updated successfully' : 'Address created successfully';

        return redirect()->route('user.address.index')->with('success', $message);
    }

    public function editAddress(Address $address)
    {
        if ($address->user_id != Auth::id()) {
            return redirect()->route('user.address.index')->with('error', 'Unauthorized access');
        }

        return view('user.address.edit', compact('address'));
    }

    public function delete(Address $address)
    {
        if ($address->user_id != Auth::id()) {
            return redirect()->route('user.address.index')->with('error', 'Unauthorized access');
        }

        $address->delete();
        return redirect()->route('user.address.index')->with('success', 'Address deleted successfully');
    }
}