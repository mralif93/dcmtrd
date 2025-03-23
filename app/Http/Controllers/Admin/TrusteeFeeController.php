<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Issuer;
use App\Models\TrusteeFee;
use App\Models\FacilityInformation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class TrusteeFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Use the proper relationship - facility.issuer instead of direct issuer
        $query = TrusteeFee::with(['facility', 'facility.issuer']);

        // Filter by facility_information_id if provided
        if ($request->has('facility_information_id') && !empty($request->facility_information_id)) {
            $query->where('facility_information_id', $request->facility_information_id);
        }

        // Filter by issuer_id through the facility relationship
        if ($request->has('issuer_id') && !empty($request->issuer_id)) {
            $query->whereHas('facility', function($q) use ($request) {
                $q->where('issuer_id', $request->issuer_id);
            });
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
        $issuers = Issuer::orderBy('issuer_name')->get();

        // Get facilities for dropdown if needed
        $facilities = FacilityInformation::orderBy('facility_name')->get();

        $trustee_fees = $query->latest()->paginate(10);
        return view('admin.trustee-fees.index', compact('trustee_fees', 'facilities', 'issuers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $issuers = Issuer::all();
        $facilities = FacilityInformation::all();
        return view('admin.trustee-fees.create', compact('facilities', 'issuers'));
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
            'facility_information_id' => 'required|exists:facility_informations,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'required|numeric',
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
            'status' => 'nullable|string',
        ]);

        // Set default values for prepared_by if not provided
        if (!$request->has('prepared_by') || empty($request->prepared_by)) {
            $request->merge(['prepared_by' => Auth::user()->name]);
        }

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
        $trusteeFee->load('facility');
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
        $issuers = Issuer::all();
        $facilities = FacilityInformation::all();
        return view('admin.trustee-fees.edit', compact('trusteeFee', 'facilities', 'issuers'));
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
            'facility_information_id' => 'required|exists:facility_informations,id',
            'description' => 'required|string',
            'trustee_fee_amount_1' => 'required|numeric',
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
            'status' => 'nullable|string',
        ]);

        // Set approval datetime if not already set and payment is received
        if ($request->has('payment_received') && !empty($request->payment_received) && !$trusteeFee->approval_datetime) {
            $request->merge(['approval_datetime' => now()]);
        }

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
        $query = TrusteeFee::with('facility');
        
        if ($request->has('facility_information_id') && !empty($request->facility_information_id)) {
            $query->where('facility_information_id', $request->facility_information_id);
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
        $facilities = FacilityInformation::all();
        
        return view('admin.trustee-fees.index', compact('trustee_fees', 'facilities'));
    }
    
    /**
     * Generate a report.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $query = TrusteeFee::with('facility');
        
        if ($request->has('start_date') && !empty($request->start_date)) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        
        if ($request->has('end_date') && !empty($request->end_date)) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }
        
        if ($request->has('facility_information_id') && !empty($request->facility_information_id)) {
            $query->where('facility_information_id', $request->facility_information_id);
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
        $total_fee_1 = $trustee_fees->sum('trustee_fee_amount_1');
        $total_fee_2 = $trustee_fees->sum('trustee_fee_amount_2');
        $total_fees = $total_fee_1 + $total_fee_2;
        
        $paid_fees = $trustee_fees->whereNotNull('payment_received');
        $total_paid_1 = $paid_fees->sum('trustee_fee_amount_1');
        $total_paid_2 = $paid_fees->sum('trustee_fee_amount_2');
        $total_paid = $total_paid_1 + $total_paid_2;
        
        $total_unpaid = $total_fees - $total_paid;
        
        $facilities = FacilityInformation::all();
        
        return view('admin.trustee-fees.report', compact(
            'trustee_fees', 
            'total_fees', 
            'total_paid', 
            'total_unpaid',
            'facilities'
        ));
    }

    /**
     * Display a listing of the trashed (soft-deleted) trustee fees.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $trashedFees = TrusteeFee::with('facility')->onlyTrashed()->latest()->paginate(10);
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