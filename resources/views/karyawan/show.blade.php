@extends('adminlte::page')

@section('title', 'Detail Karyawan')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Detail Karyawan</h3>
    </div>
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