<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AdditionalInfoImport implements ToModel, WithHeadingRow
{
    protected $securityImport;

    public function __construct(SecurityInformationImport $securityImport)
    {
        $this->securityImport = $securityImport;
    }
    public function model(array $row)
    {
        $bondIds = SecurityInformationImport::$bondIds; 

        if (empty($bondIds)) {
            dd("Error: No bond ID found in SecurityInformationImport", $bondIds);
        }

        $bondId = reset($bondIds); 

        Bond::where('id', $bondId)->update([
            'lead_arranger'   => isset($row['lead_arranger']) ? trim($row['lead_arranger']) : null,
            'facility_agent'  => isset($row['facility_agent']) ? trim($row['facility_agent']) : null,
            'facility_code'   => isset($row['facility_code']) ? (string) trim($row['facility_code']) : null,
        ]);

        return null;
    }
}