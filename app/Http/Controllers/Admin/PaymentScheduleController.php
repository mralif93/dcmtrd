<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\PaymentSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PaymentScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $searchTerm = $request->input('search');
        
        $paymentSchedules = PaymentSchedule::with('bond')
            ->when($searchTerm, function ($query) use ($searchTerm) {
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('coupon_rate', 'like', "%{$searchTerm}%")
                      ->orWhereDate('payment_date', $searchTerm)
                      ->orWhereDate('start_date', $searchTerm)
                      ->orWhereDate('end_date', $searchTerm)
                      ->orWhereHas('bond', function($q) use ($searchTerm) {
                          $q->where('isin_code', 'like', "%{$searchTerm}%")
                            ->orWhere('bond_sukuk_name', 'like', "%{$searchTerm}%");
                      });
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
        $bonds = Bond::active()->get();
        return view('admin.payment-schedules.create', compact('bonds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_date' => 'required|date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|decimal:2|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        $paymentSchedule = PaymentSchedule::create($validated);
        return redirect()->route('payment-schedules.show', $paymentSchedule)->with('success', 'Payment schedule created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSchedule $paymentSchedule)
    {
        return view('admin.payment-schedules.show', [
            'schedule' => $paymentSchedule->load('bond.issuer')
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentSchedule $paymentSchedule)
    {
        $bonds = Bond::active()->get();
        return view('admin.payment-schedules.edit', compact('paymentSchedule', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentSchedule $paymentSchedule)
    {
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_date' => 'required|date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|decimal:2|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);
        $paymentSchedule->update($validated);
        return redirect()->route('payment-schedules.show', $paymentSchedule)->with('success', 'Payment schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSchedule $paymentSchedule)
    {
        $paymentSchedule->delete();
        return redirect()->route('payment-schedules.index')>with('success', 'Payment schedule deleted successfully');
    }
}