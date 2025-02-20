<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\TradingActivity;
use Illuminate\Http\Request;

class TradingActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $activities = TradingActivity::with('bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->whereDate('trade_date', $searchTerm)
                      ->orWhereDate('value_date', $searchTerm)
                      ->orWhereHas('bond', function ($q) use ($searchTerm) {
                          $q->where('isin_code', 'like', "%{$searchTerm}%")
                            ->orWhere('stock_code', 'like', "%{$searchTerm}%");
                      });
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.trading-activities.index', [
            'activities' => $activities,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.trading-activities.create', [
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
            'trade_date' => 'required|date',
            'input_time' => 'nullable|date_format:H:i:s',
            'amount' => 'nullable|numeric|min:0.01|max:999999999999.99',
            'price' => 'nullable|numeric|min:0.0001|max:9999.9999',
            'yield' => 'nullable|numeric|min:0.01|max:100.00',
            'value_date' => 'nullable|date|after:trade_date',
        ]);

        try {
            $tradingActivity = TradingActivity::create($validated);
            return redirect()->route('trading-activities.show', $tradingActivity)->with('success', 'Trading activity recorded successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Create failed: ' . $e->getMessage()])->withInput();
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(TradingActivity $tradingActivity)
    {
        return view('admin.trading-activities.show', [
            'activity' => $tradingActivity->load('bond')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TradingActivity $tradingActivity)
    {
        return view('admin.trading-activities.edit', [
            'activity' => $tradingActivity,
            'bonds' => Bond::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TradingActivity $tradingActivity)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'trade_date' => 'required|date',
            'input_time' => 'nullable|date_format:H:i',
            'amount' => 'nullable|numeric|min:0.01|max:999999999999.99',
            'price' => 'nullable|numeric|min:0.0001|max:9999.9999',
            'yield' => 'nullable|numeric|min:0.01|max:100.00',
            'value_date' => 'nullable|date|after:trade_date',
        ]);

        try {
            $tradingActivity->update($validated);
            return redirect()->route('trading-activities.show', $tradingActivity)->with('success', 'Trading activity updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Update failed: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TradingActivity $tradingActivity)
    {
        try {
            $tradingActivity->delete();
            return redirect()->route('trading-activities.index')->with('success', 'Trading activity deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Delete failed: ' . $e->getMessage()])->withInput();
        }
    }
}
