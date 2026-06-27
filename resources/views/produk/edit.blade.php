@extends('adminlte::page')
@section('content')
<div class="card"><div class="card-body">
    <form action="{{ route('produk.update', $produk->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="form-group"><label>Nama</label><input name="nama_produk" class="form-control" value="{{ $produk->nama_produk }}" required></div>
        <div class="form-group"><label>Kategori</label><input name="kategori" class="form-control" value="{{ $produk->kategori }}" required></div>
        <div class="form-group"><label>Harga</label><input type="number" name="harga" class="form-control" value="{{ $produk->harga }}" required></div>
        <div class="form-group"><label>Stok</label><input type="number" name="stok" class="form-control" value="{{ $produk->stok }}" required></div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div></div>
@stop