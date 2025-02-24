<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChecklistResponseRequest;
use App\Models\ChecklistResponse;
use Illuminate\Http\Request;

class ChecklistResponseController extends Controller
{
    public function index(Request $request)
    {
        $query = ChecklistResponse::query();

        if ($request->has('checklist_id')) {
            $query->where('checklist_id', $request->checklist_id);
        }

        if ($request->has('tenant_id')) {
            $query->where('tenant_id', $request->tenant_id);
        }

        if ($request->has('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        $responses = $query->with(['checklist', 'tenant', 'unit'])
            ->latest()
            ->paginate(10);

        return response()->json($responses);
    }

    public function store(ChecklistResponseRequest $request)
    {
        $response = ChecklistResponse::create($request->validated());

        return response()->json([
            'message' => 'Checklist response created successfully',
            'data' => $response
        ], 201);
    }

    public function show(ChecklistResponse $response)
    {
        return response()->json([
            'data' => $response->load(['checklist', 'tenant', 'unit'])
        ]);
    }

    public function update(ChecklistResponseRequest $request, ChecklistResponse $response)
    {
        $response->update($request->validated());

        return response()->json([
            'message' => 'Checklist response updated successfully',
            'data' => $response
        ]);
    }

    public function destroy(ChecklistResponse $response)
    {
        $response->delete();

        return response()->json([
            'message' => 'Checklist response deleted successfully'
        ]);
    }

    public function submit(ChecklistResponse $response)
    {
        $response->update([
            'status' => 'Completed',
            'completed_at' => now(),
            'completed_by' => auth()->user()->name
        ]);

        return response()->json([
            'message' => 'Checklist response submitted successfully',
            'data' => $response
        ]);
    }

    public function review(Request $request, ChecklistResponse $response)
    {
        $response->update([
            'status' => 'Reviewed',
            'reviewed_at' => now(),
            'reviewer' => auth()->user()->name,
            'notes' => $request->notes
        ]);

        return response()->json([
            'message' => 'Checklist response reviewed successfully',
            'data' => $response
        ]);
    }
}
