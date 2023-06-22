<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminProfileController extends Controller
{
   

public function edit()
{
    $user = auth()->user();

    return view('profile_edit', compact('user'));
}

public function update(Request $request)
{
    $user = auth()->user();

    $data = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
    ]);

    $user->update($data);

    return redirect()->back()->with('success', 'Profile updated successfully.');
}
}
