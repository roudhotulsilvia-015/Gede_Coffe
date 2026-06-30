@extends('adminlte::page')

@section('content')
// Form untuk menambahkan data karyawan baru ke dalam sistem.
<div class="card">
    // Bagian header kartu yang menampilkan judul "Tambah Karyawan".
    <div class="card-body">
        <form action="{{ route('karyawan.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            // Input untuk nama karyawan, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama') }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk jabatan karyawan, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan') }}" required>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Input untuk nomor telepon karyawan, wajib diisi dan divalidasi.
            <div class="form-group">
                <label>Telepon</label>
                <input type="tel" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon') }}" required>
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            // Tombol untuk menyimpan data karyawan baru ke dalam sistem.
            <button type="submit" class="btn btn-success">Simpan Data</button>
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