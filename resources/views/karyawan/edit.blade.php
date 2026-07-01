@extends('adminlte::page')
@section('content') 
<div class="card"> 
    <div class="card-body">
        <form action="{{ route('karyawan.update', $karyawan->id) }}" method="POST" class="needs-validation" novalidate>
            @csrf @method('PUT')
            <div class="form-group">
                <label>Nama</label>
                <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $karyawan->nama) }}" required>
                @error('nama')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> 
            <div class="form-group">
                <label>Jabatan</label>
                <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" value="{{ old('jabatan', $karyawan->jabatan) }}" required>
                @error('jabatan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> 
            <div class="form-group">
                <label>Telepon</label>
                <input type="tel" name="telepon" class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $karyawan->telepon) }}" required>
                @error('telepon')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div> 
            <button type="submit" class="btn btn-primary">Update Data</button>
             <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
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