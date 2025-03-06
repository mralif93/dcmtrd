<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\TenantApproval;
use App\Models\Tenant;
use App\Models\Checklist;
use App\Models\Lease;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserTenantApprovalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tenantApprovals = TenantApproval::with(['tenant', 'checklist', 'lease'])->get();
        
        return view('user.tenant-approvals.index', compact('tenantApprovals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tenants = Tenant::all();
        $checklists = Checklist::where('type', 'tenant')->get();
        $leases = Lease::all();
        
        return view('user.tenant-approvals.create', compact('tenants', 'checklists', 'leases'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'tenant_id' => 'required|exists:tenants,id',
            'lease_id' => 'nullable|exists:leases,id',
            'approval_type' => 'required|in:new,renewal',
            'od_approved' => 'boolean',
            'ld_verified' => 'boolean',
            'od_approval_date' => 'nullable|date',
            'ld_verification_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'submitted_to_ld_date' => 'nullable|date',
            'ld_response_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tenant-approvals-info.create')
                ->withErrors($validator)
                ->withInput();
        }

        $tenantApproval = TenantApproval::create($request->all());

        return redirect()->route('tenant-approvals-info.show', $tenantApproval)
            ->with('success', 'Tenant approval created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $tenantApproval->load(['tenant', 'checklist', 'lease']);
        
        return view('user.tenant-approvals.show', compact('tenantApproval'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $tenants = Tenant::all();
        $checklists = Checklist::where('type', 'tenant')->get();
        $leases = Lease::all();
        
        return view('user.tenant-approvals.edit', compact('tenantApproval', 'tenants', 'checklists', 'leases'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $validator = Validator::make($request->all(), [
            'checklist_id' => 'required|exists:checklists,id',
            'tenant_id' => 'required|exists:tenants,id',
            'lease_id' => 'nullable|exists:leases,id',
            'approval_type' => 'required|in:new,renewal',
            'od_approved' => 'boolean',
            'ld_verified' => 'boolean',
            'od_approval_date' => 'nullable|date',
            'ld_verification_date' => 'nullable|date',
            'notes' => 'nullable|string',
            'submitted_to_ld_date' => 'nullable|date',
            'ld_response_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tenant-approvals-info.edit', $tenantApproval->id)
                ->withErrors($validator)
                ->withInput();
        }

        $tenantApproval->update($request->all());

        return redirect()->route('tenant-approvals-info.show', $tenantApproval)
            ->with('success', 'Tenant approval updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $tenantApproval->delete();

        return redirect()->route('tenant-approvals-info.index')
            ->with('success', 'Tenant approval deleted successfully.');
    }

    /**
     * Mark the tenant approval as OD approved.
     *
     * @param  \App\Models\TenantApproval  $tenantApproval
     * @return \Illuminate\Http\Response
     */
    public function approveByOD(TenantApproval $tenantApproval)
    {
        $tenantApproval->update([
            'od_approved' => true,
            'od_approval_date' => now(),
        ]);
        
        return redirect()->route('tenant-approvals-info.show', $tenantApproval->id)
            ->with('success', 'Tenant approval marked as approved by Operations Department.');
    }
    
    /**
     * Mark the tenant approval as LD verified.
     *
     * @param  \App\Models\TenantApproval  $tenantApproval
     * @return \Illuminate\Http\Response
     */
    public function verifyByLD(TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $tenantApproval->update([
            'ld_verified' => true,
            'ld_verification_date' => now(),
            'ld_response_date' => now(),
        ]);
        
        // Also update the related tenant's approval status
        if ($tenantApproval->tenant) {
            $tenantApproval->tenant->update([
                'approval_status' => 'approved',
                'last_approval_date' => now(),
            ]);
        }
        
        return redirect()->route('tenant-approvals-info.show', $tenantApproval->id)
            ->with('success', 'Tenant approval verified by Legal Department.');
    }
    
    /**
     * Mark the tenant approval as submitted to Legal Department.
     *
     * @param  \App\Models\TenantApproval  $tenantApproval
     * @return \Illuminate\Http\Response
     */
    public function submitToLD(TenantApproval $tenant_approvals_info)
    {
        $tenantApproval = $tenant_approvals_info;
        $tenantApproval->update([
            'submitted_to_ld_date' => now(),
        ]);
        
        return redirect()->route('tenant-approvals-info.show', $tenantApproval->id)
            ->with('success', 'Tenant approval submitted to Legal Department.');
    }
}
