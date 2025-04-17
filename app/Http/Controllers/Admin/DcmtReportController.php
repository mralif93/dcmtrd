<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bond;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DcmtReportController extends Controller
{
    public function index()
    {
        return view('admin.dcmt-report.index');
    }
    public function cbReports()
    {
        $reports = Bond::with(['issuer', 'facility.trusteeFees'])->paginate(10)->withQueryString();

        $totalNominalValue = $reports->sum(fn($bond) => (float) $bond->facility?->facility_amount);
        $totalOutstandingSize = $reports->sum(fn($bond) => (float) $bond->amount_outstanding);
        $totalTrusteeFeeAmount1 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1);
        $totalTrusteeFeeAmount2 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2);

        return view('admin.dcmt-report.cb-reports', compact(
            'reports',
            'totalNominalValue',
            'totalOutstandingSize',
            'totalTrusteeFeeAmount1',
            'totalTrusteeFeeAmount2'
        ));
    }

    public function trusteeReports()
    {
        return view('admin.dcmt-report.trustee-reports');
    }
}
