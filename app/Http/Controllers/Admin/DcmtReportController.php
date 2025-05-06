<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bond;
use App\Models\Issuer;
use App\Models\ReportBatch;
use Illuminate\Http\Request;
use App\Models\ReportBatchTrustee;
use App\Exports\CorporateBondExport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CorporateBondExportBatch;

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
    public function viewBatches()
    {
        $batches = ReportBatch::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('admin.dcmt-report.view-batches', compact('batches'));
    }

    public function cutOff(Request $request)
    {
        $user = auth()->user();
        $cutoffTime = now();

        // Prevent multiple cut-offs in a single day
        $alreadyCutoffToday = ReportBatch::whereDate('cut_off_at', $cutoffTime->toDateString())
            ->where('created_by', $user->id) // optional: restrict per user
            ->exists();

        if ($alreadyCutoffToday) {
            return redirect()->back()->with('error', 'You have already performed a cut-off today.');
        }

        $batch = ReportBatch::create([
            'title_report' => 'CB Master Report - ' . $cutoffTime->format('Y-m-d'),
            'cut_off_at' => $cutoffTime,
            'created_by' => $user->id,
        ]);

        $search = $request->input('search');

        $reports = Bond::with(['issuer', 'facility.trusteeFees'])
            ->when($search, function ($query, $search) {
                return $query->where('facility_code', 'like', '%' . $search . '%')
                    ->orWhereHas('issuer', function ($query) use ($search) {
                        $query->where('issuer_short_name', 'like', '%' . $search . '%')
                            ->orWhere('issuer_name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        foreach ($reports as $bond) {
            $batch->items()->create([
                'bond_name' => $bond->bonk_sukuk_name,
                'facility_code' => $bond->facility_code,
                'issuer_short_name' => $bond->issuer->issuer_short_name ?? null,
                'issuer_name' => $bond->issuer->issuer_short_name ?? null,
                'facility_name' => $bond->facility?->facility_name,
                'debenture_or_loan' => $bond->issuer->debenture,
                'trustee_role_1' => $bond->issuer->trustee_role_1,
                'trustee_role_2' => $bond->issuer->trustee_role_2,
                'nominal_value' => $bond->facility?->facility_amount,
                'outstanding_size' => $bond->amount_outstanding,
                'trustee_fee_1' => $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1,
                'trustee_fee_2' => $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2,
                'trust_deed_date' => $bond->issuer->trust_deed_date,
                'issue_date' => $bond->issue_date,
                'maturity_date' => $bond->facility?->maturity_date,
            ]);
        }

        return redirect()->route('dcmt-reports.cb-reports')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function downloadBatch($id)
    {
        $batch = ReportBatch::findOrFail($id);

        return Excel::download(new CorporateBondExportBatch($batch), $batch->title_report . '.xlsx');
    }

    public function deleteBatch($id)
    {
        $batch = ReportBatch::findOrFail($id);
        $batch->delete();

        return redirect()->route('dcmt-reports.cb-reports.batches')
            ->with('success', 'Batch deleted successfully.');
    }

    public function viewTrusteeBatches()
    {
        $batches = ReportBatchTrustee::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('admin.dcmt-report.view-trustee-batches', compact('batches'));
    }

    public function cutOffTrustee(Request $request)
    {
        $user = auth()->user();
        $cutoffTime = now();

        // Prevent multiple cut-offs in a single day
        $alreadyCutoffToday = ReportBatchTrustee::whereDate('cut_off_at', $cutoffTime->toDateString())
            ->where('created_by', $user->id) // optional: restrict per user
            ->exists();

        if ($alreadyCutoffToday) {
            return redirect()->back()->with('error', 'You have already performed a cut-off today.');
        }

        $batch = ReportBatchTrustee::create([
            'title_report' => 'Trustee Master Report - ' . $cutoffTime->format('Y-m-d'),
            'cut_off_at' => $cutoffTime,
            'created_by' => $user->id,
        ]);

        $reports = Issuer::with(['facilities.trusteeFees'])
            ->where('debenture', 'Corporate Trust')
            ->paginate(10)
            ->withQueryString();

        foreach ($reports as $bond) {
            $batch->items()->create([
                'issuer_short_name' => $bond->issuer_short_name ?? null,
                'issuer_name' => $bond->issuer_name ?? null,
                'debenture' => $bond->debenture,
                'trust_amount_escrow_sum' => is_numeric($bond->trust_amount_escrow_sum) ? $bond->trust_amount_escrow_sum : 0,
                'no_of_share' => is_numeric($bond->no_of_share) ? $bond->no_of_share : 0,
                'outstanding_size' => is_numeric($bond->outstanding_size) ? $bond->outstanding_size : 0,
                'total_trustee_fee' => is_numeric($bond->total_trustee_fee) ? $bond->total_trustee_fee : 0,
            ]);
        }

        return redirect()->route('dcmt-reports.cb-reports')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function downloadBatchTrustee($id)
    {
        $batch = ReportBatchTrustee::findOrFail($id);

        return Excel::download(new TrusteeExportBatch($batch), $batch->title_report . '.xlsx');
    }
    public function deleteTrusteeBatch($id)
    {
        $batch = ReportBatchTrustee::findOrFail($id);
        $batch->delete();

        return redirect()->route('dcmt-reports.cb-reports.trustee-batches')
            ->with('success', 'Batch deleted successfully.');
    }
}
