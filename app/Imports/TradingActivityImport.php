<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\TradingActivity;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TradingActivityImport implements WithMultipleSheets
{
    protected $bondIds = [];

    public function sheets(): array
    {
        return [
            1 => new BondsSheetImport($this->bondIds),  // Sheet 2 (Bonds) - MUST RUN FIRST
            0 => new TradingActivitySheetImport($this->bondIds), // Sheet 1 (Ratings)
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
        
            $tradeDate = Carbon::createFromFormat('d-M-Y', trim($row[0]))->toDateString();
            $inputTime = trim($row[1]) ? Carbon::parse(trim($row[1]))->format('H:i:s') : null;
            $amount = trim($row[2]);
            $price = trim($row[3]);
            $yield = trim($row[4]);
            $valueDate = trim($row[5]) ? Carbon::createFromFormat('d-M-Y', trim($row[5]))->toDateString() : null;
        
            $bondId = reset($this->bondIds);
        
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
