<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Lease;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserLeaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leases = Lease::with(['tenant', 'tenant.property'])->get();
        return view('user.leases.index', compact('leases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::where('status', 'active')->with('property')->get();
        return view('user.leases.create', compact('tenants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'rental_amount' => 'required|numeric|min:0',
            'rental_frequency' => 'required|in:daily,weekly,monthly,quarterly,biannual,annual',
            'option_to_renew' => 'required|boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,terminated,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease = Lease::create($request->all());

        return redirect()->route('leases-info.show', $lease)
            ->with('success', 'Lease created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lease $leases_info)
    {
        $lease = $leases_info;
        $lease->load(['tenant', 'tenant.property']);
        return view('user.leases.show', compact('lease'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lease $leases_info)
    {
        $lease = $leases_info;
        $tenants = Tenant::where('status', 'active')->with('property')->get();
        return view('user.leases.edit', compact('lease', 'tenants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lease $leases_info)
    {
        $lease = $leases_info;
        $validator = Validator::make($request->all(), [
            'tenant_id' => 'required|exists:tenants,id',
            'lease_name' => 'required|string|max:255',
            'demised_premises' => 'required|string|max:255',
            'permitted_use' => 'required|string|max:255',
            'rental_amount' => 'required|numeric|min:0',
            'rental_frequency' => 'required|in:daily,weekly,monthly,quarterly,biannual,annual',
            'option_to_renew' => 'required|boolean',
            'term_years' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'status' => 'required|in:active,inactive,terminated,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease->update($request->all());

        return redirect()->route('leases-info.show', $lease)
            ->with('success', 'Lease updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lease $leases_info)
    {
        $lease = $leases_info;
        $lease->delete();

        return redirect()->route('leases-info.index')
            ->with('success', 'Lease deleted successfully.');
    }

        /**
     * Update the lease status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Lease  $lease
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request, Lease $lease)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive,terminated,expired',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $lease->update([
            'status' => $request->status
        ]);

        return redirect()->back()
            ->with('success', 'Lease status updated successfully.');
    }

    /**
     * Display leases expiring within a specific timeframe.
     *
     * @return \Illuminate\Http\Response
     */
    public function expiringLeases()
    {
        $nearExpiry = now()->addMonths(3); // Leases expiring in the next 3 months
        $expiringLeases = Lease::with(['tenant', 'tenant.property'])
            ->where('status', 'active')
            ->where('end_date', '<=', $nearExpiry)
            ->where('end_date', '>=', now())
            ->orderBy('end_date')
            ->get();

        return view('user.leases.expiring', compact('expiringLeases'));
    }
}
