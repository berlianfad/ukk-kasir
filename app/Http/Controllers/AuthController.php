<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
            if (Auth::user()->role == 'Admin') {
                return redirect()->intended(route('admin.dashboard'))->with('success', 'Login berhasil!');
            } else {
                return redirect()->intended(route('employee.dashboard'))->with('success', 'Login berhasil!');
            }
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }


    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Berhasil logout!');
    }
}
