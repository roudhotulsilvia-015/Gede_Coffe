<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

/**
 * Controller untuk mengelola data karyawan (CRUD).
 */
class KaryawanController extends Controller
{
    // Menampilkan daftar seluruh karyawan.
    public function index() {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    // Menampilkan form untuk membuat karyawan baru.
    public function create() {
        return view('karyawan.create');
    }

    // Menampilkan detail karyawan tertentu.
    public function show(Karyawan $karyawan) {
        return view('karyawan.show', compact('karyawan'));
    }
    // Menyimpan data karyawan baru ke database.
    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
        ]);

        Karyawan::create($validated);
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambah!');
    }
    // Menampilkan form untuk mengedit karyawan.
    public function edit(Karyawan $karyawan) {
    return view('karyawan.edit', compact('karyawan'));
}
// Memperbarui data karyawan di database.
public function update(Request $request, Karyawan $karyawan) {
    $validated = $request->validate([
        'nama' => 'required',
        'jabatan' => 'required',
        'telepon' => 'required',
    ]);
    $karyawan->update($validated);
    return redirect()->route('karyawan.index')->with('success', 'Data diupdate!');
}
// Menghapus data karyawan dari database.
public function destroy(Karyawan $karyawan) {
    $karyawan->delete();
    return redirect()->route('karyawan.index')->with('success', 'Data dihapus!');
}
}