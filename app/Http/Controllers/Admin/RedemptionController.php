<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RedemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $redemptions = Redemption::with('bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('bond', function ($q) use ($searchTerm) {
                        $q->where('isin_code', 'like', "%{$searchTerm}%")
                          ->orWhere('bond_sukuk_name', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereDate('last_call_date', $searchTerm)
                    ->orWhere('allow_partial_call', 'like', "%{$searchTerm}%");
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.redemptions.index', [
            'redemptions' => $redemptions,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.redemptions.create', [
            'bonds' => Bond::active()->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'required|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'required|boolean'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                $redemption = Redemption::create($validated);
                
                // Create default lockout period
                $redemption->lockoutPeriods()->create([
                    'start_date' => $redemption->bond->issue_date,
                    'end_date' => $redemption->last_call_date
                ]);
            });

            return redirect()->route('redemptions.index')
                ->with('success', 'Redemption configuration created successfully');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Creation failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Redemption $redemption)
    {
        return view('admin.redemptions.show', [
            'redemption' => $redemption->load([
                'bond.issuer',
                'callSchedules' => fn($q) => $q->orderBy('call_date'),
                'lockoutPeriods' => fn($q) => $q->orderBy('start_date')
            ])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Redemption $redemption)
    {
        return view('admin.redemptions.edit', [
            'redemption' => $redemption,
            'bonds' => Bond::active()->get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Redemption $redemption)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'required|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'required|boolean'
        ]);

        try {
            DB::transaction(function () use ($redemption, $validated) {
                $redemption->update($validated);
                
                // Update related lockout periods if needed
                $redemption->lockoutPeriods()->updateOrCreate(
                    ['redemption_id' => $redemption->id],
                    ['end_date' => $validated['last_call_date']]
                );
            });

            return redirect()->route('redemptions.index')
                ->with('success', 'Redemption configuration updated successfully');
                
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Redemption $redemption)
    {
        try {
            DB::transaction(function () use ($redemption) {
                $redemption->callSchedules()->delete();
                $redemption->lockoutPeriods()->delete();
                $redemption->delete();
            });

            return redirect()->route('redemptions.index')
                ->with('success', 'Redemption configuration deleted successfully');
                
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Deletion failed: ' . $e->getMessage());
        }
    }
}