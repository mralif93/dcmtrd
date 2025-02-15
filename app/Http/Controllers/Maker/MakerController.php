<?php

namespace App\Http\Controllers\Maker;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MakerController extends Controller
{
    public function index()
    {
        return view('maker.index'); // Return the compliance view
    }
}
