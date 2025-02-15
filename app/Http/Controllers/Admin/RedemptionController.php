<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BondInfo;
use App\Models\Redemption;
use Illuminate\Http\Request;

class RedemptionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $redemptions = Redemption::with('bondInfo')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereHas('bondInfo', function ($q) use ($searchTerm) {
                        $q->where('isin_code', 'like', "%{$searchTerm}%")
                          ->orWhere('stock_code', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereDate('last_call_date', $searchTerm);
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
            'bonds' => BondInfo::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'allow_partial_call' => 'boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'boolean'
        ]);

        // Check for existing redemption configuration
        $exists = Redemption::where('bond_info_id', $validated['bond_info_id'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['redemption' => 'This bond already has a redemption configuration'])->withInput();
        }

        Redemption::create([
            'bond_info_id' => $validated['bond_info_id'],
            'allow_partial_call' => $request->boolean('allow_partial_call'),
            'last_call_date' => $validated['last_call_date'],
            'redeem_nearest_denomination' => $request->boolean('redeem_nearest_denomination')
        ]);

        return redirect()->route('redemptions.index')
            ->with('success', 'Redemption configuration created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Redemption $redemption)
    {
        return view('admin.redemptions.show', [
            'redemption' => $redemption->load('bondInfo', 'callSchedules', 'lockoutPeriods')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Redemption $redemption)
    {
        return view('admin.redemptions.edit', [
            'redemption' => $redemption,
            'bonds' => BondInfo::all()
        ]);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Redemption $redemption)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'allow_partial_call' => 'boolean',
            'last_call_date' => 'required|date',
            'redeem_nearest_denomination' => 'boolean'
        ]);

        // Check for existing configuration excluding current
        $exists = Redemption::where('bond_info_id', $validated['bond_info_id'])
            ->where('id', '!=', $redemption->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['redemption' => 'This bond already has a redemption configuration'])->withInput();
        }

        $redemption->update([
            'bond_info_id' => $validated['bond_info_id'],
            'allow_partial_call' => $request->boolean('allow_partial_call'),
            'last_call_date' => $validated['last_call_date'],
            'redeem_nearest_denomination' => $request->boolean('redeem_nearest_denomination')
        ]);

        return redirect()->route('redemptions.index')
            ->with('success', 'Redemption configuration updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Redemption $redemption)
    {
        $redemption->delete();

        return redirect()->route('redemptions.index')
            ->with('success', 'Redemption configuration deleted successfully');
    }
}
