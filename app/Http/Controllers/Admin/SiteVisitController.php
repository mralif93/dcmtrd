<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SiteVisitRequest;
use App\Models\SiteVisit;
use Illuminate\Http\Request;

class SiteVisitController extends Controller
{
    public function index(Request $request)
    {
        $query = SiteVisit::query();

        if ($request->has('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->has('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->has('visit_status')) {
            $query->where('visit_status', $request->visit_status);
        }

        $visits = $query->with(['property', 'unit', 'tenant'])
            ->latest()
            ->paginate(10);

        return response()->json($visits);
    }

    public function store(SiteVisitRequest $request)
    {
        $visit = SiteVisit::create($request->validated());

        return response()->json([
            'message' => 'Site visit scheduled successfully',
            'data' => $visit
        ], 201);
    }

    public function show(SiteVisit $visit)
    {
        return response()->json([
            'data' => $visit->load(['property', 'unit', 'tenant'])
        ]);
    }

    public function update(SiteVisitRequest $request, SiteVisit $visit)
    {
        $visit->update($request->validated());

        return response()->json([
            'message' => 'Site visit updated successfully',
            'data' => $visit
        ]);
    }

    public function destroy(SiteVisit $visit)
    {
        $visit->delete();

        return response()->json([
            'message' => 'Site visit deleted successfully'
        ]);
    }

    public function recordVisit(Request $request, SiteVisit $visit)
    {
        $visit->update([
            'actual_visit_start' => $request->start_time,
            'actual_visit_end' => $request->end_time,
            'visitor_feedback' => $request->feedback,
            'agent_notes' => $request->notes,
            'interested' => $request->interested,
            'visit_status' => 'Completed'
        ]);

        return response()->json([
            'message' => 'Visit details recorded successfully',
            'data' => $visit
        ]);
    }

    public function cancel(Request $request, SiteVisit $visit)
    {
        $visit->update([
            'visit_status' => 'Cancelled',
            'agent_notes' => $request->cancellation_reason
        ]);

        return response()->json([
            'message' => 'Site visit cancelled successfully',
            'data' => $visit
        ]);
    }

    public function reschedule(Request $request, SiteVisit $visit)
    {
        $visit->update([
            'visit_date' => $request->new_date,
            'visit_status' => 'Rescheduled',
            'agent_notes' => $request->reschedule_reason
        ]);

        return response()->json([
            'message' => 'Site visit rescheduled successfully',
            'data' => $visit
        ]);
    }
}
