<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PropertyRequest;
use Illuminate\Http\Request;
use App\Models\Property;

class PropertyController extends Controller
{
    public function index(Request $request)
    {
        $query = Property::query();

        if ($request->has('portfolio_id')) {
            $query->where('portfolio_id', $request->portfolio_id);
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $properties = $query->with(['units', 'maintenanceRecords'])
            ->latest()
            ->paginate(10);

        return response()->json($properties);
    }

    public function store(PropertyRequest $request)
    {
        $property = Property::create($request->validated());

        return response()->json([
            'message' => 'Property created successfully',
            'data' => $property
        ], 201);
    }

    public function show(Property $property)
    {
        return response()->json([
            'data' => $property->load([
                'units', 
                'maintenanceRecords',
                'units.currentLease',
                'units.currentTenant'
            ])
        ]);
    }

    public function update(PropertyRequest $request, Property $property)
    {
        $property->update($request->validated());

        return response()->json([
            'message' => 'Property updated successfully',
            'data' => $property
        ]);
    }

    public function destroy(Property $property)
    {
        $property->delete();

        return response()->json([
            'message' => 'Property deleted successfully'
        ]);
    }

    public function vacancyReport(Property $property)
    {
        $vacancyData = [
            'total_units' => $property->units()->count(),
            'vacant_units' => $property->units()->where('status', 'Available')->count(),
            'occupied_units' => $property->units()->where('status', 'Occupied')->count(),
            'under_maintenance' => $property->units()->where('status', 'Maintenance')->count(),
            'upcoming_vacancies' => $property->units()
                ->whereHas('leases', function($query) {
                    $query->where('end_date', '<=', now()->addMonths(2))
                        ->where('end_date', '>', now());
                })->count()
        ];

        return response()->json($vacancyData);
    }
}
