@extends('adminlte::page')

@section('content')
<div class="card">
    // Bagian header kartu yang menampilkan judul "Edit Produk".
    <div class="card-body">
        <form action="{{ route('produk.update', $produk->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama Produk</label>
                <input name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk', $produk->nama_produk) }}" required>
                @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk kategori produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="">Pilih kategori</option>
                    <option value="Fruit" {{ old('kategori', $produk->kategori) == 'Fruit' ? 'selected' : '' }}>Fruit</option>
                    <option value="Americano" {{ old('kategori', $produk->kategori) == 'Americano' ? 'selected' : '' }}>Americano</option>
                    <option value="Coffee Latte" {{ old('kategori', $produk->kategori) == 'Coffee Latte' ? 'selected' : '' }}>Coffee Latte</option>
                    <option value="Non Coffee" {{ old('kategori', $produk->kategori) == 'Non Coffee' ? 'selected' : '' }}>Non Coffee</option>
                    <option value="Energy Drinks" {{ old('kategori', $produk->kategori) == 'Energy Drinks' ? 'selected' : '' }}>Energy Drinks</option>
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk harga produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $produk->harga) }}" required>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk stok produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $produk->stok) }}" required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Tombol untuk menyimpan perubahan data produk ke dalam sistem.
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>
@stop

@section('js')
<script>
    // Script untuk validasi form sebelum dikirimkan ke server, memastikan semua input wajib diisi.
    document.addEventListener('DOMContentLoaded', function() {
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    });
</script>
@stop