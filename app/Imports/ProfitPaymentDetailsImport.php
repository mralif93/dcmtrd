<?php

namespace App\Imports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;

class ProfitPaymentDetailsImport implements ToModel, WithHeadingRow
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
            'coupon_accrual'            => $this->transformDate($row['coupon_accrual'] ?? null),
            'first_coupon_payment_date' => $this->transformDate($row['first_coupon_payment_date'] ?? null),
            'next_coupon_payment_date'  => $this->transformDate($row['next_coupon_payment_date'] ?? null),
            'prev_coupon_payment_date'  => $this->transformDate($row['prev_coupon_payment_date'] ?? null),
            'last_coupon_payment_date'  => $this->transformDate($row['last_coupon_payment_date'] ?? null),
        ]);

        return null;
    }

    /**
     * Convert Excel date to Y-m-d format.
     */
    private function transformDate($value)
    {
        if (!$value) {
            return null;
        }

        if (is_numeric($value)) {
            return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
        }

        try {
            return Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; 
        }
    }
}
