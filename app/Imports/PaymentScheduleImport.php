<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\PaymentSchedule;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PaymentScheduleImport implements WithMultipleSheets
{
    protected $bondIds = [];

    public function sheets(): array
    {
        return [
            1 => new BondsSheetImport($this->bondIds),  // Sheet 2 (Bonds) - MUST RUN FIRST
            0 => new PaymentScheduleSheetImport($this->bondIds), // Sheet 1 (Ratings)
        ];
    }
}

class BondsSheetImport implements ToCollection
{
    protected $bondIds;

    public function __construct(&$bondIds)
    {
        $this->bondIds = &$bondIds;
    }

    public function collection(Collection $rows)
    {
        $rows->shift(); // Skip header row

        foreach ($rows as $row) {
            if ($row->filter()->isEmpty()) continue;

            $bondName = trim($row[0]); // Bond/Sukuk Name

            $bond = Bond::where('bond_sukuk_name', $bondName)->first();

            if ($bond) {
                $this->bondIds[$bondName] = $bond->id;
                
            }
        }
    }
}

class PaymentScheduleSheetImport implements ToCollection
{
    protected $bondIds;

    public function __construct(&$bondIds)
    {
        $this->bondIds = &$bondIds;
    }

    public function collection(Collection $rows)
    {
        $rows->shift(); // Skip header row

        foreach ($rows as $row) {
            if ($row->filter()->isEmpty()) continue;
        
            $startDate = Carbon::createFromFormat('d-M-Y', trim($row[1]))->toDateString();
            // dd($startDate);
            $endDate = Carbon::createFromFormat('d-M-Y', trim($row[2]))->toDateString();
            $paymentDate = Carbon::createFromFormat('d-M-Y', trim($row[3]))->toDateString();
            $exDate = Carbon::createFromFormat('d-M-Y', trim($row[4]))->toDateString();
            $couponRate = trim($row[5]);
            $adjustmentDate = Carbon::createFromFormat('d-M-Y', trim($row[6]))->toDateString();
        
            $bondId = reset($this->bondIds);
        
            if ($bondId) {
                PaymentSchedule::create([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'payment_date' => $paymentDate,
                    'ex_date' => $exDate,
                    'coupon_rate' => $couponRate,
                    'adjustment_date' => $adjustmentDate,
                    'bond_id' => $bondId,
                ]);
            }
        }
        
    }
}