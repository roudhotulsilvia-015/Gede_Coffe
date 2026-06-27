<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    public function index()
    {
        $sessions = DB::table('sessions')
            ->join('users', 'sessions.user_id', '=', 'users.id')
            ->select('sessions.id', 'users.name', 'users.username', 'users.role', 'sessions.ip_address', 'sessions.user_agent', 'sessions.last_activity')
            ->orderByDesc('sessions.last_activity')
            ->get();

        return view('sessions.index', compact('sessions'));
    }

    public function destroy(string $id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        return redirect()->route('sessions.index')->with('success', 'Sesi berhasil diakhiri.');
    }
}
