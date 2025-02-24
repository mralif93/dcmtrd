<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MaintenanceRecordRequest;
use App\Models\MaintenanceRecord;
use Illuminate\Http\Request;

class MaintenanceRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRecord::query();

        if ($request->has('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->has('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('priority')) {
            $query->where('priority', $request->priority);
        }

        $records = $query->with(['property', 'unit'])
            ->latest()
            ->paginate(10);

        return response()->json($records);
    }

    public function store(MaintenanceRecordRequest $request)
    {
        $record = MaintenanceRecord::create($request->validated());

        // If it's recurring, schedule future maintenance
        if ($request->recurring && $request->recurrence_interval) {
            // Logic for scheduling recurring maintenance
        }

        return response()->json([
            'message' => 'Maintenance record created successfully',
            'data' => $record
        ], 201);
    }

    public function show(MaintenanceRecord $record)
    {
        return response()->json([
            'data' => $record->load(['property', 'unit'])
        ]);
    }

    public function update(MaintenanceRecordRequest $request, MaintenanceRecord $record)
    {
        $record->update($request->validated());

        return response()->json([
            'message' => 'Maintenance record updated successfully',
            'data' => $record
        ]);
    }

    public function destroy(MaintenanceRecord $record)
    {
        $record->delete();

        return response()->json([
            'message' => 'Maintenance record deleted successfully'
        ]);
    }

    public function complete(Request $request, MaintenanceRecord $record)
    {
        $record->update([
            'status' => 'Completed',
            'completion_date' => now(),
            'actual_cost' => $request->actual_cost,
            'actual_time' => $request->actual_time,
            'notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'Maintenance record marked as complete',
            'data' => $record
        ]);
    }

    public function assignContractor(Request $request, MaintenanceRecord $record)
    {
        $record->update([
            'contractor_name' => $request->contractor_name,
            'contractor_contact' => $request->contractor_contact,
            'scheduled_date' => $request->scheduled_date
        ]);

        return response()->json([
            'message' => 'Contractor assigned successfully',
            'data' => $record
        ]);
    }
}
