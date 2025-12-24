<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'kaprodi') {
                // REDIRECT UNTUK KAPRODI (DIKOREKSI)
                return redirect()->route('kaprodi.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->withErrors('Email atau Password salah');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
                // MENGUBAH REGEX: Hanya izinkan domain @student.uin.ac.id
                'regex:/^[^@\s]+@student\.uin\.ac\.id$/i'
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            'email.regex' => 'Email harus menggunakan domain @student.uin.ac.id',
            'password.regex' => 'Password harus mengandung minimal satu huruf besar dan satu angka.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // default user
        ]);

        Auth::login($user);

        return redirect()->route('user.dashboard');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
