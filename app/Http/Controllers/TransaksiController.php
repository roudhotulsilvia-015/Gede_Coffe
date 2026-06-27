<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;

class TransaksiController extends Controller {
    public function index() {
        $transaksis = Transaksi::latest()->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show(int $id) {
        $transaksi = Transaksi::with('detail_transaksis.produk')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function exportPdf() {
        $transaksis = Transaksi::latest()->get();
        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel() {
        $transaksis = Transaksi::latest()->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-transaksi.csv"',
        ];

        $columns = ['Kode Transaksi', 'Total Harga', 'Bayar', 'Kembalian', 'Waktu'];
        $callback = function() use ($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($transaksis as $t) {
                fputcsv($file, [
                    $t->kode_transaksi,
                    $t->total_harga,
                    $t->bayar,
                    $t->kembalian,
                    $t->created_at->format('d M Y H:i'),
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
