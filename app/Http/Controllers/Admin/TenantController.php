<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\TenantRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;

class TenantController extends Controller
{
    public function index(Request $request)
    {
        $query = Tenant::query();

        if ($request->has('status')) {
            $query->where('active_status', $request->status);
        }

        $tenants = $query->with(['currentLease', 'currentUnit'])
            ->latest()
            ->paginate(10);

        return response()->json($tenants);
    }

    public function store(TenantRequest $request)
    {
        $tenant = Tenant::create($request->validated());

        return response()->json([
            'message' => 'Tenant created successfully',
            'data' => $tenant
        ], 201);
    }

    public function show(Tenant $tenant)
    {
        return response()->json([
            'data' => $tenant->load([
                'leases',
                'currentLease',
                'currentUnit',
                'checklistResponses'
            ])
        ]);
    }

    public function update(TenantRequest $request, Tenant $tenant)
    {
        $tenant->update($request->validated());

        return response()->json([
            'message' => 'Tenant updated successfully',
            'data' => $tenant
        ]);
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();

        return response()->json([
            'message' => 'Tenant deleted successfully'
        ]);
    }

    public function rentalHistory(Tenant $tenant)
    {
        $rentalHistory = $tenant->leases()
            ->with(['unit', 'unit.property'])
            ->latest()
            ->get();

        return response()->json($rentalHistory);
    }

    public function documents(Tenant $tenant)
    {
        $documents = [
            'lease_agreements' => $tenant->leases()->with('documents')->get(),
            'background_checks' => $tenant->backgroundChecks,
            'checklists' => $tenant->checklistResponses()->with('checklist')->get(),
        ];

        return response()->json($documents);
    }
}
