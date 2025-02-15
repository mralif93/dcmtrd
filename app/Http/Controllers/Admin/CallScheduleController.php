<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\CallSchedule;
use Illuminate\Http\Request;

class CallScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $callSchedules = CallSchedule::with('redemption.bondInfo')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereDate('start_date', $searchTerm)
                      ->orWhereDate('end_date', $searchTerm)
                      ->orWhere('call_price', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.call-schedules.index', [
            'callSchedules' => $callSchedules,
            'searchTerm' => $searchTerm
        ]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.call-schedules.create', [
            'redemptions' => Redemption::with('bondInfo')->get()
        ]);
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

        CallSchedule::create($validated);

        return redirect()->route('call-schedules.index')
            ->with('success', 'Call schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(CallSchedule $callSchedule)
    {
        return view('admin.call-schedules.show', [
            'schedule' => $callSchedule->load('redemption.bondInfo')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CallSchedule $callSchedule)
    {
        return view('admin.call-schedules.edit', [
            'schedule' => $callSchedule,
            'redemptions' => Redemption::with('bondInfo')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CallSchedule $callSchedule)
    {
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

        $callSchedule->update($validated);

        return redirect()->route('call-schedules.index')
            ->with('success', 'Call schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CallSchedule $callSchedule)
    {
        $callSchedule->delete();

        return redirect()->route('call-schedules.index')
            ->with('success', 'Call schedule deleted successfully');
    }
}
