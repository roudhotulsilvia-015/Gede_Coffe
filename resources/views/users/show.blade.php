@extends('adminlte::page')

@section('title', 'Detail User')

@section('content')
<div class="card">
    // Menampilkan header untuk detail user
    <div class="card-header">
        // Menampilkan judul detail user
        <h3 class="card-title">Detail User</h3>
    </div>
    // Menampilkan body untuk detail user
    <div class="card-body">
        <table class="table table-bordered">
            // Menampilkan detail user termasuk nama, username, role, dan tanggal dibuat
            <tr><th>Nama</th><td>{{ $user->name }}</td></tr>
            <tr><th>Username</th><td>{{ $user->username }}</td></tr>
            <tr><th>Role</th><td>{{ ucfirst($user->role) }}</td></tr>
            <tr><th>Dibuat pada</th><td>{{ $user->created_at->format('d M Y H:i') }}</td></tr>
        </table>
        // Tombol untuk kembali ke halaman daftar user
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Kembali</a>
    </div>
</div>
@stop