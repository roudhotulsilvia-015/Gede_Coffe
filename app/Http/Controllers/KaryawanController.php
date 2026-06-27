<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use Illuminate\Http\Request;

class KaryawanController extends Controller
{
    public function index() {
        $karyawans = Karyawan::all();
        return view('karyawan.index', compact('karyawans'));
    }

    public function create() {
        return view('karyawan.create');
    }

    public function show(Karyawan $karyawan) {
        return view('karyawan.show', compact('karyawan'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nama' => 'required',
            'jabatan' => 'required',
            'telepon' => 'required',
        ]);

        Karyawan::create($validated);
        return redirect()->route('karyawan.index')->with('success', 'Data berhasil ditambah!');
    }
    public function edit(Karyawan $karyawan) {
    return view('karyawan.edit', compact('karyawan'));
}

public function update(Request $request, Karyawan $karyawan) {
    $validated = $request->validate([
        'nama' => 'required',
        'jabatan' => 'required',
        'telepon' => 'required',
    ]);
    $karyawan->update($validated);
    return redirect()->route('karyawan.index')->with('success', 'Data diupdate!');
}

public function destroy(Karyawan $karyawan) {
    $karyawan->delete();
    return redirect()->route('karyawan.index')->with('success', 'Data dihapus!');
}
}