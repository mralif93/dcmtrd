<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LeaseRequest;
use App\Models\Lease;
use Illuminate\Http\Request;

class LeaseController extends Controller
{
    public function index(Request $request)
    {
        $query = Lease::query();

        if ($request->has('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $leases = $query->with(['tenant', 'unit', 'unit.property'])
            ->latest()
            ->paginate(10);

        return response()->json($leases);
    }

    public function store(LeaseRequest $request)
    {
        $lease = Lease::create($request->validated());

        return response()->json([
            'message' => 'Lease created successfully',
            'data' => $lease
        ], 201);
    }

    public function show(Lease $lease)
    {
        return response()->json([
            'data' => $lease->load(['tenant', 'unit', 'unit.property'])
        ]);
    }

    public function update(LeaseRequest $request, Lease $lease)
    {
        $lease->update($request->validated());

        return response()->json([
            'message' => 'Lease updated successfully',
            'data' => $lease
        ]);
    }

    public function destroy(Lease $lease)
    {
        $lease->delete();

        return response()->json([
            'message' => 'Lease deleted successfully'
        ]);
    }

    public function renew(LeaseRequest $request, Lease $lease)
    {
        $newLease = $lease->replicate();
        $newLease->start_date = $request->start_date;
        $newLease->end_date = $request->end_date;
        $newLease->monthly_rent = $request->monthly_rent;
        $newLease->status = 'Active';
        $newLease->save();

        $lease->status = 'Completed';
        $lease->save();

        return response()->json([
            'message' => 'Lease renewed successfully',
            'data' => $newLease
        ]);
    }

    public function terminate(Request $request, Lease $lease)
    {
        $lease->update([
            'status' => 'Terminated',
            'termination_reason' => $request->reason,
            'end_date' => now()
        ]);

        return response()->json([
            'message' => 'Lease terminated successfully',
            'data' => $lease
        ]);
    }
}