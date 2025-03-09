<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RatingsImport implements ToModel, WithHeadingRow
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
            'rating' => $row['ratings'] ?? null,
        ]);

        return null;
    }
}
