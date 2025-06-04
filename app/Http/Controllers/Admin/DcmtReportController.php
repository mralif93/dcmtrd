<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bond;
use App\Models\Issuer;
use App\Models\ReportBatch;
use Illuminate\Http\Request;
use App\Models\ReportBatchTrustee;
use App\Exports\TrusteeExportBatch;
use App\Models\FacilityInformation;
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
        $search = $request->input('search');

        // Base query (used for both full and paginated datasets)
        $baseQuery = FacilityInformation::with(['issuer.bonds', 'trusteeFees'])
            ->whereHas('issuer', function ($query) {
                $query->where('status', 'Active')
                    ->whereIn('debenture', ['Corporate Bond', 'Loan']);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('facility_code', 'like', '%' . $search . '%')
                        ->orWhere('facility_name', 'like', '%' . $search . '%')
                        ->orWhereHas('issuer', function ($q) use ($search) {
                            $q->where('issuer_short_name', 'like', '%' . $search . '%')
                                ->orWhere('issuer_name', 'like', '%' . $search . '%');
                        });
                });
            });

        // Clone the base query for totals (no pagination)
        $allFacilities = $baseQuery->get();

        // Now paginate for display
        $facilities = $baseQuery->paginate(10)->withQueryString();

        // Grand totals (based on all results)
        $totalNominalValue = $allFacilities->sum(fn($f) => (float) $f->facility_amount);
        $totalOutstandingSize = $allFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $totalTrusteeFeeAmount1 = $allFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));
        $totalTrusteeFeeAmount2 = $allFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_2'));

        $bondFacilities = $allFacilities->filter(fn($f) => $f->issuer?->debenture === 'Corporate Bond');
        $loanFacilities = $allFacilities->filter(fn($f) => $f->issuer?->debenture === 'Loan');

        $bondNominal = $bondFacilities->sum(fn($f) => (float) $f->facility_amount);
        $bondOutstanding = $bondFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $bondTrusteeFee = $bondFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));

        $loanNominal = $loanFacilities->sum(fn($f) => (float) $f->facility_amount);
        $loanOutstanding = $loanFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $loanTrusteeFee = $loanFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));

        return view('admin.dcmt-report.cb-reports', compact(
            'facilities',
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
        $search = $request->input('search');

        // Base query (used for both full and paginated datasets)
        $baseQuery = FacilityInformation::with(['issuer.bonds', 'trusteeFees'])
            ->whereHas('issuer', function ($query) {
                $query->where('status', 'Active')
                    ->whereIn('debenture', ['Corporate Bond', 'Loan']);
            })
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('facility_code', 'like', '%' . $search . '%')
                        ->orWhere('facility_name', 'like', '%' . $search . '%')
                        ->orWhereHas('issuer', function ($q) use ($search) {
                            $q->where('issuer_short_name', 'like', '%' . $search . '%')
                                ->orWhere('issuer_name', 'like', '%' . $search . '%');
                        });
                });
            });

        // Clone the base query for totals (no pagination)
        $allFacilities = $baseQuery->get();

        // Now paginate for display
        $facilities = $baseQuery->paginate(10)->withQueryString();

        // Grand totals (based on all results)
        $totalNominalValue = $allFacilities->sum(fn($f) => (float) $f->facility_amount);
        $totalOutstandingSize = $allFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $totalTrusteeFeeAmount1 = $allFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));
        $totalTrusteeFeeAmount2 = $allFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_2'));

        $bondFacilities = $allFacilities->filter(fn($f) => $f->issuer?->debenture === 'Corporate Bond');
        $loanFacilities = $allFacilities->filter(fn($f) => $f->issuer?->debenture === 'Loan');

        $bondNominal = $bondFacilities->sum(fn($f) => (float) $f->facility_amount);
        $bondOutstanding = $bondFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $bondTrusteeFee = $bondFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));

        $loanNominal = $loanFacilities->sum(fn($f) => (float) $f->facility_amount);
        $loanOutstanding = $loanFacilities->sum(fn($f) => (float) $f->outstanding_amount);
        $loanTrusteeFee = $loanFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'));

        return view('approver.dcmt-report.cb-reports', compact(
            'facilities',
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

    public function trusteeReports(Request $request)
    {
        $search = $request->input('search');

        // Build base query
        $query = Issuer::with(['facilities.trusteeFees'])
            ->where('status', 'Active')
            ->where('debenture', 'Corporate Trust');

        // Apply search if provided
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('issuer_name', 'like', "%{$search}%")
                    ->orWhere('issuer_short_name', 'like', "%{$search}%")
                    ->orWhereHas('facilities', function ($q2) use ($search) {
                        $q2->where('facility_code', 'like', "%{$search}%")
                            ->orWhere('facility_name', 'like', "%{$search}%");
                    });
            });
        }

        // Paginate and keep query string
        $reports = $query->paginate(10)->withQueryString();

        // Compute total trustee fee for each issuer
        $reports->getCollection()->transform(function ($issuer) {
            $totalTrusteeFee = $issuer->facilities->reduce(function ($carry, $facility) {
                $feeTotal = $facility->trusteeFees->reduce(function ($subCarry, $fee) {
                    return $subCarry + ($fee->trustee_fee_amount_1 ?? 0) + ($fee->trustee_fee_amount_2 ?? 0);
                }, 0);
                return $carry + $feeTotal;
            }, 0);

            $issuer->total_trustee_fee = $totalTrusteeFee;
            return $issuer;
        });

        return view('admin.dcmt-report.trustee-reports', compact('reports'));
    }
    public function trusteeReportsA()
    {
        // Eager-load relationships and filter only Corporate Trust issuers
        $reports = Issuer::with(['facilities.trusteeFees'])
            ->where('status', 'Active')
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

        return view('approver.dcmt-report.trustee-reports', compact('reports'));
    }
    public function viewBatches()
    {
        $batches = ReportBatch::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('admin.dcmt-report.view-batches', compact('batches'));
    }

    public function viewBatchesA()
    {
        $batches = ReportBatch::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('approver.dcmt-report.view-batches', compact('batches'));
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

        $reports = FacilityInformation::with(['issuer.bonds', 'trusteeFees'])
            ->whereHas('issuer', function ($query) {
                $query->where('status', 'Active') // Only active issuers
                    ->whereIn('debenture', ['Corporate Bond', 'Loan']);
            })
            ->when($search, function ($query, $search) {
                $query->where('facility_code', 'like', '%' . $search . '%')
                    ->orWhere('facility_name', 'like', '%' . $search . '%')
                    ->orWhereHas('issuer', function ($query) use ($search) {
                        $query->where('issuer_short_name', 'like', '%' . $search . '%')
                            ->orWhere('issuer_name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        foreach ($reports as $bond) {
            $batch->items()->create([
                'bond_name' => $bond->issuer_short_name,
                'facility_code' => $bond->facility_code,
                'issuer_short_name' => $bond->issuer->issuer_short_name ?? null,
                'issuer_name' => $bond->issuer->issuer_short_name ?? null,
                'facility_name' => $bond->facility_name,
                'debenture_or_loan' => $bond->issuer->debenture,
                'trustee_role_1' => $bond->issuer->trustee_role_1,
                'trustee_role_2' => $bond->issuer->trustee_role_2,
                'nominal_value' => $bond->facility_amount,
                'outstanding_size' => $bond->outstanding_amount,
                'trustee_fee_1' => $bond->trusteeFees->first()?->trustee_fee_amount_1,
                'trustee_fee_2' => $bond->trusteeFees->first()?->trustee_fee_amount_2,
                'trust_deed_date' => $bond->issuer->trust_deed_date,
                'issue_date' => $bond->issuer->bonds->first()?->issue_date,
                'maturity_date' => $bond->maturity_date,
            ]);
        }

        return redirect()->route('dcmt-reports.cb-reports')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function cutOffA(Request $request)
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

        $reports = FacilityInformation::with(['issuer.bonds', 'trusteeFees'])
            ->whereHas('issuer', function ($query) {
                $query->where('status', 'Active') // Only active issuers
                    ->whereIn('debenture', ['Corporate Bond', 'Loan']);
            })
            ->when($search, function ($query, $search) {
                $query->where('facility_code', 'like', '%' . $search . '%')
                    ->orWhere('facility_name', 'like', '%' . $search . '%')
                    ->orWhereHas('issuer', function ($query) use ($search) {
                        $query->where('issuer_short_name', 'like', '%' . $search . '%')
                            ->orWhere('issuer_name', 'like', '%' . $search . '%');
                    });
            })
            ->get();

        foreach ($reports as $bond) {
            $batch->items()->create([
                'bond_name' => $bond->issuer_short_name,
                'facility_code' => $bond->facility_code,
                'issuer_short_name' => $bond->issuer->issuer_short_name ?? null,
                'issuer_name' => $bond->issuer->issuer_short_name ?? null,
                'facility_name' => $bond->facility_name,
                'debenture_or_loan' => $bond->issuer->debenture,
                'trustee_role_1' => $bond->issuer->trustee_role_1,
                'trustee_role_2' => $bond->issuer->trustee_role_2,
                'nominal_value' => $bond->facility_amount,
                'outstanding_size' => $bond->outstanding_amount,
                'trustee_fee_1' => $bond->trusteeFees->first()?->trustee_fee_amount_1,
                'trustee_fee_2' => $bond->trusteeFees->first()?->trustee_fee_amount_2,
                'trust_deed_date' => $bond->issuer->trust_deed_date,
                'issue_date' => $bond->issuer->bonds->first()?->issue_date,
                'maturity_date' => $bond->maturity_date,
            ]);
        }

        return redirect()->route('a.dcmt-reports.cb-reports.a')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function downloadBatch($id)
    {
        $batch = ReportBatch::findOrFail($id);

        return Excel::download(new CorporateBondExportBatch($batch), $batch->title_report . '.xlsx');
    }
    public function downloadBatchA($id)
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

    public function deleteBatchA($id)
    {
        $batch = ReportBatch::findOrFail($id);
        $batch->delete();

        return redirect()->route('a.dcmt-reports.cb-reports.batches.a')
            ->with('success', 'Batch deleted successfully.');
    }

    public function viewTrusteeBatches()
    {
        $batches = ReportBatchTrustee::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('admin.dcmt-report.view-trustee-batches', compact('batches'));
    }

    public function viewTrusteeBatchesA()
    {
        $batches = ReportBatchTrustee::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('approver.dcmt-report.view-trustee-batches', compact('batches'));
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

        return redirect()->route('dcmt-reports.trustee-reports')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function cutOffTrusteeA(Request $request)
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

        return redirect()->route('a.dcmt-reports.trustee-reports.a')->with('success', 'Report cut off and stored in batch successfully.');
    }

    public function downloadBatchTrustee($id)
    {
        $batch = ReportBatchTrustee::findOrFail($id);

        return Excel::download(new TrusteeExportBatch($batch), $batch->title_report . '.xlsx');
    }

    public function downloadBatchTrusteeA($id)
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
    public function deleteTrusteeBatchA($id)
    {
        $batch = ReportBatchTrustee::findOrFail($id);
        $batch->delete();

        return redirect()->route('a.dcmt-reports.cb-reports.trustee-batches.a')
            ->with('success', 'Batch deleted successfully.');
    }
}
