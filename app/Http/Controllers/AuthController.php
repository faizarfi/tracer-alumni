<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// Controller untuk otentikasi: login, register, logout
class AuthController extends Controller
{
    # Menangani: showLogin() - tampilkan form login
    public function showLogin()
    {
        return view('auth.login');
    }

    # Menangani: login(Request $request) - proses autentikasi user
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'kaprodi') {
                return redirect()->route('kaprodi.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        return redirect()->back()->withErrors('Email atau Password salah');
    }

    # Menangani: showRegister() - tampilkan form pendaftaran
    public function showRegister()
    {
        return view('auth.register');
    }

    # Menangani: register(Request $request) - proses pembuatan akun baru
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required','string','max:255','regex:/^[\\pL\\s]+$/u'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:users',
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/^(?=.*[A-Z])(?=.*\d).+$/'
            ],
        ], [
            'password.regex' => 'Password harus mengandung minimal satu huruf besar dan satu angka.',
            'name.regex' => 'Nama lengkap hanya boleh berisi huruf dan spasi.',
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

    # Menangani: logout() - keluar dari sesi user
    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
