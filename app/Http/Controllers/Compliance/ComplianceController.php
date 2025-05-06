<?php

namespace App\Http\Controllers\Compliance;

use App\Models\ReportBatch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CorporateBondExportBatch;

class ComplianceController extends Controller
{
    public function index()
    {
        return view('compliance.index'); // Return the compliance view
    }

    public function viewBatches()
    {
        $batches = ReportBatch::withCount('items')->orderByDesc('cut_off_at')->paginate(10);
        return view('compliance.view-batches', compact('batches'));
    }

    public function downloadBatch($id)
    {
        $batch = ReportBatch::findOrFail($id);

        return Excel::download(new CorporateBondExportBatch($batch), 'corporate_bonds_' . $batch->id . '.xlsx');
    }
}
