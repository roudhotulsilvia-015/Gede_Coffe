<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KasirController extends Controller {
    
    public function index() {
        $produks = Produk::where('stok', '>', 0)->get()->groupBy('kategori');
        return view('kasir.index', compact('produks'));
    }

    public function checkout(Request $request) {
        $data = $request->validate([
            'total_harga' => 'required|numeric|min:0',
            'bayar' => 'required|numeric|min:0',
            'keranjang' => 'required|array|min:1',
            'keranjang.*.id' => 'required|integer|exists:produks,id',
            'keranjang.*.qty' => 'required|integer|min:1',
            'keranjang.*.subtotal' => 'required|numeric|min:0',
        ]);

        try {
            $kodeTransaksi = 'TRX-' . time();
            $transaksi = Transaksi::create([
                'kode_transaksi' => $kodeTransaksi,
                'total_harga' => $data['total_harga'],
                'bayar' => $data['bayar'],
                'kembalian' => $data['bayar'] - $data['total_harga'],
                'user_id' => Auth::id(),
            ]);

            $outOfStockIds = [];
            $outOfStockNames = [];

            foreach ($data['keranjang'] as $item) {
                $produk = Produk::find($item['id']);
                if (! $produk || $produk->stok < $item['qty']) {
                    return response()->json(['error' => 'Stok produk tidak mencukupi atau produk tidak ditemukan.'], 422);
                }

                if ($produk->stok === $item['qty']) {
                    $outOfStockIds[] = $produk->id;
                    $outOfStockNames[] = $produk->nama_produk;
                }

                DetailTransaksi::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $item['id'],
                    'jumlah' => $item['qty'],
                    'subtotal' => $item['subtotal']
                ]);

                $produk->decrement('stok', $item['qty']);
            }

            return response()->json([
                'message' => 'Transaksi Sukses!',
                'kode_transaksi' => $kodeTransaksi,
                'kasir' => Auth::user() ? Auth::user()->name : 'Kasir',
                'out_of_stock_ids' => $outOfStockIds,
                'out_of_stock_names' => $outOfStockNames,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}