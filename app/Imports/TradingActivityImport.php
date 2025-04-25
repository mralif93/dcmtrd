<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\TradingActivity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class TradingActivityImport implements WithMultipleSheets
{
    protected $bondIds = [];

    public function sheets(): array
    {
        return [
            1 => new BondsSheetImport($this->bondIds),  // Sheet 2 (Bonds) - MUST RUN FIRST
            0 => new TradingActivitySheetImport($this->bondIds), // Sheet 1 (Trading Activity)
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

            $bondName = trim($row[0]);

            $bond = Bond::where('bond_sukuk_name', $bondName)->first();

            if ($bond) {
                $this->bondIds[$bondName] = $bond->id;
            }
        }
    }
}

class TradingActivitySheetImport implements ToCollection
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

            try {
                $tradeDate = is_numeric($row[0])
                    ? ExcelDate::excelToDateTimeObject($row[0])->format('Y-m-d')
                    : Carbon::parse(trim($row[0]))->toDateString();
            } catch (\Exception $e) {
                continue; // Skip row if date fails to parse
            }

            try {
                $valueDate = trim($row[5]) ? (is_numeric($row[5])
                    ? ExcelDate::excelToDateTimeObject($row[5])->format('Y-m-d')
                    : Carbon::parse(trim($row[5]))->toDateString()) : null;
            } catch (\Exception $e) {
                $valueDate = null;
            }

            $inputTime = trim($row[1]) ? Carbon::parse(trim($row[1]))->format('H:i:s') : null;
            $amount = trim($row[2]);
            $price = trim($row[3]);
            $yield = trim($row[4]);

            $bondId = reset($this->bondIds); // First bond ID

            if ($bondId) {
                TradingActivity::create([
                    'trade_date' => $tradeDate,
                    'input_time' => $inputTime,
                    'amount' => $amount,
                    'price' => $price,
                    'yield' => $yield,
                    'value_date' => $valueDate,
                    'bond_id' => $bondId,
                ]);
            }
        }
    }
}
