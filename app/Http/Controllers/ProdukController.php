<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;
// Controller untuk mengelola data produk (CRUD).
class ProdukController extends Controller
{// Menampilkan daftar seluruh produk.
    public function index() {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }
// Menampilkan form untuk membuat produk baru.
    public function create() {
        return view('produk.create');
    }
// Menampilkan detail produk tertentu.
    public function show(Produk $produk) {
        return view('produk.show', compact('produk'));
    }
// Menyimpan data produk baru ke database.
    public function store(Request $request) {
        $data = $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);// Menyimpan produk baru ke database.
        Produk::create($data);// Mengarahkan pengguna kembali ke halaman daftar produk dengan pesan sukses.
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambah!');
    }
// Menampilkan form untuk mengedit produk.
    public function edit(Produk $produk) {
        return view('produk.edit', compact('produk'));
    }
// Memperbarui data produk di database.
    public function update(Request $request, Produk $produk) {
        $data = $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);// Memperbarui produk dengan data yang telah divalidasi.
        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }
// Menghapus data produk dari database.
    public function destroy(Produk $produk) {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}