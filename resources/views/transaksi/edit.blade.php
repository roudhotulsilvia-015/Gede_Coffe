@extends('adminlte::page')

@section('title', 'Edit Transaksi')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Transaksi {{ $transaksi->kode_transaksi }}</h3>
    </div> 
    <div class="card-body">
        <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Kode Transaksi</label>
                <input type="text" class="form-control" value="{{ $transaksi->kode_transaksi }}" disabled>
            </div> 
            <div class="form-group">
                <label>Total Harga</label>
                <input type="text" class="form-control" value="Rp {{ number_format($transaksi->total_harga) }}" disabled>
            </div> 
            <div class="form-group">
                <label>Bayar</label>
                <input type="number" name="bayar" class="form-control" value="{{ old('bayar', $transaksi->bayar) }}" required>
                @error('bayar') <span class="text-danger">{{ $message }}</span> @enderror
            </div> 
            <div class="form-group">
                <label>Kembalian</label>
                <input type="text" class="form-control" value="Rp {{ number_format($transaksi->kembalian) }}" disabled>
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('transaksi.riwayat') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>
</div>
@stop
