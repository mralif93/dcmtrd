<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UnitRequest;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        $query = Unit::query();

        if ($request->has('property_id')) {
            $query->where('property_id', $request->property_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $units = $query->with(['property', 'currentLease', 'currentTenant'])
            ->latest()
            ->paginate(10);

        return response()->json($units);
    }

    public function store(UnitRequest $request)
    {
        $unit = Unit::create($request->validated());

        return response()->json([
            'message' => 'Unit created successfully',
            'data' => $unit
        ], 201);
    }

    public function show(Unit $unit)
    {
        return response()->json([
            'data' => $unit->load([
                'property',
                'leases',
                'maintenanceRecords',
                'currentLease',
                'currentTenant'
            ])
        ]);
    }

    public function update(UnitRequest $request, Unit $unit)
    {
        $unit->update($request->validated());

        return response()->json([
            'message' => 'Unit updated successfully',
            'data' => $unit
        ]);
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return response()->json([
            'message' => 'Unit deleted successfully'
        ]);
    }

    public function maintenanceHistory(Unit $unit)
    {
        $maintenanceHistory = $unit->maintenanceRecords()
            ->with('contractor')
            ->latest()
            ->get();

        return response()->json($maintenanceHistory);
    }

    public function leaseHistory(Unit $unit)
    {
        $leaseHistory = $unit->leases()
            ->with('tenant')
            ->latest()
            ->get();

        return response()->json($leaseHistory);
    }
}
