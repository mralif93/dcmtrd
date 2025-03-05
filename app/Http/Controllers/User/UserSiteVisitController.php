<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\SiteVisit;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class UserSiteVisitController extends Controller
{
    /**
     * Display a listing of the site visits.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $siteVisits = SiteVisit::with('property')->get();
        return view('user.site-visits.index', compact('siteVisits'));
    }

    /**
     * Show the form for creating a new site visit.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $properties = Property::where('status', 'active')->get();
        return view('user.site-visits.create', compact('properties'));
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
            'inspector_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('site-visits', 'public');
            $data['attachment'] = $attachmentPath;
        }

        $siteVisit = SiteVisit::create($data);

        return redirect()->route('site-visits-info.show', $siteVisit)
            ->with('success', 'Site visit scheduled successfully.');
    }

    /**
     * Display the specified site visit.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function show(SiteVisit $site_visits_info)
    {
        $siteVisit = $site_visits_info;
        $siteVisit->load('property');
        return view('user.site-visits.show', compact('siteVisit'));
    }

    /**
     * Show the form for editing the specified site visit.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function edit(SiteVisit $site_visits_info)
    {
        $siteVisit = $site_visits_info;
        $properties = Property::where('status', 'active')->get();
        return view('user.site-visits.edit', compact('siteVisit', 'properties'));
    }

    /**
     * Update the specified site visit in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SiteVisit $site_visits_info)
    {
        $siteVisit = $site_visits_info;
        $validator = Validator::make($request->all(), [
            'property_id' => 'required|exists:properties,id',
            'date_visit' => 'required|date',
            'time_visit' => 'required',
            'inspector_name' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $request->all();
        
        // Handle file upload
        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($siteVisit->attachment) {
                Storage::disk('public')->delete($siteVisit->attachment);
            }
            
            $attachmentPath = $request->file('attachment')->store('site-visits', 'public');
            $data['attachment'] = $attachmentPath;
        }

        $siteVisit->update($data);

        return redirect()->route('site-visits-info.show', $siteVisit)
            ->with('success', 'Site visit updated successfully.');
    }

    /**
     * Remove the specified site visit from storage.
     *
     * @param  \App\Models\SiteVisit  $siteVisit
     * @return \Illuminate\Http\Response
     */
    public function destroy(SiteVisit $site_visits_info)
    {
        $siteVisit = $site_visits_info;

        // Delete attachment if exists
        if ($siteVisit->attachment) {
            Storage::disk('public')->delete($siteVisit->attachment);
        }
        
        $siteVisit->delete();

        return redirect()->route('site-visits.index')
            ->with('success', 'Site visit deleted successfully.');
    }
}