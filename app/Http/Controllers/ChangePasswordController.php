<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index()
    {
        return view('change_password');
    }

    public function store(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed', 'regex:/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/'],
        ]);
       
        $current_password   = $request->input('current_password');
        $password           = $request->input('password');
     
        $user = auth()->user();
        //print_r($user);die();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password you entered is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
            'updated_at'=>date('Y-m-d'),
        ]);

        return redirect()->route('password.change')->with('success', 'Your password has been changed successfully!');
    }
}