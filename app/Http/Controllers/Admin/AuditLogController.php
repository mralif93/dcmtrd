<?php

namespace App\Http\Controllers\Admin;

use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use OwenIt\Auditing\Models\Audit;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\StreamedResponse;

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

    public function export(Request $request): StreamedResponse
    {
        $fileName = 'audit_logs_' . now()->format('Ymd_His') . '.csv';

        $audits = Audit::with('user')
            ->when($request->search, fn($q) => $q->whereHas('user', fn($q) => $q->where('name', 'like', '%' . $request->search . '%')))
            ->when($request->start_date && $request->end_date, fn($q) => $q->whereBetween('created_at', [$request->start_date, $request->end_date]))
            ->latest()
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$fileName\"",
        ];

        $callback = function () use ($audits) {
            $handle = fopen('php://output', 'w');

            // Write CSV headers
            fputcsv($handle, ['Date', 'User', 'Event', 'Route', 'IP', 'Device', 'Changes']);

            foreach ($audits as $audit) {
                $device = 'Unknown';
                $ua = $audit->user_agent;

                if (Str::contains($ua, 'Windows')) $device = 'Windows';
                elseif (Str::contains($ua, 'Mac')) $device = 'Mac';
                elseif (Str::contains($ua, 'Linux')) $device = 'Linux';
                elseif (Str::contains($ua, ['Android', 'iPhone'])) $device = 'Mobile';

                $changes = collect($audit->new_values)->map(function ($val, $key) use ($audit) {
                    $old = $audit->old_values[$key] ?? '';
                    return "$key: " . ($old ? "$old → $val" : $val);
                })->implode(', ');

                fputcsv($handle, [
                    $audit->created_at,
                    $audit->user->name ?? 'System',
                    ucfirst($audit->event),
                    $audit->url,
                    $audit->ip_address,
                    $device,
                    $changes,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
