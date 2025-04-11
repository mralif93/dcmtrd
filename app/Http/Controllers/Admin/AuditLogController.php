<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;

class AuditLogController extends Controller
{
    public function index()
    {
        // Fetch audits with related user and only the most recent ones
        $audits = Audit::with('user')
            ->latest()
            ->paginate(10);

            // dd($audits);

        return view('admin.audit-log.index', compact('audits'));
    }
}
