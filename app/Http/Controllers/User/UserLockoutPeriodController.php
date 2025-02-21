<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Redemption;
use App\Models\LockoutPeriod;
use Illuminate\Http\Request;

class UserLockoutPeriodController extends Controller
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

        return view('user.lockout-periods.index', [
            'lockoutPeriods' => $lockoutPeriods,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $redemptions = Redemption::with('bond')->get();
        return view('user.lockout-periods.create', compact('redemptions'));
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

        try {
            $lockoutPeriod = LockoutPeriod::create($validated);
            return redirect()->route('lockout-periods-info.show', $lockoutPeriod)->with('success', 'Lockout period created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(LockoutPeriod $lockout_periods_info)
    {
        $lockoutPeriod = $lockout_periods_info;
        $period = $lockoutPeriod->load('redemption.bond');
        return view('user.lockout-periods.show', compact('period'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LockoutPeriod $lockout_periods_info)
    {
        $lockoutPeriod = $lockout_periods_info;
        $period = $lockoutPeriod->load('redemption.bond');
        $redemptions = Redemption::with('bond')->get();
        return view('user.lockout-periods.edit', compact('period', 'redemptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LockoutPeriod $lockout_periods_info)
    {
        $lockoutPeriod = $lockout_periods_info;
        $validated = $request->validate([
            'redemption_id' => 'required|exists:redemptions,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $lockoutPeriod->update($validated);
            return redirect()->route('lockout-periods-info.show', $lockoutPeriod)->with('success', 'Lockout period updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LockoutPeriod $lockout_periods_info)
    {
        $lockoutPeriod = $lockout_periods_info;

        try {
            $lockoutPeriod->delete();
            return redirect()->route('lockout-periods-info.index')->with('success', 'Lockout period deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting: ' . $e->getMessage()])->withInput();
        }
    }
}
