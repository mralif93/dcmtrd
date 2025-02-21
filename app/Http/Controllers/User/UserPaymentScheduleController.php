<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bond;
use App\Models\PaymentSchedule;
use Illuminate\Http\Request;

class UserPaymentScheduleController extends Controller
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

        return view('user.payment-schedules.index', compact('paymentSchedules', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $bonds = Bond::active()->get();
        return view('user.payment-schedules.create', compact('bonds'));
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

        try {
            $paymentSchedule = PaymentSchedule::create($validated);
            return redirect()->route('payment-schedules-info.show', $paymentSchedule)->with('success', 'Payment schedule created successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error creating: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentSchedule $payment_schedules_info)
    {
        $paymentSchedule = $payment_schedules_info;
        $paymentSchedule->load('bond.issuer');
        return view('user.payment-schedules.show', compact('paymentSchedule'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentSchedule $payment_schedules_info)
    {
        $paymentSchedule = $payment_schedules_info;
        $bonds = Bond::active()->get();
        return view('user.payment-schedules.edit', compact('paymentSchedule', 'bonds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PaymentSchedule $payment_schedules_info)
    {
        $paymentSchedule = $payment_schedules_info;
        $validated = $request->validate([
            'bond_id' => 'required|exists:bonds,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'payment_date' => 'required|date',
            'ex_date' => 'required|date',
            'coupon_rate' => 'required|decimal:2|between:0,99.99',
            'adjustment_date' => 'nullable|date',
        ]);

        try{
            $paymentSchedule->update($validated);
            return redirect()->route('payment-schedules-info.show', $paymentSchedule)->with('success', 'Payment schedule updated successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error updating: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentSchedule $payment_schedules_info)
    {
        $paymentSchedule = $payment_schedules_info;

        try {
            $paymentSchedule->delete();
            return redirect()->route('payment-schedules-info.index')>with('success', 'Payment schedule deleted successfully');
        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Error deleting: ' . $e->getMessage());
        }
    }
}
