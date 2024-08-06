<?php

namespace Modules\Auth\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function index()
    {
        // dd(Auth::user());

        return view('auth::index');
    }

    public function store(Request $request)
    {

        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required',
            ],
            [
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email tidak valid',
                'password.required' => 'Password wajib diisi',
            ]
        );

        // login store
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            if (Auth::user()->role == 'admin') {
                return redirect('/task');
            } else {
                return redirect('/user');
            }
        }

        session()->flash('error', 'Email atau password salah');
        return redirect()->route('/login');
    }
    public function registerForm()
    {
        return view('auth::register');
    }

    public function register(Request $request)
    {
        $data = $request->validate(
            [
                'name' => 'required',
                'email' => 'required|unique:users',
                'password' => 'required',
            ],
            [
                'name.required' => 'Nama wajib diisi',
                'email.required' => 'Email wajib diisi',
                'email.email' => 'Email tidak valid',
                'email.unique' => 'Email sudah terdaftar',
                'password.required' => 'Password wajib diisi',
            ]
        );

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'assignee',
        ]);

        session()->flash('success', 'Register berhasil, silahkan login');
        return redirect('/login');
    }

    public function logout()
    {
        Auth::logout();
        session()->flash('error', 'Anda telah logout');
        return redirect('/login');
    }
}
