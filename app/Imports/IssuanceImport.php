<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class IssuanceImport implements ToModel, WithHeadingRow
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

        $bondId = reset($bondIds);

        Bond::where('id', $bondId)->update([
            'amount_issued'      => $this->transformAmount($row['amount_issued_rmmil'] ?? null),
            'amount_outstanding' => $this->transformAmount($row['amount_outstanding_rmmil'] ?? null),

        ]);

        return null;
    }

    /**
     * Convert amount values to float with two decimal places.
     */
    private function transformAmount($value)
    {
        if (!$value) {
            return null;
        }

        $cleanedValue = preg_replace('/[^0-9.]/', '', $value);
        return is_numeric($cleanedValue) ? round(floatval($cleanedValue), 2) : null;
    }
}