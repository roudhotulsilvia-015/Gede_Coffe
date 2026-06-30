<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
// Controller untuk mengelola proses login, registrasi, dan logout pengguna.
class LoginController extends Controller
{// Menampilkan halaman login.
    public function showLogin() {
        return view('login');
    }
// Menampilkan halaman registrasi.
    public function showRegister() {
        return view('register');
    }
// Menangani proses registrasi pengguna baru.
    public function register(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
        ]);
// Membuat pengguna baru dengan data yang telah divalidasi.
        User::create([
            'name' => $data['name'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'role' => 'kasir',
        ]);
// Mengarahkan pengguna ke halaman login dengan pesan sukses.   
        return redirect()->route('login')->with('success', 'Registrasi berhasil. Silakan login.');
    }
//  Menangani proses login pengguna.
    public function login(Request $request) {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
//  
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            DB::table('sessions')
                ->where('id', session()->getId())
                ->update([
                    'user_id' => Auth::id(),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->header('User-Agent'),
                    'last_activity' => now()->timestamp,
                ]);
            return redirect()->intended('/dashboard');
        }
// Jika kredensial tidak valid, kembalikan pengguna ke halaman login dengan pesan kesalahan.
        return back()->withErrors(['username' => 'Username atau password salah.']);
    }
// Menangani proses logout pengguna.
    public function logout(Request $request) {
        DB::table('sessions')->where('id', session()->getId())->delete();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}