<?php

namespace App\Http\Controllers\Admin;

use App\Models\Issuer;
use App\Imports\BondImport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PaymentScheduleImport;
use App\Imports\RatingMovementsImport;
use App\Imports\TradingActivityImport;

class UploadController extends Controller
{
    public function index()
    {
        return view('admin.upload.index');
    }

    public function storeIssuer(Request $request)
    {
        $request->validate([
            'issuer_name' => 'required|string|max:255',
            'issuer_short_name' => 'required|string|max:255',
        ]);

        $issuer = Issuer::create([
            'name' => $request->issuer_name,
            'short_name' => $request->issuer_short_name,
        ]);

        return redirect()->route('issuers.show', $issuer)->with('success', 'Issuer created successfully.');
    }

    public function bondUploadForm()
    {
        return view('admin.bonds.upload');
    }

    public function storeBond(Request $request)
    {
        $file = $request->file('bond_file');

        Excel::import(new BondImport, $file);

        return back()->with('success', 'Bond data uploaded successfully!');
    }

    public function ratingMovementUploadForm()
    {
        return view('admin.rating-movements.upload');
    }

    public function storeRatingMovement(Request $request)
    {
        $file = $request->file('rating_movement_file');

        Excel::import(new RatingMovementsImport, $file);

        return back()->with('success', 'Rating movement data uploaded successfully!');
    }

    public function paymentScheduleUploadForm()
    {
        return view('admin.payment-schedules.upload');
    }

    public function storePaymentSchedule(Request $request)
    {
        $file = $request->file('payment_schedule_file');

        Excel::import(new PaymentScheduleImport, $file);

        return back()->with('success', 'Payment schedule data uploaded successfully!');
    }

    public function tradingActivityUploadForm()
    {
        return view('admin.trading-activities.upload');
    }

    public function storeTradingActivity(Request $request)
    {
        $file = $request->file('trading_activity_file');

        Excel::import(new TradingActivityImport, $file);

        return back()->with('success', 'Trading activity data uploaded successfully!');
    }
}
