<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplianceCovenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ComplianceCovenantController extends Controller
{
    /**
     * Display a listing of all compliance covenants with search functionality.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = ComplianceCovenant::query();

        // Search by issuer short name
        if ($request->has('issuer_short_name') && !empty($request->issuer_short_name)) {
            $query->where('issuer_short_name', 'LIKE', '%' . $request->issuer_short_name . '%');
        }

        // Search by financial year end
        if ($request->has('financial_year_end') && !empty($request->financial_year_end)) {
            $query->where('financial_year_end', 'LIKE', '%' . $request->financial_year_end . '%');
        }

        // Filter by compliance status
        if ($request->has('status')) {
            if ($request->status === 'compliant') {
                $query->compliant();
            } elseif ($request->status === 'non_compliant') {
                $query->nonCompliant();
            }
        }

        // Get results with pagination
        $covenants = $query->latest()->paginate(10);
        $covenants->appends($request->all());
        
        return view('admin.compliance-covenants.index', compact('covenants'));
    }

    /**
     * Show the form for creating a new compliance covenant.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.compliance-covenants.create');
    }

    /**
     * Store a newly created compliance covenant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'issuer_short_name' => 'required|string|max:255',
            'financial_year_end' => 'required|string|max:255',
            'audited_financial_statements' => 'nullable|string|max:255',
            'unaudited_financial_statements' => 'nullable|string|max:255',
            'compliance_certificate' => 'nullable|string|max:255',
            'finance_service_cover_ratio' => 'nullable|string|max:255',
            'annual_budget' => 'nullable|string|max:255',
            'computation_of_finance_to_ebitda' => 'nullable|string|max:255',
            'ratio_information_on_use_of_proceeds' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('compliance-covenants.create')
                ->withErrors($validator)
                ->withInput();
        }

        ComplianceCovenant::create($request->all());

        return redirect()
            ->route('compliance-covenants.index')
            ->with('success', 'Compliance covenant created successfully.');
    }

    /**
     * Display the specified compliance covenant.
     *
     * @param  \App\Models\ComplianceCovenant  $complianceCovenant
     * @return \Illuminate\Http\Response
     */
    public function show(ComplianceCovenant $complianceCovenant)
    {
        return view('admin.compliance-covenants.show', compact('complianceCovenant'));
    }

    /**
     * Show the form for editing the specified compliance covenant.
     *
     * @param  \App\Models\ComplianceCovenant  $complianceCovenant
     * @return \Illuminate\Http\Response
     */
    public function edit(ComplianceCovenant $complianceCovenant)
    {
        return view('admin.compliance-covenants.edit', compact('complianceCovenant'));
    }

    /**
     * Update the specified compliance covenant in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ComplianceCovenant  $complianceCovenant
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ComplianceCovenant $complianceCovenant)
    {
        $validator = Validator::make($request->all(), [
            'issuer_short_name' => 'required|string|max:255',
            'financial_year_end' => 'required|string|max:255',
            'audited_financial_statements' => 'nullable|string|max:255',
            'unaudited_financial_statements' => 'nullable|string|max:255',
            'compliance_certificate' => 'nullable|string|max:255',
            'finance_service_cover_ratio' => 'nullable|string|max:255',
            'annual_budget' => 'nullable|string|max:255',
            'computation_of_finance_to_ebitda' => 'nullable|string|max:255',
            'ratio_information_on_use_of_proceeds' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('compliance-covenants.edit', $complianceCovenant->id)
                ->withErrors($validator)
                ->withInput();
        }

        $complianceCovenant->update($request->all());

        return redirect()
            ->route('compliance-covenants.index')
            ->with('success', 'Compliance covenant updated successfully.');
    }

    /**
     * Remove the specified compliance covenant from storage.
     *
     * @param  \App\Models\ComplianceCovenant  $complianceCovenant
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplianceCovenant $complianceCovenant)
    {
        $complianceCovenant->delete();

        return redirect()
            ->route('compliance-covenants.index')
            ->with('success', 'Compliance covenant deleted successfully.');
    }

    /**
     * Restore a soft-deleted record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function restore($id)
    {
        $complianceCovenant = ComplianceCovenant::withTrashed()->findOrFail($id);
        $complianceCovenant->restore();

        return redirect()
            ->route('compliance-covenants.index')
            ->with('success', 'Compliance covenant restored successfully.');
    }

    /**
     * Display a listing of trashed records.
     *
     * @return \Illuminate\Http\Response
     */
    public function trashed()
    {
        $covenants = ComplianceCovenant::onlyTrashed()->latest()->paginate(10);
        
        return view('admin.compliance-covenants.index', [
            'covenants' => $covenants,
            'trashed' => true
        ]);
    }

    /**
     * Permanently delete a soft-deleted record.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function forceDelete($id)
    {
        $complianceCovenant = ComplianceCovenant::withTrashed()->findOrFail($id);
        $complianceCovenant->forceDelete();

        return redirect()
            ->route('compliance-covenants.trashed')
            ->with('success', 'Compliance covenant permanently deleted.');
    }

    /**
     * Generate a compliance covenant report with filters and stats.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function report(Request $request)
    {
        $query = ComplianceCovenant::query();

        // Search by issuer short name
        if ($request->has('issuer_short_name') && !empty($request->issuer_short_name)) {
            $query->where('issuer_short_name', 'LIKE', '%' . $request->issuer_short_name . '%');
        }

        // Search by financial year end
        if ($request->has('financial_year_end') && !empty($request->financial_year_end)) {
            $query->where('financial_year_end', 'LIKE', '%' . $request->financial_year_end . '%');
        }

        // Filter by compliance status
        if ($request->has('status')) {
            if ($request->status === 'compliant') {
                $query->compliant();
            } elseif ($request->status === 'non_compliant') {
                $query->nonCompliant();
            }
        }

        // Get results with pagination
        $covenants = $query->latest()->paginate(10);
        $covenants->appends($request->all());
        
        // Get statistics for the report
        $total_covenants = ComplianceCovenant::count();
        $compliant_covenants = ComplianceCovenant::compliant()->count();
        $non_compliant_covenants = ComplianceCovenant::nonCompliant()->count();
        
        return view('admin.compliance-covenants.report', compact(
            'covenants',
            'total_covenants',
            'compliant_covenants',
            'non_compliant_covenants'
        ));
    }
}