<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;

class AuditLogController extends Controller
{
    public function index(Request $req): View
    {
        // Base query to fetch audits with user
        $query = Audit::with('user');

        // Apply search filter using 'when' with arrow function
        $query->when(
            $req->has('search') && $req->search,
            fn($q) =>
            $q->whereHas(
                'user',
                fn($q) =>
                $q->where('name', 'like', '%' . $req->search . '%')
            )
        );

        // Apply date range filter using 'when' with arrow function
        $query->when(
            $req->has('start_date') && $req->has('end_date') && $req->start_date && $req->end_date,
            fn($q) => $q->whereBetween('created_at', [$req->start_date, $req->end_date])
        );

        // Fetch filtered audits
        $audits = $query->latest()->paginate(10);
        // Return view with audits
        return view('admin.audit-log.index', compact('audits'));
    }
}
