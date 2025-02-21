<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\CallSchedule;
use Illuminate\Http\Request;

class UserCallScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $callSchedules = CallSchedule::with('redemption.bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereDate('start_date', $searchTerm)
                      ->orWhereDate('end_date', $searchTerm)
                      ->orWhere('call_price', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('user.call-schedules.index', [
            'callSchedules' => $callSchedules,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $redemptions = Redemption::with('bond')->get();
        return view('user.call-schedules.create', compact('redemptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'call_price' => 'required|numeric|min:0|max:99999999999999.99',
        ]);

        // Check for overlapping schedules
        $exists = CallSchedule::where('redemption_id', $validated['redemption_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'A call schedule already exists for this period'])->withInput();
        }

        try {
            $callSchedule = CallSchedule::create($validated);
            return redirect()->route('call-schedules-info.show', $callSchedule)->with('success', 'Call schedule created successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(CallSchedule $call_schedules_info)
    {
        $schedule = $call_schedules_info;
        $schedule->load('redemption.bond');
        return view('user.call-schedules.show', compact('schedule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallSchedule $call_schedules_info)
    {
        $schedule = $call_schedules_info;
        $redemptions = Redemption::with('bond')->get();
        return view('user.call-schedules.edit', compact('schedule', 'redemptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallSchedule $call_schedules_info)
    {
        $callSchedule = $call_schedules_info;
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'call_price' => 'required|numeric|min:0|max:99999999999999.99',
        ]);

        // Check for overlapping schedules excluding current
        $exists = CallSchedule::where('redemption_id', $validated['redemption_id'])
            ->where('id', '!=', $callSchedule->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'A call schedule already exists for this period'])->withInput();
        }

        try {
            $callSchedule->update($validated);
            return redirect()->route('call-schedules-info.show', $callSchedule)->with('success', 'Call schedule updated successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallSchedule $callSchedule)
    {
        try {
            $callSchedule->delete();
            return redirect()->route('call-schedules.index')->with('success', 'Call schedule deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}
