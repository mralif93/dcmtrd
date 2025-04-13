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
        $reports = Bond::with('issuer')->paginate(10)->withQueryString(); // Eager load Issuer details
    
        return view('admin.dcmt-report.cb-reports', compact('reports'));
    }
    
}
