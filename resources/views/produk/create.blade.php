@extends('adminlte::page')
@section('content')
<div class="card"><div class="card-body">
    <form action="{{ route('produk.store') }}" method="POST">
        @csrf
        <div class="form-group"><label>Nama Produk</label><input name="nama_produk" class="form-control" required></div>
        <div class="form-group"><label>Kategori</label>
            <select name="kategori" class="form-control">
                <option>Fruit</option><option>Americano</option><option>Coffee Latte</option>
                <option>Non Coffee</option><option>Energy Drinks</option>
            </select>
        </div>
        <div class="form-group"><label>Harga</label><input type="number" name="harga" class="form-control" required></div>
        <div class="form-group"><label>Stok</label><input type="number" name="stok" class="form-control" required></div>
        <button type="submit" class="btn btn-success">Simpan</button>
    </form>
</div></div>
@stop