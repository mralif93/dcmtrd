<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Imports\SecurityInformationImport; // Import SecurityInformationImport

class LatestTradingImport implements ToModel, WithHeadingRow
{
    protected $securityImport;

    public function __construct(SecurityInformationImport $securityImport)
    {
        $this->securityImport = $securityImport;
    }
    public function model(array $row)
    {
        // dd($row);
        $bondIds = SecurityInformationImport::$bondIds;

        if (empty($bondIds)) {
            dd("Error: No bond ID found in SecurityInformationImport", $bondIds);
        }

        $bondId = $bondIds[0];

        Bond::where('id', $bondId)->update([
            'last_traded_yield'  => $this->transformDecimal($row['last_traded_yield'] ?? null),
            'last_traded_price'  => $this->transformDecimal($row['last_traded_price_rm'] ?? null),
            'last_traded_amount' => $this->transformDecimal($row["last_traded_amount_rmmil"] ?? null),
            'last_traded_date'   => $this->transformDate($row['last_traded_date'] ?? null),
        ]);
        
        return null;
    }

    private function transformDate($value)
    {
        if (!$value) {
            return null;
        }
    
        // Handle Excel numeric date format
        if (is_numeric($value)) {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d');
        }
    
        // Define multiple possible formats
        $formats = ['d-M-Y', 'j-M-Y', 'd/m/Y', 'm/d/Y', 'Y-m-d'];
    
        foreach ($formats as $format) {
            try {
                return Carbon::createFromFormat($format, trim($value))->format('Y-m-d');
            } catch (\Exception $e) {
                continue; 
            }
        }
    
        return null;
    }
    

    private function transformDecimal($value)
    {
        return is_numeric($value) ? number_format((float) $value, 2, '.', '') : null;
    }
}

