<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\SiteVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiteVisitController extends Controller
{
    /**
     * Display a listing of the site visits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SiteVisit::with('property');
        
        // Filter by status if provided
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        // Filter by date range if provided
        if ($request->has('date_from') && $request->has('date_to')) {
            $query->whereBetween('date_visit', [$request->date_from, $request->date_to]);
        }
        
        $siteVisits = $query->latest()->paginate(10);
        
        return view('admin.site-visits.index', compact('siteVisits'));
    }

    /**
     * Show the form for creating a new site visit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        $statuses = ['active', 'pending', 'rejected', 'scheduled', 'completed', 'cancelled'];
        
        return view('admin.site-visits.create', compact('properties', 'statuses'));
    }

    /**
     * Store a newly created site visit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'date_visit' => 'required|date',
            'time_visit' => 'required',
            'trustee' => 'nullable|string|max:255',
            'manager' => 'nullable|string|max:255',
            'maintenance_manager' => 'nullable|string|max:255',
            'building_manager' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required|string|in:active,rejected,scheduled,completed,cancelled,pending',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->except('attachment');
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('site-visits', $filename, 'public');
            $data['attachment'] = $filePath;
        }
        
        // Set approval datetime if status is completed
        if ($request->status === 'completed' && !empty($request->verified_by)) {
            $data['approval_datetime'] = now();
        }
        
        SiteVisit::create($data);
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit scheduled successfully');
    }

    /**
     * Display the specified site visit.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function show(SiteVisit $siteVisit)
    {
        $siteVisit->load('property', 'checklist');
        
        return view('admin.site-visits.show', compact('siteVisit'));
    }

    /**
     * Show the form for editing the specified site visit.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteVisit $siteVisit)
    {
        $properties = Property::where('status', 'active')->get();
        $statuses = ['active', 'pending', 'rejected', 'scheduled', 'completed', 'cancelled'];
        
        return view('admin.site-visits.edit', compact('siteVisit', 'properties', 'statuses'));
    }

    /**
     * Update the specified site visit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteVisit $siteVisit)
    {
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'date_visit' => 'required|date',
            'time_visit' => 'required',
            'trustee' => 'nullable|string|max:255',
            'manager' => 'nullable|string|max:255',
            'maintenance_manager' => 'nullable|string|max:255',
            'building_manager' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required|string|in:active,rejected,scheduled,completed,cancelled,pending',
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = $request->except('attachment');
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($siteVisit->attachment) {
                Storage::disk('public')->delete($siteVisit->attachment);
            }
            
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('site-visits', $filename, 'public');
            $data['attachment'] = $filePath;
        }
        
        // Update approval datetime if status changed to completed and verified_by is set
        if ($request->status === 'completed' && !empty($request->verified_by) && 
            ($siteVisit->status !== 'completed' || empty($siteVisit->approval_datetime))) {
            $data['approval_datetime'] = now();
        }
        
        $siteVisit->update($data);
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit updated successfully');
    }

    /**
     * Remove the specified site visit from storage.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteVisit $siteVisit)
    {
        // Delete the file if exists
        if ($siteVisit->attachment) {
            Storage::disk('public')->delete($siteVisit->attachment);
        }
        
        $siteVisit->delete();
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit deleted successfully');
    }

    /**
     * Download the attachment file.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function downloadAttachment(SiteVisit $siteVisit)
    {
        if (!$siteVisit->hasAttachment()) {
            return redirect()->back()->with('error', 'No attachment found');
        }
        
        return Storage::disk('public')->download($siteVisit->attachment);
    }
    
    /**
     * Display upcoming site visits.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $siteVisits = SiteVisit::upcoming()->with('property')->paginate(10);
        
        return view('admin.site-visits.upcoming', compact('siteVisits'));
    }
    
    /**
     * Mark site visit as completed.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markAsCompleted(SiteVisit $siteVisit, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'verified_by' => 'required|string|max:255',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $data = [
            'status' => 'completed',
            'notes' => $request->notes,
            'verified_by' => $request->verified_by,
            'approval_datetime' => now(),
        ];
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($siteVisit->attachment) {
                Storage::disk('public')->delete($siteVisit->attachment);
            }
            
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('site-visits', $filename, 'public');
            $data['attachment'] = $filePath;
        }
        
        $siteVisit->update($data);
        
        return redirect()->route('site-visits.show', $siteVisit)
            ->with('success', 'Site visit marked as completed');
    }
    
    /**
     * Mark site visit as cancelled.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markAsCancelled(SiteVisit $siteVisit, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'notes' => 'required|string',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $siteVisit->update([
            'status' => 'cancelled',
            'notes' => $request->notes,
        ]);
        
        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit cancelled successfully');
    }
}