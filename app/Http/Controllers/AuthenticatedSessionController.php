<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    public function destroy(Request $request)
    {
        // Logout user
        Auth::logout();

        // Hapus sesi pengguna
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect setelah logout
        return redirect()->route('login')->with('logout_success', 'Berhasil logout.');
    }
}