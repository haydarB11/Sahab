<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);


        if (Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember == 'on')) {
            $user = Auth::guard('admin')->user();
            Auth::guard('admin')->login($user);

            $user->last_login = now();
            $user->save();
            $request->session()->regenerate();
            return redirect()->route('admin')->withCookie(Cookie::make('email', $request->email, 5));
        } else {
            // return redirect()->route('admin-signin')->with('error', 'Invalid Login')->withCookie(Cookie::make('email', $request->email, 5))
            //     ->withCookie(Cookie::make('password', $request->password, 5));

            return response()->json(['error' => 'email or password not correct'], 400);
        }
    }

    public function logout()
    {

        Auth::guard('admin')->logout();
        Auth::logout();

        return redirect()->route('admin');
    }
}
