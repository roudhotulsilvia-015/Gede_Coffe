@extends('adminlte::page')

@section('title', 'Detail Karyawan')

@section('content')
// Form untuk menampilkan detail data karyawan yang ada di dalam sistem.
<div class="card">
    // Bagian header kartu yang menampilkan judul "Detail Karyawan".
    <div class="card-header">
        <h3 class="card-title">Detail Karyawan</h3>
    </div>
    // Bagian isi kartu yang menampilkan tabel detail karyawan.
    <div class="card-body">
        <table class="table table-bordered">
            <tr><th>Nama</th><td>{{ $karyawan->nama }}</td></tr>
            <tr><th>Jabatan</th><td>{{ $karyawan->jabatan }}</td></tr>
            <tr><th>Telepon</th><td>{{ $karyawan->telepon }}</td></tr>
        </table>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@stop