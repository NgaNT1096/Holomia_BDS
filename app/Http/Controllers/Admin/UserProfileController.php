<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserProfileController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            $user = User::with('projects', 'customer_registration', 'user_history', 'setting_zoom','setting_vr')->findOrFail(Auth::user()->id);

            $setting_zoom = $user->setting_zoom;
        }
        return Inertia::render('Admin/UserProfile', compact('user', 'setting_zoom'));
    }

    public function editAcount(Request $request)
    {
        $user = Auth::user();
        $this->validate(
            $request,
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,' . $user->id,
                'phone' => 'required|max:15|unique:users,phone,' . $user->id,

            ]
        );
        $user->phone = $request->phone;
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();
        return redirect()->back()->with('success', 'Update change successfully!');
    }
    public function changePassword(Request $request)
    {
        $user = Auth::getUser();
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        if (Hash::check($request->get('current_password'), $user->password)) {
            $user->password = Hash::make($request->get('password'));
            $user->save();
            return redirect()->back()->with('success', 'Password change successfully!');
        } else {
            return  redirect()->back()->with('warning', 'Current password is incorrect');
        }
    }

    public function addMessenger(Request $request)
    {
        $user  = Auth::user();
        $user->messenger_chat = $request->messenger_chat;
        return redirect()->back()->with('success', 'Update change successfully!');
    }
}
