@extends('adminlte::page')

@section('title', 'Detail Produk')

@section('content')
// Form untuk menampilkan detail data produk yang ada di dalam sistem.
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Produk</h3>
    </div>
    // Bagian isi kartu yang menampilkan tabel detail produk.
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Nama Produk</th><td>{{ $produk->nama_produk }}</td></tr>
            <tr><th>Kategori</th><td>{{ $produk->kategori }}</td></tr>
            <tr><th>Harga</th><td>Rp {{ number_format($produk->harga) }}</td></tr>
            <tr><th>Stok</th><td>{{ $produk->stok }}</td></tr>
        </table>
        // Tombol untuk kembali ke halaman daftar produk.
        <a href="{{ route('produk.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@stop