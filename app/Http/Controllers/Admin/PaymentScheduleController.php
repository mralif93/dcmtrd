<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BondInfo;
use App\Models\PaymentSchedule;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $paymentSchedules = PaymentSchedule::with('bondInfo')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('coupon_rate', 'like', "%{$searchTerm}%")
                      ->orWhereDate('ex_date', $searchTerm)
                      ->orWhereDate('start_date', $searchTerm)
                      ->orWhereDate('end_date', $searchTerm);
                });
            })
            ->latest()
            ->paginate(10);

        return view('admin.payment-schedules.index', compact('paymentSchedules', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bondInfos = BondInfo::all();
        return view('admin.payment-schedules.create', compact('bondInfos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|numeric|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        // Check for existing schedule
        $exists = PaymentSchedule::where('bond_info_id', $validated['bond_info_id'])
            ->where('start_date', $validated['start_date'])
            ->where('end_date', $validated['end_date'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'This payment schedule already exists'])->withInput();
        }

        PaymentSchedule::create($validated);

        return redirect()->route('payment-schedules.index')
            ->with('success', 'Payment schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSchedule $paymentSchedule)
    {
        return view('admin.payment-schedules.show', [
            'schedule' => $paymentSchedule->load('bondInfo')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentSchedule $paymentSchedule)
    {
        $bondInfos = BondInfo::all();
        return view('admin.payment-schedules.edit', compact('paymentSchedule', 'bondInfos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentSchedule $paymentSchedule)
    {
        $validated = $request->validate([
            'bond_info_id' => 'required|exists:bond_infos,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|numeric|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        // Check for existing schedule excluding current
        $exists = PaymentSchedule::where('bond_info_id', $validated['bond_info_id'])
            ->where('start_date', $validated['start_date'])
            ->where('end_date', $validated['end_date'])
            ->where('id', '!=', $paymentSchedule->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['schedule' => 'This payment schedule already exists'])->withInput();
        }

        $paymentSchedule->update($validated);

        return redirect()->route('payment-schedules.index')
            ->with('success', 'Payment schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSchedule $paymentSchedule)
    {
        $paymentSchedule->delete();

        return redirect()->route('payment-schedules.index')
            ->with('success', 'Payment schedule deleted successfully');
    }
}
