<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransaksiController extends Controller {
    public function index() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();

        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }

        $transaksis = $query->get();
        return view('transaksi.index', compact('transaksis'));
    }

    public function show(int $id) {
        $transaksi = Transaksi::with('detail_transaksis.produk')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }

    public function edit(int $id) {
        $transaksi = Transaksi::with('detail_transaksis.produk')->findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }

    public function update(int $id, Request $request) {
        $transaksi = Transaksi::findOrFail($id);

        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);

        $transaksi->update([
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $transaksi->total_harga,
        ]);

        return redirect()->route('transaksi.riwayat')->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy(int $id) {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();

        return redirect()->route('transaksi.riwayat')->with('success', 'Transaksi berhasil dihapus.');
    }

    public function report(Request $request) {
        $user = Auth::user();
        $year = $request->query('year', now()->year);

        $query = Transaksi::selectRaw('MONTH(created_at) AS month, COUNT(*) AS count, SUM(total_harga) AS total_revenue')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month');

        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }

        $monthlyResults = $query->get()->keyBy('month');

        $chartLabels = [];
        $chartData = [];
        $tableData = [];
        $totalRevenue = 0;
        $totalTransactions = 0;

        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 10));
            $monthRow = $monthlyResults->get($i);
            $revenue = $monthRow ? (int) $monthRow->total_revenue : 0;
            $count = $monthRow ? (int) $monthRow->count : 0;

            $chartLabels[] = $monthName;
            $chartData[] = $revenue;
            $tableData[] = [
                'month' => $monthName,
                'count' => $count,
                'total_revenue' => $revenue,
            ];
            $totalRevenue += $revenue;
            $totalTransactions += $count;
        }

        return view('transaksi.report', compact('year', 'chartLabels', 'chartData', 'tableData', 'totalRevenue', 'totalTransactions'));
    }

    public function exportPdf() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();

        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }

        $transaksis = $query->get();
        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();

        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }

        $transaksis = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-transaksi.csv"',
        ];

        $columns = ['Kode Transaksi', 'Kasir', 'Total Harga', 'Bayar', 'Kembalian', 'Waktu'];
        $callback = function() use ($transaksis, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);
            foreach ($transaksis as $t) {
                fputcsv($file, [
                    $t->kode_transaksi,
                    optional($t->user)->name ?? '-',
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
