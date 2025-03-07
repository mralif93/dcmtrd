<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserChecklistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Checklist::with(['property']);
        
        // Search and filter functionality
        if ($request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->whereHas('property', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhere('type', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        }
        
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }
        
        if ($request->has('type') && $request->type != 'all') {
            $query->where('type', $request->type);
        }
        
        $checklists = $query->orderBy('created_at', 'desc')->paginate(10);
        
        // Get all unique statuses and types for filter dropdowns
        $statuses = Checklist::distinct()->pluck('status')->toArray();
        $types = Checklist::distinct()->pluck('type')->toArray();
        
        return view('user.checklists.index', compact('checklists', 'statuses', 'types'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        $departments = ['LD', 'OD', 'FM', 'CS']; // Example departments
        
        return view('user.checklists.create', compact('properties', 'departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'status' => 'required|string',
            'assigned_department' => 'required|string',
            'verifying_department' => 'nullable|string',
            'response_time_days' => 'nullable|integer',
            'prepared_by' => 'nullable|string',
            'prepared_date' => 'nullable|date',
        ]);
        
        try {
            DB::beginTransaction();
            
            $checklist = Checklist::create($validated);
            
            DB::commit();
            
            return redirect()->route('checklists.index')
                ->with('success', 'Checklist created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to create checklist: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $checklist->load(['property', 'documentationItems', 'tenantApprovals', 'conditionChecks', 'propertyImprovements']);
        
        return view('user.checklists.show', compact('checklist'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $properties = Property::where('status', 'active')->get();
        $departments = ['LD', 'OD', 'FM', 'CS']; // Example departments
        
        return view('user.checklists.edit', compact('checklist', 'properties', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Checklist $checklists_info)
    {
        $checklist = $checklists_info;
        $validated = $request->validate([
            'property_id' => 'required|exists:properties,id',
            'type' => 'required|string',
            'description' => 'nullable|string',
            'approval_date' => 'nullable|date',
            'status' => 'required|string',
            'assigned_department' => 'required|string',
            'verifying_department' => 'nullable|string',
            'response_time_days' => 'nullable|integer',
            'prepared_by' => 'nullable|string',
            'prepared_date' => 'nullable|date',
            'confirmed_by' => 'nullable|string',
            'confirmed_date' => 'nullable|date',
        ]);
        
        try {
            DB::beginTransaction();
            
            $checklist->update($validated);
            
            DB::commit();
            
            return redirect()->route('checklists.index')
                ->with('success', 'Checklist updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->withErrors(['error' => 'Failed to update checklist: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Checklist $checklists_info)
    {
        $checklist = $checklists_info;

        try {
            $checklist->delete();
            return redirect()->route('checklists.index')
                ->with('success', 'Checklist deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to delete checklist: ' . $e->getMessage()]);
        }
    }
}