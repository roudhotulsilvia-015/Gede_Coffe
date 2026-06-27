<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller {
    
    public function index() {
        $produks = Produk::all()->groupBy('kategori');
        return view('kasir.index', compact('produks'));
    }

    public function checkout(Request $request) {
        try {
            $kodeTransaksi = 'TRX-' . time();
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'total_harga' => $request->total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $request->total_harga,
                'user_id' => Auth::id(),
            ]);

            foreach ($request->keranjang as $item) {
                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['id'],
                    'jumlah' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);

                $produk = Produk::find($item['id']);
                if ($produk) {
                    $produk->decrement('stok', $item['qty']);
                }
            }

            return response()->json([
                'message' => 'Transaksi Sukses!',
                'kode_transaksi' => $kodeTransaksi,
                'kasir' => Auth::user() ? Auth::user()->name : 'Kasir',
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}