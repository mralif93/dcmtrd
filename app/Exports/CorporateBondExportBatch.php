<?php

namespace App\Exports;

use App\Models\ReportBatchItems;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Illuminate\Support\Collection;

class CorporateBondExportBatch implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $batch;

    public function __construct($batch)
    {
        $this->batch = $batch;
    }

    public function collection()
    {
        $items = ReportBatchItems::where('report_batch_id', $this->batch->id)->get();

        $rows = collect();

        // Detail Rows
        foreach ($items as $item) {
            $rows->push([
                $item->bond_name,
                $item->facility_code,
                $item->issuer_short_name,
                $item->issuer_name,
                $item->facility_name,
                $item->debenture_or_loan,
                $item->trustee_role_1,
                $item->trustee_role_2,
                (float) $item->nominal_value,
                (float) $item->outstanding_size,
                (float) $item->trustee_fee_1,
                (float) $item->trustee_fee_2,
                optional($item->trust_deed_date)?->format('d/m/Y'),
                optional($item->issue_date)?->format('d/m/Y'),
                optional($item->maturity_date)?->format('d/m/Y'),
            ]);
        }

        // Summary Section
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
            '',
            $items->sum('nominal_value'),
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
            $items->sum('outstanding_size'),
        ]);

        $rows->push([
            'Total Trustee Fee 1',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            '',
            $items->sum('trustee_fee_1'),
        ]);

        $rows->push([
            'Total Trustee Fee 2',
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
            $items->sum('trustee_fee_2'),
        ]);

        // Bond vs Loan
        $rows->push([]);
        $rows->push(['Bond vs Loan Summary']);
        $rows->push(['Type', 'Nominal Value (RM)', 'Outstanding Size (RM)', 'Trustee Fee 1 (RM)']);

        $bondItems = $items->filter(fn($i) => $i->debenture_or_loan === 'Debenture');
        $loanItems = $items->filter(fn($i) => $i->debenture_or_loan === 'Loan');

        $rows->push([
            'Bond',
            $bondItems->sum('nominal_value'),
            $bondItems->sum('outstanding_size'),
            $bondItems->sum('trustee_fee_1'),
        ]);

        $rows->push([
            'Loan',
            $loanItems->sum('nominal_value'),
            $loanItems->sum('outstanding_size'),
            $loanItems->sum('trustee_fee_1'),
        ]);

        return $rows;
    }

    public function headings(): array
    {
        return [
            'Bond Name',
            'Facility Code',
            'Issuer Short Name',
            'Issuer Name',
            'Facility Name',
            'Debenture or Loan',
            'Trustee Role 1',
            'Trustee Role 2',
            'Nominal Value',
            'Outstanding Size',
            'Trustee Fee 1',
            'Trustee Fee 2',
            'Trust Deed Date',
            'Issue Date',
            'Maturity Date'
        ];
    }
}
