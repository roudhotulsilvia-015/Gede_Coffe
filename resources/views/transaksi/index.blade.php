@extends('adminlte::page')

@section('content')
// Menampilkan daftar transaksi
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Riwayat Transaksi</h3>
        // Tombol untuk mengekspor data transaksi ke PDF dan Excel  
        <div class="card-tools">
            <a href="{{ route('transaksi.export.pdf') }}" class="btn btn-danger btn-sm mr-1">Export PDF</a>
            <a href="{{ route('transaksi.export.excel') }}" class="btn btn-success btn-sm">Export Excel</a>
        </div>
    </div>
    // Menampilkan tabel transaksi
    <div class="card-body">
        // Menampilkan pesan sukses jika ada
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        // Menampilkan pesan error jika ada
        <table class="table table-bordered table-striped" id="tabelTransaksi">
            <thead>
                // Menampilkan header tabel transaksi
                <tr>
                    <th>Kode Transaksi</th>
                    <th>Kasir</th>
                    <th>Total Harga</th>
                    <th>Bayar</th>
                    <th>Kembalian</th>
                    <th>Waktu</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transaksis as $t)
                // Menampilkan setiap transaksi dalam tabel
                <tr>
                    <td>{{ $t->kode_transaksi }}</td>
                    <td>{{ optional($t->user)->name ?? '-' }}</td>
                    <td>Rp {{ number_format($t->total_harga) }}</td>
                    <td>Rp {{ number_format($t->bayar) }}</td>
                    <td>Rp {{ number_format($t->kembalian) }}</td>
                    <td>{{ $t->created_at->format('d M Y, H:i') }}</td>
                    <td>
                        // Tombol untuk melihat detail, mengedit, dan menghapus transaksi
                        <a href="{{ route('transaksi.show', $t->id) }}" class="btn btn-sm btn-primary">Detail</a>
                        @if(auth()->user()->role === 'admin')
                        <a href="{{ route('transaksi.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('transaksi.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus transaksi ini?');">
                            @csrf
                            @method('DELETE')
                            // Tombol untuk menghapus transaksi
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @empty
                // Menampilkan pesan jika tidak ada transaksi
                <tr>
                    <td colspan="7" class="text-center">Belum ada transaksi untuk ditampilkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script>
    // Menginisialisasi DataTables untuk tabel transaksi
    $(document).ready(function() {
        $('#tabelTransaksi').DataTable({
            responsive: true,
            pageLength: 10,
        });
    });
</script>
@stop