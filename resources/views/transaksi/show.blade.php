@extends('adminlte::page')

@section('title', 'Detail Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Transaksi: {{ $transaksi->kode_transaksi }}</h3>
    </div> 
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-md-4">    
                <p><strong>Kasir:</strong> {{ $transaksi->user?->name ?? 'Tidak tersedia' }}</p>
                <p><strong>Tanggal:</strong> {{ $transaksi->created_at->format('d M Y, H:i') }}</p>
            </div> 
            <div class="col-md-4">
                <p><strong>Total Harga:</strong> Rp {{ number_format($transaksi->total_harga) }}</p>
                <p><strong>Bayar:</strong> Rp {{ number_format($transaksi->bayar) }}</p>
            </div> 
            <div class="col-md-4">
                <p><strong>Kembalian:</strong> Rp {{ number_format($transaksi->kembalian) }}</p>
                <p><strong>Jumlah Item:</strong> {{ $transaksi->detail_transaksis->sum('jumlah') }}</p>
            </div>
        </div> 
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead> 
                    <tr>
                        <th>Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody> 
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
        <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary mt-3">Kembali</a>
    </div>
</div>
@stop