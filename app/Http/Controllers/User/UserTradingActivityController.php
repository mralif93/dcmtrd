<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\TradingActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserTradingActivityController extends Controller
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

        return view('user.trading-activities.index', [
            'activities' => $activities,
            'searchTerm' => $searchTerm
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Bond::active()->get();
        return view('user.trading-activities.create', compact('bonds'));
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
        
        // Add status and prepared_by
        $validated['status'] = 'Pending';
        $validated['prepared_by'] = Auth::user()->name;

        try {
            $tradingActivity = TradingActivity::create($validated);
            return redirect()->route('trading-activities-info.show', $tradingActivity)
                ->with('success', 'Trading activity recorded successfully and pending approval');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error creating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(TradingActivity $trading_activities_info)
    {
        $tradingActivity = $trading_activities_info;
        $activity = $tradingActivity->load('bond');
        return view('user.trading-activities.show', compact('activity'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TradingActivity $trading_activities_info)
    {
        $activity = $trading_activities_info;
        $bonds = Bond::active()->get();
        return view('user.trading-activities.edit', compact('activity', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TradingActivity $trading_activities_info)
    {
        $tradingActivity = $trading_activities_info;

        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'trade_date' => 'required|date',
            'input_time' => 'nullable|date_format:H:i:s',
            'amount' => 'nullable|numeric|min:0.01|max:999999999999.99',
            'price' => 'nullable|numeric|min:0.0001|max:9999.9999',
            'yield' => 'nullable|numeric|min:0.01|max:100.00',
            'value_date' => 'nullable|date|after:trade_date',
        ]);

        // If editing an already approved activity, reset to pending
        if ($tradingActivity->status === 'Approved') {
            $validated['status'] = 'Pending';
            $validated['verified_by'] = null;
            $validated['approval_datetime'] = null;
        }

        try {
            $tradingActivity->update($validated);
            return redirect()->route('trading-activities-info.show', $tradingActivity)
                ->with('success', 'Trading activity updated successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error updating: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TradingActivity $trading_activities_info)
    {
        $tradingActivity = $trading_activities_info;

        try {
            $tradingActivity->delete();
            return redirect()->route('trading-activities-info.index')
                ->with('success', 'Trading activity deleted successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting: ' . $e->getMessage()]);
        }
    }

    /**
     * Show pending trading activities that need approval
     */
    public function pending()
    {
        $pendingActivities = TradingActivity::with('bond')
            ->where('status', 'Pending')
            ->latest()
            ->paginate(10);
            
        return view('user.trading-activities.pending', [
            'activities' => $pendingActivities
        ]);
    }
    
    /**
     * Approve a trading activity
     */
    public function approve(TradingActivity $trading_activities_info)
    {
        $tradingActivity = $trading_activities_info;
        
        try {
            // Update the trading activity status
            $tradingActivity->update([
                'status' => 'Approved',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now()
            ]);
            
            // Update the associated bond's last traded information
            $bond = $tradingActivity->bond;
            $bond->update([
                'last_traded_yield' => $tradingActivity->yield,
                'last_traded_price' => $tradingActivity->price,
                'last_traded_amount' => $tradingActivity->amount,
                'last_traded_date' => $tradingActivity->trade_date
            ]);
            
            return redirect()->route('trading-activities-info.pending')
                ->with('success', 'Trading activity approved successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error approving: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Reject a trading activity
     */
    public function reject(Request $request, TradingActivity $trading_activities_info)
    {
        $tradingActivity = $trading_activities_info;
        
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:255'
        ]);
        
        try {
            $tradingActivity->update([
                'status' => 'Rejected',
                'verified_by' => Auth::user()->name,
                'approval_datetime' => now(),
                'remarks' => $validated['rejection_reason']
            ]);
            
            return redirect()->route('trading-activities-info.pending')
                ->with('success', 'Trading activity rejected successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error rejecting: ' . $e->getMessage()]);
        }
    }
    
    /**
     * Filter activities by status
     */
    public function filter(Request $request)
    {
        $status = $request->input('status');
        $searchTerm = $request->input('search');
        
        $activities = TradingActivity::with('bond')
            ->when($status, function ($query) use ($status) {
                return $query->where('status', $status);
            })
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
            
        return view('user.trading-activities.index', [
            'activities' => $activities,
            'searchTerm' => $searchTerm,
            'selectedStatus' => $status
        ]);
    }
    
    /**
     * Bulk approval of multiple trading activities
     */
    public function bulkApprove(Request $request)
    {
        $activityIds = $request->input('activity_ids', []);
        
        if (empty($activityIds)) {
            return back()->withErrors(['error' => 'No activities selected']);
        }
        
        try {
            $activities = TradingActivity::whereIn('id', $activityIds)
                ->where('status', 'Pending')
                ->get();
                
            foreach ($activities as $activity) {
                // Update activity status
                $activity->update([
                    'status' => 'Approved',
                    'verified_by' => Auth::user()->name,
                    'approval_datetime' => now()
                ]);
                
                // Update the associated bond
                $bond = $activity->bond;
                $bond->update([
                    'last_traded_yield' => $activity->yield,
                    'last_traded_price' => $activity->price,
                    'last_traded_amount' => $activity->amount,
                    'last_traded_date' => $activity->trade_date
                ]);
            }
            
            return redirect()->route('trading-activities-info.pending')
                ->with('success', count($activities) . ' trading activities approved successfully');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error in bulk approval: ' . $e->getMessage()]);
        }
    }
}