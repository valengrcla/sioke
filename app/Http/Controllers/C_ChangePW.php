<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Pengguna;

class C_ChangePW extends Controller
{
    public function showChangePasswordForm()
    {
        return view('changepw');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ],
        [
            'new_password.min' => 'Password must be at least 8 characters',
        ]);

        $user = Pengguna::where('username', $request->username)->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'username' => ['Invalid username. Verify and try again'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('change.password.form')->with('status', 'Password changed successfully!');
    }
}
