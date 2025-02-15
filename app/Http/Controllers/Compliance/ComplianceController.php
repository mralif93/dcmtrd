<?php

namespace App\Http\Controllers\Compliance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    public function index()
    {
        return view('compliance.index'); // Return the compliance view
    }
}
