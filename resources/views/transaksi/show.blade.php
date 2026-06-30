@extends('adminlte::page')

@section('title', 'Detail Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Transaksi: {{ $transaksi->kode_transaksi }}</h3>
    </div>
    // Menampilkan detail transaksi termasuk kasir, tanggal, total harga, bayar, kembalian, dan jumlah item
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">
                // Menampilkan informasi kasir dan tanggal transaksi    
                <p><strong>Kasir:</strong> {{ $transaksi->user?->name ?? 'Tidak tersedia' }}</p>
                <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y, H:i') }}</p>
            </div>
            // Menampilkan informasi total harga dan bayar
            <div class="col-md-4">
                <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga) }}</p>
                <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar) }}</p>
            </div>
            // Menampilkan informasi kembalian dan jumlah item
            <div class="col-md-4">
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian) }}</p>
                <p><strong>Jumlah Item:</strong> {{ $transaksi->detail_transaksis->sum('jumlah') }}</p>
            </div>
        </div>
// Menampilkan tabel detail produk yang dibeli dalam transaksi
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    // Menampilkan header tabel detail produk
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    // Menampilkan setiap produk yang dibeli dalam transaksi
                    @foreach($transaksi->detail_transaksis as $d)
                    <tr>
                        <td>{{ $d->produk->nama_produk }}</td>
                        <td>Rp {{ number_format($d->produk->harga) }}</td>
                        <td>{{ $d->jumlah }}</td>
                        <td>Rp {{ number_format($d->subtotal) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
// Tombol untuk kembali ke halaman riwayat transaksi
        <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@stop