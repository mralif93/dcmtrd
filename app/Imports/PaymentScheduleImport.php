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

            // Safe date parsing
            $startDate = $this->parseDate($row[1]);
            $endDate = $this->parseDate($row[2]);
            $paymentDate = $this->parseDate($row[3]);
            $exDate = $this->parseDate($row[4]);
            $couponRate = trim($row[5]);
            $adjustmentDate = $this->parseDate($row[6]);

            $bondId = reset($this->bondIds);

            if ($bondId && $startDate && $endDate && $paymentDate && $exDate && $adjustmentDate) {
                PaymentSchedule::create([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'payment_date' => $paymentDate,
                    'ex_date' => $exDate,
                    'coupon_rate' => $couponRate,
                    'adjustment_date' => $adjustmentDate,
                    'bond_id' => $bondId,
                ]);
            } else {
                logger()->warning("Skipping row due to missing or invalid data: ", $row->toArray());
            }
        }
    }

    protected function parseDate($date)
    {
        $date = trim($date);

        if (!$date) return null;

        try {
            return Carbon::createFromFormat('d-M-Y', $date)->toDateString();
        } catch (\Exception $e) {
            logger()->warning("Invalid date format: {$date}");
            return null;
        }
    }
}
