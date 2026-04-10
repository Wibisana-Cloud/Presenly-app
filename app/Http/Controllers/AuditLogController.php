<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request): \Illuminate\View\View
    {
        $search = $request->input('search', '');
        $aksi = $request->input('aksi', '');

        $logs = AuditLog::with('user')
            ->when($search, fn ($q) => $q->whereHas('user', fn ($u) => $u->where('name', 'like', "%$search%")))
            ->when($aksi, fn ($q) => $q->where('aksi', $aksi))
            ->orderBy('created_at', 'desc')
            ->paginate(25)
            ->withQueryString();

        $aksiList = AuditLog::distinct()->orderBy('aksi')->pluck('aksi');

        return view('admin.audit_log', compact('logs', 'search', 'aksi', 'aksiList'));
    }
}
