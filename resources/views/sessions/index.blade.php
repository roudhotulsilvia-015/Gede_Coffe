@extends('adminlte::page')

@section('title', 'Sesi Aktif')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Sesi Aktif Pengguna</h3>
    </div>
    <div class="card-body">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table class="table table-bordered table-striped" id="tabelSessions">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>IP Address</th>
                    <th>User Agent</th>
                    <th>Terakhir Aktif</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->username }}</td>
                    <td>{{ ucfirst($session->role) }}</td>
                    <td>{{ $session->ip_address ?? '-' }}</td>
                    <td>{{ Str::limit($session->user_agent, 45) }}</td>
                    <td>{{ date('d M Y H:i:s', $session->last_activity) }}</td>
                    <td>
                        <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" onsubmit="return confirm('Akhiri sesi ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm">Keluarkan</button>
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
    $(document).ready(function() {
        $('#tabelSessions').DataTable({ responsive: true, pageLength: 10 });
    });
</script>
@stop
