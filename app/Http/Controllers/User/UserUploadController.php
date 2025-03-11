<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Issuer;
use App\Imports\BondImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PaymentScheduleImport;
use App\Imports\RatingMovementsImport;
use App\Imports\TradingActivityImport;

class UserUploadController extends Controller
{
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

    public function UploadBond()
    {
        return view('user.bonds.upload');
    }

    public function StoreBond(Request $request)
    {
        $file = $request->file('bond_file');

        Excel::import(new BondImport, $file);

        return back()->with('success', 'Bond data uploaded successfully!');
    }

    public function UploadRatingMovement()
    {
        return view('user.rating-movements.upload');
    }

    public function StoreRatingMovement(Request $request)
    {
        $file = $request->file('rating_movement_file');

        Excel::import(new RatingMovementsImport, $file);

        return back()->with('success', 'Rating movement data uploaded successfully!');
    }

    public function UploadPaymentSchedule()
    {
        return view('user.payment-schedules.upload');
    }

    public function StorePaymentSchedule(Request $request)
    {
        $file = $request->file('payment_schedule_file');

        Excel::import(new PaymentScheduleImport, $file);

        return back()->with('success', 'Payment schedule data uploaded successfully!');
    }

    public function UploadTradingActivity()
    {
        return view('user.trading-activities.upload');
    }

    public function StoreTradingActivity(Request $request)
    {
        $file = $request->file('trading_activity_file');

        Excel::import(new TradingActivityImport, $file);

        return back()->with('success', 'Trading activity data uploaded successfully!');
    }
}
