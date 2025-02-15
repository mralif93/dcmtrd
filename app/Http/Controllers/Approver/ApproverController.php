<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApproverController extends Controller
{
    public function index()
    {
        return view('approver.index');
    }
}
