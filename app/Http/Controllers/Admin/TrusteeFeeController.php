<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TrusteeFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TrusteeFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $trustee_fees = TrusteeFee::latest()->paginate(10);
        return view('admin.trustee-fees.index', compact('trustee_fees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.trustee-fees.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'issuer' => 'required|string|max:255',
            'description' => 'required|string',
            'fees_rm' => 'required|numeric',
            'start_anniversary_date' => 'required|date',
            'end_anniversary_date' => 'required|date|after_or_equal:start_anniversary_date',
            'invoice_no' => 'required|string|unique:trustee_fees,invoice_no',
            'month' => 'nullable|string|max:10',
            'date' => 'nullable|integer|min:1|max:31',
            'memo_to_fad' => 'nullable|date',
            'date_letter_to_issuer' => 'nullable|date',
            'first_reminder' => 'nullable|date',
            'second_reminder' => 'nullable|date',
            'third_reminder' => 'nullable|date',
            'payment_received' => 'nullable|date',
            'tt_cheque_no' => 'nullable|string|max:255',
            'memo_receipt_to_fad' => 'nullable|date',
            'receipt_to_issuer' => 'nullable|date',
            'receipt_no' => 'nullable|string|max:255',
        ]);

        TrusteeFee::create($request->all());

        return redirect()->route('trustee-fees.index')
            ->with('success', 'Trustee fee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function show(TrusteeFee $trusteeFee)
    {
        return view('admin.trustee-fees.show', compact('trusteeFee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function edit(TrusteeFee $trusteeFee)
    {
        return view('admin.trustee-fees.edit', compact('trusteeFee'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrusteeFee $trusteeFee)
    {
        $request->validate([
            'issuer' => 'required|string|max:255',
            'description' => 'required|string',
            'fees_rm' => 'required|numeric',
            'start_anniversary_date' => 'required|date',
            'end_anniversary_date' => 'required|date|after_or_equal:start_anniversary_date',
            'invoice_no' => 'required|string|unique:trustee_fees,invoice_no,' . $trusteeFee->id,
            'month' => 'nullable|string|max:10',
            'date' => 'nullable|integer|min:1|max:31',
            'memo_to_fad' => 'nullable|date',
            'date_letter_to_issuer' => 'nullable|date',
            'first_reminder' => 'nullable|date',
            'second_reminder' => 'nullable|date',
            'third_reminder' => 'nullable|date',
            'payment_received' => 'nullable|date',
            'tt_cheque_no' => 'nullable|string|max:255',
            'memo_receipt_to_fad' => 'nullable|date',
            'receipt_to_issuer' => 'nullable|date',
            'receipt_no' => 'nullable|string|max:255',
        ]);

        $trusteeFee->update($request->all());

        return redirect()->route('trustee-fees.index')
            ->with('success', 'Trustee fee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrusteeFee $trusteeFee)
    {
        $trusteeFee->delete();

        return redirect()->route('trustee-fees.index')
            ->with('success', 'Trustee fee deleted successfully.');
    }
    
    /**
     * Search trustee fees.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $query = TrusteeFee::query();
        
        if ($request->has('issuer') && !empty($request->issuer)) {
            $query->where('issuer', 'LIKE', '%' . $request->issuer . '%');
        }
        
        if ($request->has('invoice_no') && !empty($request->invoice_no)) {
            $query->where('invoice_no', 'LIKE', '%' . $request->invoice_no . '%');
        }
        
        if ($request->has('month') && !empty($request->month)) {
            $query->where('month', $request->month);
        }
        
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            if ($request->payment_status === 'paid') {
                $query->whereNotNull('payment_received');
            } elseif ($request->payment_status === 'unpaid') {
                $query->whereNull('payment_received');
            }
        }
        
        $trustee_fees = $query->latest()->paginate(10);
        
        return view('admin.trustee-fees.index', compact('trustee_fees'));
    }
    
    /**
     * Generate a report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $query = TrusteeFee::query();
        
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->has('issuer') && !empty($request->issuer)) {
            $query->where('issuer', 'LIKE', '%' . $request->issuer . '%');
        }
        
        if ($request->has('payment_status') && !empty($request->payment_status)) {
            if ($request->payment_status === 'paid') {
                $query->whereNotNull('payment_received');
            } elseif ($request->payment_status === 'unpaid') {
                $query->whereNull('payment_received');
            }
        }
        
        $trustee_fees = $query->get();
        
        // Calculate totals
        $total_fees = $trustee_fees->sum('fees_rm');
        $total_paid = $trustee_fees->whereNotNull('payment_received')->sum('fees_rm');
        $total_unpaid = $total_fees - $total_paid;
        
        return view('admin.trustee-fees.report', compact('trustee_fees', 'total_fees', 'total_paid', 'total_unpaid'));
    }

    /**
     * Display a listing of the trashed (soft-deleted) trustee fees.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedFees = TrusteeFee::onlyTrashed()->latest()->paginate(10);
        return view('admin.trustee-fees.trashed', compact('trashedFees'));
    }

    /**
     * Restore a trashed trustee fee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $trusteeFee = TrusteeFee::onlyTrashed()->findOrFail($id);
        $trusteeFee->restore();
        
        return redirect()->route('trustee-fees.trashed')
            ->with('success', 'Trustee fee restored successfully.');
    }

    /**
     * Permanently delete a trashed trustee fee.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $trusteeFee = TrusteeFee::onlyTrashed()->findOrFail($id);
        $trusteeFee->forceDelete();
        
        return redirect()->route('trustee-fees.trashed')
            ->with('success', 'Trustee fee permanently deleted.');
    }
}
