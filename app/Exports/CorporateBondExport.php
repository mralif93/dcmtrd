<?php

namespace App\Exports;

use App\Models\FacilityInformation;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;

class CorporateBondExport implements FromCollection, WithHeadings, WithTitle
{
    protected Collection $facilities;

    public function __construct()
    {
        $this->facilities = FacilityInformation::with(['issuer', 'trusteeFees'])
            ->whereHas('issuer', function ($query) {
                $query->where('status', 'Active')
                    ->whereIn('debenture', ['Corporate Bond', 'Loan']);
            })
            ->get();
    }

    public function collection()
    {
        $rows = collect();

        foreach ($this->facilities as $facility) {
            $rows->push([
                $facility->issuer_short_name ?? '-',
                $facility->facility_code,
                $facility->issuer->issuer_name ?? '-',
                $facility->facility_name,
                $facility->issuer->debenture,
                $facility->issuer->trustee_role_1,
                $facility->issuer->trustee_role_2,
                (float) $facility->facility_amount,
                (float) $facility->outstanding_amount,
                (float) $facility->trusteeFees->first()?->trustee_fee_amount_1,
                (float) $facility->trusteeFees->first()?->trustee_fee_amount_2,
                optional($facility->issuer->trust_deed_date)?->format('d/m/Y'),
                optional($facility->issue_date)?->format('d/m/Y'),
                optional($facility->maturity_date)?->format('d/m/Y'),
                optional($facility->created_at)?->format('d/m/Y H:i'),
                optional($facility->updated_at)?->format('d/m/Y H:i'),
            ]);
        }

        // Summary
        $rows->push([]);
        $rows->push(['Summary']);

        $rows->push([
            'Total Nominal Value',
            '',
            '',
            '',
            '',
            '',
            '',
            $this->facilities->sum(fn($f) => (float) $f->facility_amount)
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
            $this->facilities->sum(fn($f) => (float) $f->outstanding_amount)
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
            $this->facilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1'))
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
            $this->facilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_2'))
        ]);

        // Bond vs Loan Summary
        $rows->push([]);
        $rows->push(['Bond vs Loan Summary']);
        $rows->push(['Type', 'Nominal Value (RM)', 'Outstanding Size (RM)', 'Trustee Fee (RM)']);

        $bondFacilities = $this->facilities->filter(fn($f) => $f->issuer?->debenture === 'Corporate Bond');
        $loanFacilities = $this->facilities->filter(fn($f) => $f->issuer?->debenture === 'Loan');

        $rows->push([
            'Bond',
            $bondFacilities->sum(fn($f) => (float) $f->facility_amount),
            $bondFacilities->sum(fn($f) => (float) $f->outstanding_amount),
            $bondFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1')),
        ]);

        $rows->push([
            'Loan',
            $loanFacilities->sum(fn($f) => (float) $f->facility_amount),
            $loanFacilities->sum(fn($f) => (float) $f->outstanding_amount),
            $loanFacilities->sum(fn($f) => $f->trusteeFees->sum('trustee_fee_amount_1')),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Issuer Short Name',
            'Facility Code',
            'Issuer Name',
            'Facility Name',
            'Debenture Type',
            'Trustee Role 1',
            'Trustee Role 2',
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
