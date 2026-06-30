<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// Controller untuk mengelola transaksi dan laporan transaksi.
class TransaksiController extends Controller {
    public function index() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();
// Jika pengguna adalah kasir, batasi transaksi yang ditampilkan hanya untuk kasir tersebut.
        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }
// Mengambil semua transaksi yang sesuai dengan kriteria di atas.
        $transaksis = $query->get();
        return view('transaksi.index', compact('transaksis'));
    }
// Menampilkan riwayat transaksi.
    public function show(int $id) {
        $transaksi = Transaksi::with('detail_transaksis.produk')->findOrFail($id);
        return view('transaksi.show', compact('transaksi'));
    }
// Menampilkan form untuk mengedit transaksi.
    public function edit(int $id) {
        $transaksi = Transaksi::with('detail_transaksis.produk')->findOrFail($id);
        return view('transaksi.edit', compact('transaksi'));
    }
// Memperbarui data transaksi di database.
    public function update(int $id, Request $request) {
        $transaksi = Transaksi::findOrFail($id);
// Validasi input untuk memastikan bahwa jumlah pembayaran valid.
        $request->validate([
            'bayar' => 'required|numeric|min:0',
        ]);
// Memperbarui data transaksi dengan jumlah pembayaran baru dan menghitung kembalian.
        $transaksi->update([
            'bayar' => $request->bayar,
            'kembalian' => $request->bayar - $transaksi->total_harga,
        ]);
// Mengarahkan pengguna kembali ke halaman riwayat transaksi dengan pesan sukses.
        return redirect()->route('transaksi.riwayat')->with('success', 'Transaksi berhasil diperbarui.');
    }
// Menghapus data transaksi dari database.
    public function destroy(int $id) {
        $transaksi = Transaksi::findOrFail($id);
        $transaksi->delete();
// Mengarahkan pengguna kembali ke halaman riwayat transaksi dengan pesan sukses.
        return redirect()->route('transaksi.riwayat')->with('success', 'Transaksi berhasil dihapus.');
    }
// Menampilkan laporan transaksi berdasarkan tahun.
    public function report(Request $request) {
        $user = Auth::user();
        $year = $request->query('year', now()->year);
// Query untuk mengambil data transaksi berdasarkan bulan dan tahun, serta menghitung total pendapatan dan jumlah transaksi.
        $query = Transaksi::selectRaw('MONTH(created_at) AS month, COUNT(*) AS count, SUM(total_harga) AS total_revenue')
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month');
// Jika pengguna adalah kasir, batasi laporan hanya untuk transaksi yang dilakukan oleh kasir tersebut.
        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }
// Mengambil hasil query dan mengelompokkannya berdasarkan bulan.  
        $monthlyResults = $query->get()->keyBy('month');

        $chartLabels = [];
        $chartData = [];
        $tableData = [];
        $totalRevenue = 0;
        $totalTransactions = 0;
// Looping melalui setiap bulan untuk menyiapkan data yang akan ditampilkan dalam bentuk grafik dan tabel.
        for ($i = 1; $i <= 12; $i++) {
            $monthName = date('F', mktime(0, 0, 0, $i, 10));
            $monthRow = $monthlyResults->get($i);
            $revenue = $monthRow ? (int) $monthRow->total_revenue : 0;
            $count = $monthRow ? (int) $monthRow->count : 0;
// Menambahkan data bulan, jumlah transaksi, dan total pendapatan ke array yang sesuai untuk grafik dan tabel.
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
// Mengembalikan view laporan transaksi dengan data yang telah disiapkan.
        return view('transaksi.report', compact('year', 'chartLabels', 'chartData', 'tableData', 'totalRevenue', 'totalTransactions'));
    }
// Menangani ekspor laporan transaksi ke format PDF.
    public function exportPdf() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();
// Jika pengguna adalah kasir, batasi laporan hanya untuk transaksi yang dilakukan oleh kasir tersebut.
        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }
// Mengambil semua transaksi yang sesuai dengan kriteria di atas.
        $transaksis = $query->get();
        $pdf = Pdf::loadView('transaksi.export_pdf', compact('transaksis'));
        return $pdf->download('laporan-transaksi.pdf');
    }
// Menangani ekspor laporan transaksi ke format Excel (CSV).
    public function exportExcel() {
        $user = Auth::user();
        $query = Transaksi::with('user')->latest();

        if ($user->role === 'kasir') {
            $query->where('user_id', $user->id);
        }
// Mengambil semua transaksi yang sesuai dengan kriteria di atas.
        $transaksis = $query->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="laporan-transaksi.csv"',
        ];
// Menentukan kolom yang akan diekspor ke file CSV.
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
// Mengembalikan respons dengan file CSV yang dihasilkan.
        return response()->stream($callback, 200, $headers);
    }
}
