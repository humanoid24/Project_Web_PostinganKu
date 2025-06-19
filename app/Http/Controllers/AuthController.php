<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Register
    public function showRegister()
    {
        return view('auth.daftar');
    }

    public function actionRegister(Request $request)
    {
        $validate = $request->validate([
            'email' => 'required|max:255|email|unique:users',
            'name' => 'required|max:255',
            'gender' => 'required|in:Pria,Wanita',
            'password' => 'required|min:4|confirmed'
        ]);

        $user = User::create([
            'email' => $validate['email'],
            'name' => $validate['name'],
            'gender' => $validate['gender'],
            'password' => Hash::make($validate['password']),
        ]);

        Session::flash('message', 'Register Berhasil. Akun Anda sudah Aktif silahkan Login menggunakan username dan password.');
        return redirect()->route('login');
    }


    // Login

    public function actionLogin(Request $request)
    {
        $data = [
            'name' => $request->input('name'),
            'password' => $request->input('password'),
        ];

        if (Auth::Attempt($data)) {
            return redirect()->route('bloggers.index');
        } else {
            Session::flash('error', 'Username atau Password Salah');
            return redirect('/');
        }
    }

    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('bloggers.index');
        } else {
            return view('auth.login');
        }
    }

    public function actionLogout()
    {
        Auth::logout();
        return redirect('/');
    }
}
