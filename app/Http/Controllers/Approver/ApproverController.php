<?php

namespace App\Http\Controllers\Approver;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;

class ApproverController extends Controller
{
    public function index()
    {
        $issuers = Issuer::query()->where('status', 'Pending')->latest()->paginate(10);
        return view('approver.index', compact('issuers'));
    }
}
