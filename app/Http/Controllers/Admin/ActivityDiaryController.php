<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityDiary;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ActivityDiaryController extends Controller
{
    /**
     * Display a listing of activity diaries with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ActivityDiary::with('issuer');

        // Filter by issuer name
        if ($request->filled('issuer')) {
            $issuerSearch = $request->input('issuer');
            $query->whereHas('issuer', function($q) use ($issuerSearch) {
                $q->where('issuer_name', 'like', '%' . $issuerSearch . '%')
                ->orWhere('issuer_short_name', 'like', '%' . $issuerSearch . '%');
            });
        }

        // Filter by purpose
        if ($request->filled('purpose')) {
            $query->where('purpose', 'like', '%' . $request->input('purpose') . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by due date
        if ($request->filled('due_date')) {
            $dueDate = $request->input('due_date');
            $query->where(function($q) use ($dueDate) {
                $q->where('due_date', $dueDate)
                ->orWhere('extension_date_1', $dueDate)
                ->orWhere('extension_date_2', $dueDate);
            });
        }

        // Apply sorting
        $activityDiaries = $query->latest()->paginate(10);

        // Append query parameters to pagination links
        $activityDiaries->appends($request->all());

        return view('admin.activity-diaries.index', compact('activityDiaries'));
    }

    /**
     * Show the form for creating a new activity diary.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issuers = Issuer::all();
        return view('admin.activity-diaries.create', compact('issuers'));
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
            'status' => ['nullable', 'string', Rule::in(['passed', 'complied', 'notification'])],
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
    public function show(ActivityDiary $activityDiary)
    {
        $activityDiary->load('issuer');
        return view('admin.activity-diaries.show', compact('activityDiary'));
    }

    /**
     * Show the form for editing the specified activity diary.
     *
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function edit(ActivityDiary $activityDiary)
    {
        $issuers = Issuer::all();
        return view('admin.activity-diaries.edit', compact('activityDiary', 'issuers'));
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
            'issuer_id' => 'required|exists:issuers,id',
            'purpose' => 'nullable|string',
            'letter_date' => 'nullable|date',
            'due_date' => 'nullable|date',
            'extension_date_1' => 'nullable|date',
            'extension_note_1' => 'nullable|string',
            'extension_date_2' => 'nullable|date',
            'extension_note_2' => 'nullable|string',
            'status' => ['nullable', 'string', Rule::in(['passed', 'complied', 'notification'])],
            'remarks' => 'nullable|string',
            'verified_by' => 'nullable|string',
        ]);

        $activityDiary->update($validated);

        return redirect()->route('activity-diaries.index')
            ->with('success', 'Activity diary updated successfully');
    }

    /**
     * Add an extension to an activity diary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function addExtension(Request $request, ActivityDiary $activityDiary)
    {
        $validated = $request->validate([
            'extension_date' => 'required|date',
            'extension_note' => 'nullable|string',
        ]);
        
        // Check which extension slot to fill
        if (!$activityDiary->extension_date_1) {
            $activityDiary->extension_date_1 = $validated['extension_date'];
            $activityDiary->extension_note_1 = $validated['extension_note'] ?? '(1st Extension)';
        } elseif (!$activityDiary->extension_date_2) {
            $activityDiary->extension_date_2 = $validated['extension_date'];
            $activityDiary->extension_note_2 = $validated['extension_note'] ?? '(2nd Extension)';
        } else {
            return redirect()->back()->with('error', 'Cannot add more than two extensions.');
        }
        
        $activityDiary->save();
        
        return redirect()->back()->with('success', 'Extension added successfully');
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

        return redirect()->route('activity-diaries.index')
            ->with('success', 'Activity diary deleted successfully');
    }

    /**
     * Display a listing of activity diaries by issuer ID with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $issuerId
     * @return \Illuminate\Http\Response
     */
    public function getByIssuer(Request $request, $issuerId)
    {
        $issuer = Issuer::findOrFail($issuerId);
        
        $query = ActivityDiary::where('issuer_id', $issuerId);
        
        // Filter by purpose
        if ($request->filled('purpose')) {
            $query->where('purpose', 'like', '%' . $request->input('purpose') . '%');
        }

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filter by due date
        if ($request->filled('due_date')) {
            $dueDate = $request->input('due_date');
            $query->where(function($q) use ($dueDate) {
                $q->where('due_date', $dueDate)
                ->orWhere('extension_date_1', $dueDate)
                ->orWhere('extension_date_2', $dueDate);
            });
        }
        
        // Apply sorting
        $activityDiaries = $query->latest()->paginate(10);
        
        // Append query parameters to pagination links
        $activityDiaries->appends($request->all());
        
        return view('admin.activity-diaries.by-issuer', compact('activityDiaries', 'issuer'));
    }

    /**
     * Display a listing of upcoming due activity diaries with filters.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upcoming(Request $request)
    {
        $today = now()->format('Y-m-d');
        $nextWeek = now()->addDays(7)->format('Y-m-d');
        
        // Start with the base query
        $query = ActivityDiary::with('issuer');
        
        // Filter for upcoming dates
        $query->where(function($query) use ($today, $nextWeek) {
            $query->whereBetween('due_date', [$today, $nextWeek])
                ->orWhereBetween('extension_date_1', [$today, $nextWeek])
                ->orWhereBetween('extension_date_2', [$today, $nextWeek]);
        })
        ->whereNotIn('status', ['complied', 'passed']);
        
        // Apply additional filters
        // Filter by issuer name
        if ($request->filled('issuer')) {
            $issuerSearch = $request->input('issuer');
            $query->whereHas('issuer', function($q) use ($issuerSearch) {
                $q->where('issuer_name', 'like', '%' . $issuerSearch . '%')
                ->orWhere('issuer_short_name', 'like', '%' . $issuerSearch . '%');
            });
        }

        // Filter by purpose
        if ($request->filled('purpose')) {
            $query->where('purpose', 'like', '%' . $request->input('purpose') . '%');
        }
        
        // Apply sorting
        $activityDiaries = $query->latest()->paginate(10);
        
        // Append query parameters to pagination links
        $activityDiaries->appends($request->all());
        
        return view('admin.activity-diaries.upcoming', compact('activityDiaries'));
    }

    /**
     * Update the status of the activity diary.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ActivityDiary  $activityDiary
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, ActivityDiary $activityDiary)
    {
        $validated = $request->validate([
            'status' => ['required', 'string', Rule::in(['passed', 'complied', 'notification'])],
        ]);

        $activityDiary->update($validated);

        return redirect()->back()->with('success', 'Activity diary status updated successfully');
    }
}