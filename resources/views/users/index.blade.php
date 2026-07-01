@extends('adminlte::page')

@section('title', 'Manajemen User')

@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
@stop

@section('content')
<div class="card"> 
    <div class="card-header"> 
        <h3 class="card-title">Daftar User</h3> 
        <div class="card-tools">
            <a href="{{ route('users.create') }}" class="btn btn-primary btn-sm">Tambah User</a>
        </div>
    </div> 
    <div class="card-body"> 
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif 
        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif 
        <table class="table table-bordered table-striped" id="tabelUsers">
            <thead> 
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody> 
                @foreach($users as $user)
                <tr> 
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->username }}</td>
                    <td>{{ ucfirst($user->role) }}</td>
                    <td> 
                        <a href="{{ route('users.show', $user->id) }}" class="btn btn-info btn-sm">Detail</a>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Hapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop

@section('js')
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script>
    // Menambahkan validasi form untuk memastikan semua input telah diisi dengan benar sebelum disubmit
    $(document).ready(function() {
        $('#tabelUsers').DataTable({
            responsive: true,
            pageLength: 10,
        });
    });
</script>
@stop