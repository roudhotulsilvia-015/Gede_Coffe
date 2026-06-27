@extends('adminlte::page')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Transaksi: {{ $transaksi->kode_transaksi }}</h3>
    </div>
    <div class="card-body">
        <p><strong>Kasir:</strong> {{ $transaksi->user?->name ?? 'Tidak tersedia' }}</p>
        <table class="table">
            <tr><th>Produk</th><th>Jumlah</th><th>Subtotal</th></tr>
            @foreach($transaksi->detail_transaksis as $d)
            <tr>
                <td>{{ $d->produk->nama_produk }}</td>
                <td>{{ $d->jumlah }}</td>
                <td>Rp {{ number_format($d->subtotal) }}</td>
            </tr>
            @endforeach
        </table>
        <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@stop