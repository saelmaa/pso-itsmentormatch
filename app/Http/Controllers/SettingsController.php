<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('settings.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'student_id' => 'nullable|string|max:20',
            'department' => 'nullable|string|max:100',
            'phone' => 'nullable|string|max:20',
            'new_password' => 'nullable|string|min:6|confirmed',
        ]);

        if ($request->filled('new_password')) {
            $validated['password'] = Hash::make($request->new_password);
        }

        $user->update($validated);

        return redirect()->route('settings.edit')->with('success', 'Settings updated successfully!');
    }
}
