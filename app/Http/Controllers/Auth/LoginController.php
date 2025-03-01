<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function view(): View
    {
        return view('auth.view');
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            return redirect()->route('dashboard')->with('message', [
                'status' => 'success',
                'message' => 'Login Berhasil',
            ]);
        }

        return redirect()->route('login')->with('message', [
            'status' => 'failed',
            'message' => 'Login gagal, username atau password salah',
        ]);
    }
}
