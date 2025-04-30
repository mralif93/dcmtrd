<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DcmtReportController extends Controller
{
    public function index()
    {
        return view('admin.dcmt-report.index');
    }
    public function indexA()
    {
        return view('approver.dcmt-report.index');
    }
    public function cbReports(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        $reports = Bond::with(['issuer', 'facility.trusteeFees'])
            ->when($search, function ($query, $search) {
                return $query->where('facility_code', 'like', '%' . $search . '%')
                    ->orWhereHas('issuer', function ($query) use ($search) {
                        $query->where('issuer_short_name', 'like', '%' . $search . '%')
                            ->orWhere('issuer_name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10)
            ->withQueryString();

        $totalNominalValue = $reports->sum(fn($bond) => (float) $bond->facility?->facility_amount);
        $totalOutstandingSize = $reports->sum(fn($bond) => (float) $bond->amount_outstanding);
        $totalTrusteeFeeAmount1 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1);
        $totalTrusteeFeeAmount2 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2);

        $bondTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Debenture');
        $loanTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Loan');

        $bondNominal = $bondTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
        $bondOutstanding = $bondTotals->sum(fn($b) => (float) $b->amount_outstanding);
        $bondTrusteeFee = $bondTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1);

        $loanNominal = $loanTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
        $loanOutstanding = $loanTotals->sum(fn($b) => (float) $b->amount_outstanding);
        $loanTrusteeFee = $loanTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1);

        return view('admin.dcmt-report.cb-reports', compact(
            'reports',
            'totalNominalValue',
            'totalOutstandingSize',
            'totalTrusteeFeeAmount1',
            'totalTrusteeFeeAmount2',
            'bondNominal',
            'bondOutstanding',
            'bondTrusteeFee',
            'loanNominal',
            'loanOutstanding',
            'loanTrusteeFee'
        ));
    }

    public function cbReportsA(Request $request)
    {
        // Get the search query from the request
        $search = $request->input('search');

        $reports = Bond::with(['issuer', 'facility.trusteeFees'])
            ->when($search, function ($query, $search) {
                return $query->where('facility_code', 'like', '%' . $search . '%')
                    ->orWhereHas('issuer', function ($query) use ($search) {
                        $query->where('issuer_short_name', 'like', '%' . $search . '%')
                            ->orWhere('issuer_name', 'like', '%' . $search . '%');
                    });
            })
            ->paginate(10)
            ->withQueryString();

        $totalNominalValue = $reports->sum(fn($bond) => (float) $bond->facility?->facility_amount);
        $totalOutstandingSize = $reports->sum(fn($bond) => (float) $bond->amount_outstanding);
        $totalTrusteeFeeAmount1 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1);
        $totalTrusteeFeeAmount2 = $reports->sum(fn($bond) => (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2);

        $bondTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Debenture');
        $loanTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Loan');

        $bondNominal = $bondTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
        $bondOutstanding = $bondTotals->sum(fn($b) => (float) $b->amount_outstanding);
        $bondTrusteeFee = $bondTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1);

        $loanNominal = $loanTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
        $loanOutstanding = $loanTotals->sum(fn($b) => (float) $b->amount_outstanding);
        $loanTrusteeFee = $loanTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1);

        return view('approver.dcmt-report.cb-reports', compact(
            'reports',
            'totalNominalValue',
            'totalOutstandingSize',
            'totalTrusteeFeeAmount1',
            'totalTrusteeFeeAmount2',
            'bondNominal',
            'bondOutstanding',
            'bondTrusteeFee',
            'loanNominal',
            'loanOutstanding',
            'loanTrusteeFee'
        ));
    }

    public function trusteeReports()
    {
        // Eager-load relationships and filter only Corporate Trust issuers
        $reports = Issuer::with(['facilities.trusteeFees'])
            ->where('debenture', 'Corporate Trust')
            ->paginate(10)
            ->withQueryString();

        // Compute total trustee fee for each issuer using functional reduce
        $reports->getCollection()->transform(function ($issuer) {
            $totalTrusteeFee = $issuer->facilities->reduce(function ($carry, $facility) {
                $feeTotal = $facility->trusteeFees->reduce(function ($subCarry, $fee) {
                    return $subCarry + ($fee->trustee_fee_amount_1 ?? 0) + ($fee->trustee_fee_amount_2 ?? 0);
                }, 0);
                return $carry + $feeTotal;
            }, 0);

            // Attach to issuer object
            $issuer->total_trustee_fee = $totalTrusteeFee;
            return $issuer;
        });

        return view('admin.dcmt-report.trustee-reports', compact('reports'));
    }
}
