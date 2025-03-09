<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\RatingMovement;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RatingMovementsImport implements WithMultipleSheets
{
    protected $bondIds = [];

    public function sheets(): array
    {
        return [
            1 => new BondsSheetImport($this->bondIds),  // Sheet 2 (Bonds) - MUST RUN FIRST
            0 => new RatingMovementsSheetImport($this->bondIds), // Sheet 1 (Ratings)
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

class RatingMovementsSheetImport implements ToCollection
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

            $ratingAgency = trim($row[0]); 
            $effectiveDate = Carbon::createFromFormat('d-M-Y', trim($row[1]))->toDateString();
            $ratingTenure = trim($row[2]);
            $rating = trim($row[3]);
            $ratingAction = trim($row[4]);
            $ratingOutlook = trim($row[5]);
            $ratingWatch = isset($row[6]) ? trim($row[6]) : null;

            $bondId = reset($this->bondIds);

            if ($bondId) {
                RatingMovement::create([
                    'rating_agency' => $ratingAgency,
                    'effective_date' => $effectiveDate,
                    'rating_tenure' => $ratingTenure,
                    'rating' => $rating,
                    'rating_action' => $ratingAction,
                    'rating_outlook' => $ratingOutlook,
                    'rating_watch' => $ratingWatch,
                    'bond_id' => $bondId,
                ]);
            }
        }
    }
}
