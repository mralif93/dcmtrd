<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\LockoutPeriod;
use Illuminate\Http\Request;

class LockoutPeriodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $lockoutPeriods = LockoutPeriod::with('redemption.bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereDate('start_date', $searchTerm)
                      ->orWhereDate('end_date', $searchTerm)
                      ->orWhereHas('redemption.bond', function ($q) use ($searchTerm) {
                          $q->where('isin_code', 'like', "%{$searchTerm}%")
                            ->orWhere('stock_code', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.lockout-periods.index', [
            'lockoutPeriods' => $lockoutPeriods,
            'searchTerm' => $searchTerm
        ]);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.lockout-periods.create', [
            'redemptions' => Redemption::with('bond')->get()
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
        ]);

        // Check for overlapping periods
        $exists = LockoutPeriod::where('redemption_id', $validated['redemption_id'])
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['period' => 'A lockout period already exists for these dates'])->withInput();
        }

        LockoutPeriod::create($validated);

        return redirect()->route('lockout-periods.index')
            ->with('success', 'Lockout period created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(LockoutPeriod $lockoutPeriod)
    {
        return view('admin.lockout-periods.show', [
            'period' => $lockoutPeriod->load('redemption.bond')
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LockoutPeriod $lockoutPeriod)
    {
        return view('admin.lockout-periods.edit', [
            'period' => $lockoutPeriod,
            'redemptions' => Redemption::with('bond')->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LockoutPeriod $lockoutPeriod)
    {
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Check for overlapping periods excluding current
        $exists = LockoutPeriod::where('redemption_id', $validated['redemption_id'])
            ->where('id', '!=', $lockoutPeriod->id)
            ->where(function ($query) use ($validated) {
                $query->whereBetween('start_date', [$validated['start_date'], $validated['end_date']])
                      ->orWhereBetween('end_date', [$validated['start_date'], $validated['end_date']]);
            })
            ->exists();

        if ($exists) {
            return back()->withErrors(['period' => 'A lockout period already exists for these dates'])->withInput();
        }

        $lockoutPeriod->update($validated);

        return redirect()->route('lockout-periods.index')
            ->with('success', 'Lockout period updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LockoutPeriod $lockoutPeriod)
    {
        $lockoutPeriod->delete();

        return redirect()->route('lockout-periods.index')
            ->with('success', 'Lockout period deleted successfully');
    }
}
