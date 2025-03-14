<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Issuer;

class MakerController extends Controller
{
    public function index()
    {
        $issuers = Issuer::query()->where('status', 'Active')->latest()->paginate(10);
        return view('maker.index', compact('issuers'));
    }
}
