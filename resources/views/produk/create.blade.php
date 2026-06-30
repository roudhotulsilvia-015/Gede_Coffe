@extends('adminlte::page')

@section('content')
// Form untuk menambahkan data produk baru ke dalam sistem.
<div class="card">
    // Bagian header kartu yang menampilkan judul "Tambah Produk".
    <div class="card-body">
        <form action="{{ route('produk.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="form-group">
                <label>Nama Produk</label>
                <input name="nama_produk" class="form-control @error('nama_produk') is-invalid @enderror" value="{{ old('nama_produk') }}" required>
                @error('nama_produk')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk kategori produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Kategori</label>
                <select name="kategori" class="form-control @error('kategori') is-invalid @enderror" required>
                    <option value="">Pilih kategori</option>
                    <option value="Fruit" {{ old('kategori') == 'Fruit' ? 'selected' : '' }}>Fruit</option>
                    <option value="Americano" {{ old('kategori') == 'Americano' ? 'selected' : '' }}>Americano</option>
                    <option value="Coffee Latte" {{ old('kategori') == 'Coffee Latte' ? 'selected' : '' }}>Coffee Latte</option>
                    <option value="Non Coffee" {{ old('kategori') == 'Non Coffee' ? 'selected' : '' }}>Non Coffee</option>
                    <option value="Energy Drinks" {{ old('kategori') == 'Energy Drinks' ? 'selected' : '' }}>Energy Drinks</option>
                </select>
                @error('kategori')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk harga produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Harga</label>
                <input type="number" name="harga" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga') }}" required>
                @error('harga')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk stok produk, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok') }}" required>
                @error('stok')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Tombol untuk menyimpan data produk baru ke dalam sistem.
            <button type="submit" class="btn btn-success">Simpan</button>
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