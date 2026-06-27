<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    public function index() {
        $produks = Produk::all();
        return view('produk.index', compact('produks'));
    }

    public function create() {
        return view('produk.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);
        Produk::create($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambah!');
    }

    public function edit(Produk $produk) {
        return view('produk.edit', compact('produk'));
    }

    public function update(Request $request, Produk $produk) {
        $data = $request->validate([
            'nama_produk' => 'required',
            'kategori'    => 'required',
            'harga'       => 'required|numeric',
            'stok'        => 'required|numeric',
        ]);
        $produk->update($data);
        return redirect()->route('produk.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Produk $produk) {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }
}