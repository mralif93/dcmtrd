<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TrusteeFee;
use App\Models\Issuer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserTrusteeFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = TrusteeFee::with('issuer');
        
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->where('issuer_id', $request->issuer_id);
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
        
        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('name')->get();
        
        $trustee_fees = $query->latest()->paginate(10);
        return view('user.trustee-fees.index', compact('trustee_fees', 'issuers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issuers = Issuer::orderBy('name')->get();
        return view('user.trustee-fees.create', compact('issuers'));
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
            'issuer_id' => 'required|exists:issuers,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
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
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        TrusteeFee::create($request->all());

        return redirect()->route('trustee-fees-info.index')
            ->with('success', 'Trustee fee created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function show(TrusteeFee $trustee_fees_info)
    {
        $trusteeFee = $trustee_fees_info;
        return view('user.trustee-fees.show', compact('trusteeFee'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function edit(TrusteeFee $trustee_fees_info)
    {
        $trusteeFee = $trustee_fees_info;
        $issuers = Issuer::orderBy('name')->get();
        return view('user.trustee-fees.edit', compact('trusteeFee', 'issuers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TrusteeFee $trustee_fees_info)
    {
        $trusteeFee = $trustee_fees_info;
        $request->validate([
            'issuer_id' => 'required|exists:issuers,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'nullable|numeric',
            'trustee_fee_amount_2' => 'nullable|numeric',
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
            'prepared_by' => 'nullable|string|max:255',
            'verified_by' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        $trusteeFee->update($request->all());

        return redirect()->route('trustee-fees-info.index')
            ->with('success', 'Trustee fee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrusteeFee  $trusteeFee
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrusteeFee $trustee_fees_info)
    {
        $trusteeFee = $trustee_fees_info;
        $trusteeFee->delete();

        return redirect()->route('trustee-fees-info.index')
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
        $query = TrusteeFee::with('issuer');
        
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->where('issuer_id', $request->issuer_id);
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
        
        // Get all issuers for the dropdown
        $issuers = Issuer::orderBy('name')->get();
        
        $trustee_fees = $query->latest()->paginate(10);
        
        return view('user.trustee-fees.index', compact('trustee_fees', 'issuers'));
    }
    
    /**
     * Generate a report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $query = TrusteeFee::with('issuer');
        
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->has('issuer') && !empty($request->issuer)) {
            $query->whereHas('issuer', function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->issuer . '%');
            });
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
        $total_fees = $trustee_fees->sum(function($fee) {
            return $fee->getTotalAmount();
        });
        
        $total_paid = $trustee_fees->whereNotNull('payment_received')->sum(function($fee) {
            return $fee->getTotalAmount();
        });
        
        $total_unpaid = $total_fees - $total_paid;
        
        return view('user.trustee-fees.report', compact('trustee_fees', 'total_fees', 'total_paid', 'total_unpaid'));
    }

    /**
     * Display a listing of the trashed (soft-deleted) trustee fees.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedFees = TrusteeFee::with('issuer')->onlyTrashed()->latest()->paginate(10);
        return view('user.trustee-fees.trashed', compact('trashedFees'));
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
        
        return redirect()->route('trustee-fees-info.trashed')
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
        
        return redirect()->route('trustee-fees-info.trashed')
            ->with('success', 'Trustee fee permanently deleted.');
    }

    public function testing() {
        dd('testing..');
    }
}