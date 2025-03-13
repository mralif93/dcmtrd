<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityDiary;
use App\Models\Bond;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ActivityDiaryController extends Controller
{
    /**
     * Display a listing of activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $activityDiaries = ActivityDiary::with('bond.issuer')->latest()->paginate(10);
        return view('admin.activity-diaries.index', compact('activityDiaries'));
    }

    /**
     * Show the form for creating a new activity diary.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bonds = Bond::with('issuer')->get();
        return view('admin.activity-diaries.create', compact('bonds'));
    }

    /**
     * Store a newly created activity diary in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'status' => ['nullable', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue'])],
            'remarks' => 'nullable|string',
        ]);

        $validated['prepared_by'] = Auth::user()->name ?? $request->input('prepared_by');

        ActivityDiary::create($validated);

        return redirect()->route('activity-diaries.index')
            ->with('success', 'Activity diary created successfully');
    }

    /**
     * Display the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function show(ActivityDiary $activity_diaries_info)
    {
        $activityDiary = $activity_diaries_info;
        return view('admin.activity-diaries.show', compact('activityDiary'));
    }

    /**
     * Show the form for editing the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityDiary $activity_diaries_info)
    {
        $activityDiary = $activity_diaries_info;
        $bonds = Bond::with('issuer')->get();
        return view('admin.activity-diaries.edit', compact('activityDiary', 'bonds'));
    }

    /**
     * Update the specified activity diary in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityDiary $activityDiary)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'status' => ['nullable', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue'])],
            'remarks' => 'nullable|string',
            'verified_by' => 'nullable|string',
        ]);

        $activityDiary->update($validated);

        return redirect()->route('activity-diaries.index')
            ->with('success', 'Activity diary updated successfully');
    }

    /**
     * Remove the specified activity diary from storage.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityDiary $activityDiary)
    {
        $activityDiary->delete();

        return redirect()->route('activity-diaries-info.index')
            ->with('success', 'Activity diary deleted successfully');
    }

    /**
     * Display a listing of activity diaries by bond ID.
     *
     * @param  int  $bondId
     * @return \Illuminate\Http\Response
     */
    public function getByBond($bondId)
    {
        $bond = Bond::with('issuer')->findOrFail($bondId);
        $activityDiaries = ActivityDiary::where('bond_id', $bondId)->latest()->paginate(10);
        
        return view('admin.activity-diaries.by-bond', compact('activityDiaries', 'bond'));
    }

    /**
     * Display a listing of upcoming due activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming()
    {
        $today = now()->format('Y-m-d');
        $nextWeek = now()->addDays(7)->format('Y-m-d');
        
        $activityDiaries = ActivityDiary::with('bond.issuer')
            ->whereBetween('due_date', [$today, $nextWeek])
            ->where('status', '!=', 'completed')
            ->latest()
            ->paginate(10);
        
        return view('admin.activity-diaries.upcoming', compact('activityDiaries'));
    }

    /**
     * Update the status of the activity diary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, ActivityDiary $activity_diaries_info)
    {
        $activityDiary = $activity_diaries_info;
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue'])],
        ]);

        $activityDiary->update($validated);

        return redirect()->back()->with('success', 'Activity diary status updated successfully');
    }
}
