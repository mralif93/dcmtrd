<?php

namespace App\Exports;

use App\Models\Bond;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CorporateBondExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Bond::with(['issuer', 'facility', 'facility.trusteeFees'])
            ->get()
            ->map(function ($bond) {
                return [
                    $bond->issuer->issuer_short_name ?? '-',
                    $bond->facility_code,
                    $bond->bonk_sukuk_name ?? '-',
                    $bond->issuer->issuer_short_name ?? '-',
                    $bond->facility?->facility_name,
                    $bond->issuer->debenture,
                    $bond->issuer->trustee_role_1,
                    $bond->issuer->trustee_role_2,
                    $bond->facility?->facility_amount,
                    $bond->facility?->amount_outstanding,
                    $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1,
                    $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2,
                    optional($bond->issuer->trust_deed_date)?->format('d/m/Y'),
                    optional($bond->issue_date)?->format('d/m/Y'),
                    optional($bond->facility?->maturity_date)?->format('d/m/Y'),
                    optional($bond->created_at)?->format('d/m/Y H:i'),
                    optional($bond->updated_at)?->format('d/m/Y H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Issuer Short Name',
            'Facility Code',
            'Bond/Sukuk Name',
            'Name',
            'Facility Name',
            'Debenture/Loan',
            'Trustee Role1',
            'Trustee Role2',
            'Nominal Value',
            'Outstanding Size',
            'Trustee Fee Amount',
            'Trustee Fee Amount 2',
            'Trust Deed Date',
            'Issue Date',
            'Maturity Date',
            'Date Created',
            'Last Modified Date',
        ];
    }
}
