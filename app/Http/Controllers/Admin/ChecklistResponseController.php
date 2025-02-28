<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ChecklistResponseRequest;
use App\Models\Checklist;
use App\Models\ChecklistResponse;
use App\Models\Tenant;
use App\Models\Unit;
use Illuminate\Http\Request;

class ChecklistResponseController extends Controller
{
    /**
     * Display a listing of the checklist responses.
     */
    public function index()
    {
        $responses = ChecklistResponse::with(['checklist', 'tenant', 'unit'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.checklist-responses.index', compact('responses'));
    }

    /**
     * Show the form for creating a new checklist response.
     */
    public function create()
    {
        $checklists = Checklist::all();
        $tenants = Tenant::all();
        $units = Unit::all();
        
        return view('admin.checklist-responses.create', compact('checklists', 'tenants', 'units'));
    }

    /**
     * Store a newly created checklist response in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'status' => 'required|in:Draft,Completed,Reviewed',
            'notes' => 'nullable|string',
            'response_data' => 'required|json',
            'images.*' => 'nullable|image|max:2048',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Process images
        $images = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('checklist-responses/images', 'public');
                $images[] = [
                    'path' => $path,
                    'name' => $image->getClientOriginalName(),
                ];
            }
        }
        
        // Process attachments
        $attachments = [];
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('checklist-responses/attachments', 'public');
                $attachments[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                ];
            }
        }
        
        $completed_at = null;
        if ($request->status === 'Completed' || $request->status === 'Reviewed') {
            $completed_at = now();
        }
        
        $response = ChecklistResponse::create([
            'checklist_id' => $request->checklist_id,
            'tenant_id' => $request->tenant_id,
            'unit_id' => $request->unit_id,
            'completed_by' => Auth::user()->name,
            'status' => $request->status,
            'completed_at' => $completed_at,
            'notes' => $request->notes,
            'response_data' => $request->response_data,
            'images' => count($images) > 0 ? $images : null,
            'attachments' => count($attachments) > 0 ? $attachments : null,
        ]);
        
        return redirect()->route('checklist-responses.show', $response)
            ->with('success', 'Checklist response created successfully.');
    }

    /**
     * Display the specified checklist response.
     */
    public function show(ChecklistResponse $checklistResponse)
    {
        $checklistResponse->load(['checklist', 'tenant', 'unit']);
        
        return view('admin.checklist-responses.show', compact('checklistResponse'));
    }

    /**
     * Show the form for editing the specified checklist response.
     */
    public function edit(ChecklistResponse $checklistResponse)
    {
        $checklists = Checklist::all();
        $tenants = Tenant::all();
        $units = Unit::all();
        
        return view('admin.checklist-responses.edit', compact('checklistResponse', 'checklists', 'tenants', 'units'));
    }

    /**
     * Update the specified checklist response in storage.
     */
    public function update(Request $request, ChecklistResponse $checklistResponse)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'unit_id' => 'required|exists:units,id',
            'tenant_id' => 'nullable|exists:tenants,id',
            'status' => 'required|in:Draft,Completed,Reviewed',
            'notes' => 'nullable|string',
            'response_data' => 'required|json',
            'images.*' => 'nullable|image|max:2048',
            'attachments.*' => 'nullable|file|max:10240',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        // Get existing images and attachments
        $images = $checklistResponse->images ?? [];
        $attachments = $checklistResponse->attachments ?? [];
        
        // Process new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('checklist-responses/images', 'public');
                $images[] = [
                    'path' => $path,
                    'name' => $image->getClientOriginalName(),
                ];
            }
        }
        
        // Process new attachments
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $index => $file) {
                $path = $file->store('checklist-responses/attachments', 'public');
                $attachments[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getClientMimeType(),
                ];
            }
        }
        
        // Update completed_at if status changes
        $completed_at = $checklistResponse->completed_at;
        if (($checklistResponse->status !== 'Completed' && $checklistResponse->status !== 'Reviewed') && 
            ($request->status === 'Completed' || $request->status === 'Reviewed')) {
            $completed_at = now();
        }
        
        // Update reviewer and reviewed_at if status is Reviewed
        $reviewer = $checklistResponse->reviewer;
        $reviewed_at = $checklistResponse->reviewed_at;
        if ($request->status === 'Reviewed' && $checklistResponse->status !== 'Reviewed') {
            $reviewer = Auth::user()->name;
            $reviewed_at = now();
        }
        
        $checklistResponse->update([
            'checklist_id' => $request->checklist_id,
            'tenant_id' => $request->tenant_id,
            'unit_id' => $request->unit_id,
            'status' => $request->status,
            'completed_at' => $completed_at,
            'reviewer' => $reviewer,
            'reviewed_at' => $reviewed_at,
            'notes' => $request->notes,
            'response_data' => $request->response_data,
            'images' => count($images) > 0 ? $images : null,
            'attachments' => count($attachments) > 0 ? $attachments : null,
        ]);
        
        return redirect()->route('checklist-responses.show', $checklistResponse)
            ->with('success', 'Checklist response updated successfully.');
    }

    /**
     * Remove the specified checklist response from storage.
     */
    public function destroy(ChecklistResponse $checklistResponse)
    {
        $checklistResponse->delete();
        
        return redirect()->route('checklist-responses.index')
            ->with('success', 'Checklist response deleted successfully.');
    }
}