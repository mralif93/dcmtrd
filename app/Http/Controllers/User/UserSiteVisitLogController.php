<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SiteVisit;
use App\Models\SiteVisitLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserSiteVisitLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = SiteVisitLog::with('siteVisit');

        // Apply filters if provided
        if ($request->has('status')) {
            $query->withStatus($request->status);
        }

        if ($request->has('follow_up')) {
            $query->where('follow_up_required', $request->follow_up == 'true');
        }

        if ($request->has('from_date') && $request->has('to_date')) {
            $query->dateBetween($request->from_date, $request->to_date);
        }

        $siteVisitLogs = $query->orderBy('visitation_date', 'desc')->paginate(10);

        return view('user.site-visit-logs.index', compact('siteVisitLogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $siteVisits = SiteVisit::all();
        return view('user.site-visit-logs.create', compact('siteVisits'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_visit_id' => 'required|exists:site_visits,id',
            'no' => 'required|integer',
            'visitation_date' => 'required|date',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'report_submission_date' => 'nullable|date',
            'report_attachment' => 'nullable|file|mimes:pdf|max:10240',
            'follow_up_required' => 'nullable|boolean',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Handle file upload if present
        if ($request->hasFile('report_attachment')) {
            $path = $request->file('report_attachment')->store('reports', 'public');
            $data['report_attachment'] = $path;
        }

        // Convert checkbox value
        $data['follow_up_required'] = $request->has('follow_up_required');

        $siteVisitLog = SiteVisitLog::create($data);

        return redirect()->route('site-visit-logs-info.index')
            ->with('success', 'Site visit log created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(SiteVisitLog $site_visit_logs_info)
    {
        $siteVisitLog = $site_visit_logs_info;
        $siteVisitLog->load('siteVisit');
        return view('user.site-visit-logs.show', compact('siteVisitLog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SiteVisitLog $site_visit_logs_info)
    {
        $siteVisitLog = $site_visit_logs_info;
        $siteVisits = SiteVisit::all();
        return view('user.site-visit-logs.edit', compact('siteVisitLog', 'siteVisits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SiteVisitLog $site_visit_logs_info)
    {
        $siteVisitLog = $site_visit_logs_info;
        $validator = Validator::make($request->all(), [
            'site_visit_id' => 'required|exists:site_visits,id',
            'no' => 'required|integer',
            'visitation_date' => 'required|date',
            'purpose' => 'required|string',
            'status' => 'required|string',
            'report_submission_date' => 'nullable|date',
            'report_attachment' => 'nullable|file|mimes:pdf|max:10240',
            'follow_up_required' => 'nullable|boolean',
            'remarks' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Handle file upload if present
        if ($request->hasFile('report_attachment')) {
            // Delete old file if exists
            if ($siteVisitLog->report_attachment) {
                Storage::disk('public')->delete($siteVisitLog->report_attachment);
            }
            
            $path = $request->file('report_attachment')->store('reports', 'public');
            $data['report_attachment'] = $path;
        }

        // Convert checkbox value
        $data['follow_up_required'] = $request->has('follow_up_required');

        $siteVisitLog->update($data);

        return redirect()->route('site-visit-logs.index')
            ->with('success', 'Site visit log updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SiteVisitLog $site_visit_logs_info)
    {
        $siteVisitLog = $site_visit_logs_info;

        // Delete the file if it exists
        if ($siteVisitLog->report_attachment) {
            Storage::disk('public')->delete($siteVisitLog->report_attachment);
        }
        
        $siteVisitLog->delete();

        return redirect()->route('site-visit-logs.index')
            ->with('success', 'Site visit log deleted successfully.');
    }

    /**
     * Download the report attachment.
     */
    public function downloadReport(SiteVisitLog $site_visit_logs_info)
    {
        $siteVisitLog = $site_visit_logs_info;

        if (!$siteVisitLog->report_attachment) {
            return redirect()->back()->with('error', 'No report attachment found.');
        }

        return Storage::disk('public')->download(
            $siteVisitLog->report_attachment, 
            'Report - ' . $siteVisitLog->visitation_date . '.pdf'
        );
    }
}
