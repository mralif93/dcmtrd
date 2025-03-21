<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\Bond;
use App\Models\Issuer;
use Illuminate\Support\Facades\Date;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SecurityInformationImport implements ToModel, WithHeadingRow
{
    public static $bondIds = []; 
    public function model(array $row)
    {
        $issuer = Issuer::firstOrCreate(['issuer_name' => $row['issuer_name'] ?? null]);

        $bond = new Bond([
            'bond_sukuk_name'         => $row['bondsukuk_name'] ?? null,
            'category'                => $row['category'] ?? null,
            'principal'               => $row['principle'] ?? null,
            'isin_code'               => $row['isin_code'] ?? null,
            'stock_code'              => $row['stock_code'] ?? null,
            'instrument_code'         => $row['instrument_code'] ?? null,
            'sub_category'            => $row['sub_category'] ?? null,
            'issue_date'              => $this->transformDate($row['issue_date'] ?? null),
            'maturity_date'           => $this->transformDate($row['maturity_date'] ?? null),
            'coupon_rate'             => $this->transformDecimal($row['coupon_rate'] ?? null),
            'coupon_type'             => $row['coupon_type'] ?? null,
            'coupon_frequency'        => $row['coupon_frequency'] ?? null,
            'day_count'               => $row['day_count'] ?? null,
            'issue_tenure_years'      => $this->transformDecimal($row['issue_tenure_years'] ?? null),
            'residual_tenure_years'   => $this->transformDecimal($row['residual_tenure_years'] ?? null),
            'issuer_id'               => $issuer->id,
            'sub_name'                => $issuer->issuer_name,
            'status'                  => 'Pending',
            'prepared_by'             => auth()->user()->id
        ]);

        $bond->save();

        self::$bondIds[] = $bond->id;

        // dd($bond);  

        return $bond;

    }

    private function transformDate($date)
    {
        if (!$date) {
            return null;
        }

        // Handle Excel numeric dates
        if (is_numeric($date)) {
            return Carbon::createFromTimestamp(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($date))->format('Y-m-d');
        }

        // Handle normal string dates
        return Carbon::parse($date)->format('Y-m-d');
    }

    private function transformDecimal($value)
    {
        return $value !== null ? (float) str_replace(',', '', $value) : null;
    }
}