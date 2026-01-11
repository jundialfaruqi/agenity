<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Services\AuthService;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request, AuthService $authService)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = $authService->attempt($validated['email'], $validated['password']);
        if (!$user) {
            return Redirect::back()->withErrors([
                'email' => 'Invalid credentials',
            ])->withInput();
        }

        if ($user->status !== 'active') {
            return Redirect::back()->withErrors([
                'email' => 'Akun anda tidak aktif',
            ])->withInput();
        }

        Auth::login($user);
        Session::put('user_id', $user->id);
        $intended = session()->pull('intended_url', route('dashboard.index'));
        return Redirect::to($intended);
    }

    public function logout()
    {
        Auth::logout();
        Session::forget('user_id');
        return Redirect::to(route('login'));
    }
}
