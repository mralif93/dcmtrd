<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\Redemption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserRedemptionController extends Controller
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

        return view('user.redemptions.index', [
            'redemptions' => $redemptions,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Bond::active()->get();
        return view('user.redemptions.create', compact('bonds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Convert checkbox values to proper booleans
        $request->merge([
            'allow_partial_call' => $request->has('allow_partial_call'),
            'redeem_nearest_denomination' => $request->has('redeem_nearest_denomination')
        ]);

        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'required|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'required|boolean'
        ]);

        try {
            $redemption = Redemption::create($validated);
            return redirect()->route('redemptions-info.show', $redemption)->with('success', 'Redemption configuration created successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Redemption $redemptions_info)
    {
        $redemption = $redemptions_info;
        $redemption->load([
            'bond.issuer'
        ]);

        return view('user.redemptions.show', compact('redemption'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Redemption $redemptions_info)
    {
        $redemption = $redemptions_info;
        $bonds = Bond::active()->get();
        return view('user.redemptions.edit', compact('redemption', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Redemption $redemptions_info)
    {
        $redemption = $redemptions_info;

        // Convert checkbox values to proper booleans
        $request->merge([
            'allow_partial_call' => $request->has('allow_partial_call'),
            'redeem_nearest_denomination' => $request->has('redeem_nearest_denomination')
        ]);

        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'allow_partial_call' => 'required|boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'required|boolean'
        ]);

        try {
            $redemption->update($validated);
            return redirect()->route('redemptions-info.show', $redemption)->with('success', 'Redemption configuration updated successfully'); 
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Redemption $redemptions_info)
    {
        $redemption = $redemptions_info;

        try {
            DB::transaction(function () use ($redemption) {
                $redemption->callSchedules()->delete();
                $redemption->lockoutPeriods()->delete();
                $redemption->delete();
            });

            return redirect()->route('redemptions-info.index')->with('success', 'Redemption configuration deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}
