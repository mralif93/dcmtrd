<?php

namespace App\Exports;

use App\Models\Bond;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CorporateBondExport implements FromCollection, WithHeadings, WithTitle
{
    protected Collection $bonds;

    public function __construct()
    {
        $this->bonds = Bond::with(['issuer', 'facility.trusteeFees'])->get();
    }

    public function collection()
    {
        $rows = collect();

        // Add bond data rows
        foreach ($this->bonds as $bond) {
            $rows->push([
                $bond->issuer->issuer_short_name ?? '-',
                $bond->facility_code,
                $bond->bonk_sukuk_name ?? '-',
                $bond->issuer->issuer_short_name ?? '-',
                $bond->facility?->facility_name,
                $bond->issuer->debenture,
                $bond->issuer->trustee_role_1,
                $bond->issuer->trustee_role_2,
                (float) $bond->facility?->facility_amount,
                (float) $bond->facility?->outstanding_amount,
                (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1,
                (float) $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2,
                optional($bond->issuer->trust_deed_date)?->format('d/m/Y'),
                optional($bond->issue_date)?->format('d/m/Y'),
                optional($bond->facility?->maturity_date)?->format('d/m/Y'),
                optional($bond->created_at)?->format('d/m/Y H:i'),
                optional($bond->updated_at)?->format('d/m/Y H:i'),
            ]);
        }

        // Add a few empty rows
        $rows->push([]);
        $rows->push(['Summary']);

        // Add summary bar values
        $rows->push([
            'Total Nominal Value',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $this->bonds->sum(fn($b) => (float) $b->facility?->facility_amount)
        ]);
        $rows->push([
            'Total Outstanding Size',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $this->bonds->sum(fn($b) => (float) $b->facility?->outstanding_amount)
        ]);
        $rows->push([
            'Trustee Fee Amount 1',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $this->bonds->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1)
        ]);
        $rows->push([
            'Trustee Fee Amount 2',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $this->bonds->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_2)
        ]);

        // Add empty line and Bond vs Loan
        $rows->push([]);
        $rows->push(['Bond vs Loan Summary']);
        $rows->push(['Type', 'Nominal Value (RM)', 'Outstanding Size (RM)', 'Trustee Fee (RM)']);

        $bondTotals = $this->bonds->filter(fn($b) => $b->issuer->debenture === 'Corporate Bond');
        $loanTotals = $this->bonds->filter(fn($b) => $b->issuer->debenture === 'Loan');

        $rows->push([
            'Bond',
            $bondTotals->sum(fn($b) => (float) $b->facility?->facility_amount),
            $bondTotals->sum(fn($b) => (float) $b->facility?->outstanding_amount),
            $bondTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1),
        ]);

        $rows->push([
            'Loan',
            $loanTotals->sum(fn($b) => (float) $b->facility?->facility_amount),
            $loanTotals->sum(fn($b) => (float) $b->facility?->outstanding_amount),
            $loanTotals->sum(fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1),
        ]);

        return $rows;
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
            'Trustee Fee Amount 1',
            'Trustee Fee Amount 2',
            'Trust Deed Date',
            'Issue Date',
            'Maturity Date',
            'Date Created',
            'Last Modified Date',
        ];
    }

    public function title(): string
    {
        return 'CB MASTER REPORT'; 
    }
}
