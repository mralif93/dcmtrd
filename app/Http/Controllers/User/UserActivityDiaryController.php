<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityDiary;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UserActivityDiaryController extends Controller
{
    /**
     * Display a listing of activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ActivityDiary::with('issuer');
        
        // Apply filters if provided
        if ($request->filled('issuer')) {
            $query->whereHas('issuer', function($q) use ($request) {
                $q->where('issuer_name', 'like', '%' . $request->issuer . '%')
                  ->orWhere('issuer_short_name', 'like', '%' . $request->issuer . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        
        $activityDiaries = $query->latest()->paginate(10)->withQueryString();
        
        return view('user.activity-diaries.index', compact('activityDiaries'));
    }

    /**
     * Show the form for creating a new activity diary.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issuers = Issuer::all();
        return view('user.activity-diaries.create', compact('issuers'));
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
            'issuer_id' => 'required|exists:issuers,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'extension_date_1' => 'nullable|date',
            'extension_note_1' => 'nullable|string',
            'extension_date_2' => 'nullable|date',
            'extension_note_2' => 'nullable|string',
            'status' => ['nullable', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'])],
            'remarks' => 'nullable|string',
        ]);

        $validated['prepared_by'] = Auth::user()->name ?? $request->input('prepared_by');

        ActivityDiary::create($validated);

        return redirect()->route('activity-diaries-info.index')
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
        $activity_diary = $activity_diaries_info;
        return view('user.activity-diaries.show', compact('activity_diary'));
    }

    /**
     * Show the form for editing the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityDiary $activity_diaries_info)
    {
        $issuers = Issuer::all();
        return view('user.activity-diaries.edit', compact('activity_diary', 'issuers'));
    }

    /**
     * Update the specified activity diary in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ActivityDiary $activity_diaries_info)
    {
        $validated = $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'extension_date_1' => 'nullable|date',
            'extension_note_1' => 'nullable|string',
            'extension_date_2' => 'nullable|date',
            'extension_note_2' => 'nullable|string',
            'status' => ['nullable', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'])],
            'remarks' => 'nullable|string',
            'verified_by' => 'nullable|string',
        ]);

        $activity_diaries_info->update($validated);

        return redirect()->route('activity-diaries-info.index')
            ->with('success', 'Activity diary updated successfully');
    }

    /**
     * Remove the specified activity diary from storage.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function destroy(ActivityDiary $activity_diaries_info)
    {
        $activity_diaries_info->delete();

        return redirect()->route('activity-diaries-info.index')
            ->with('success', 'Activity diary deleted successfully');
    }

    /**
     * Display a listing of activity diaries by issuer ID.
     *
     * @param  int  $issuerId
     * @return \Illuminate\Http\Response
     */
    public function getByIssuer($issuerId, Request $request)
    {
        $issuer = Issuer::findOrFail($issuerId);
        $query = ActivityDiary::where('issuer_id', $issuerId);
        
        // Apply filters if provided
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('due_date')) {
            $query->whereDate('due_date', $request->due_date);
        }
        
        $activityDiaries = $query->latest()->paginate(10)->withQueryString();
        
        return view('user.activity-diaries.by-issuer', compact('activityDiaries', 'issuer'));
    }

    /**
     * Display a listing of upcoming due activity diaries.
     *
     * @return \Illuminate\Http\Response
     */
    public function upcoming(Request $request)
    {
        $today = now()->format('Y-m-d');
        $nextWeek = now()->addDays(7)->format('Y-m-d');
        
        $query = ActivityDiary::with('issuer')
            ->whereBetween('due_date', [$today, $nextWeek])
            ->where('status', '!=', 'completed');
        
        // Apply filters if provided
        if ($request->filled('issuer')) {
            $query->whereHas('issuer', function($q) use ($request) {
                $q->where('issuer_name', 'like', '%' . $request->issuer . '%')
                  ->orWhere('issuer_short_name', 'like', '%' . $request->issuer . '%');
            });
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        $activityDiaries = $query->latest()->paginate(10)->withQueryString();
        
        return view('user.activity-diaries.upcoming', compact('activityDiaries'));
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
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['pending', 'in_progress', 'completed', 'overdue', 'compiled', 'notification', 'passed'])],
        ]);

        $activity_diaries_info->update($validated);

        return redirect()->back()->with('success', 'Activity diary status updated successfully');
    }
}