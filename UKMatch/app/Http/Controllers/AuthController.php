<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) { 
            // jika sudah login, maka redirect ke halaman home (welcome)
            return redirect()->route('welcome');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        try {
            // Mengecek apakah permintaan berbentuk AJAX atau JSON
            if ($request->ajax() || $request->wantsJson()) {
                $credentials = $request->only('username', 'password');

                // Melakukan autentikasi
                if (Auth::attempt($credentials)) {
                    // Jika berhasil login, arahkan ke halaman welcome
                    return response()->json([
                        'status' => true,
                        'message' => 'Login Berhasil',
                        'redirect' => url('/welcome')
                    ]);
                }

                // Jika login gagal
                return response()->json([
                    'status' => false,
                    'message' => 'Login Gagal'
                ]);
            }

            // Jika bukan permintaan AJAX, redirect ke halaman login
            if (Auth::attempt($request->only('username', 'password'))) {
                return redirect()->route('welcome');
            }

            return redirect()->route('login')->withErrors('Login gagal');
        } catch (\Exception $e) {
            // Menangani error umum
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }
    }

    // Proses logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Redirect kembali ke halaman login setelah logout
        return redirect()->route('login');
    }
}