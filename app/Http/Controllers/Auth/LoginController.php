<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Override untuk menambahkan session error saat gagal login.
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        return redirect()->back()
            ->withInput($request->only($this->username(), 'remember'))
            ->with('error', 'Email atau kata sandi salah.');
    }

    protected function authenticated(Request $request, $user)
    {
        return redirect()->intended($this->redirectPath())
                        ->with('success', 'Login berhasil, selamat datang!');
    }
}