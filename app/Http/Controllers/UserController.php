<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
// Controller untuk mengelola data pengguna (CRUD).
class UserController extends Controller
{// Menampilkan daftar seluruh pengguna.
    public function index()
    {
        $users = User::orderBy('name')->get();
        return view('users.index', compact('users'));
    }
// Menampilkan form untuk membuat pengguna baru.
    public function create()
    {
        return view('users.create');
    }
// Menyimpan data pengguna baru ke database.
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin', 'kasir'])],
        ]);
// Membuat pengguna baru dengan data yang telah divalidasi.
        $data['password'] = Hash::make($data['password']);
        User::create($data);

        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan!');
    }
// Menampilkan detail pengguna tertentu.
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
// Menampilkan form untuk mengedit pengguna.
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }
// Memperbarui data pengguna di database.
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users', 'username')->ignore($user->id)],
            'password' => 'nullable|string|min:6|confirmed',
            'role' => ['required', Rule::in(['admin', 'kasir'])],
        ]);
// Jika password tidak diisi, jangan perbarui password pengguna.
        if (empty($data['password'])) {
            unset($data['password']);
        } else {
            $data['password'] = Hash::make($data['password']);
        }
// Memperbarui data pengguna dengan data yang telah divalidasi.
        $user->update($data);

        return redirect()->route('users.index')->with('success', 'User berhasil diupdate!');
    }
// Menghapus data pengguna dari database.
    public function destroy(User $user)
    {
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Tidak dapat menghapus akun sendiri.');
        }
// Menghapus pengguna dari database.
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus!');
    }
}
