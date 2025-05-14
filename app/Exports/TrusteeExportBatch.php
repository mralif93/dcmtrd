<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TrusteeExportBatch implements FromCollection, WithHeadings, WithMapping
{
    protected $batch;
    protected $items;
    protected $rowNumber = 0;
    protected $isTotalRow = false;

    public function __construct($batch)
    {
        $this->batch = $batch;

        // Clone and calculate totals
        $this->items = collect($batch->items);
        $this->appendTotals();
    }

    public function collection()
    {
        return $this->items;
    }

    public function headings(): array
    {
        return [
            'Sl No.',
            'Trust',
            'Name',
            'Trust Type',
            'Trust Amount / Escrow Sum (RM)',
            'No. Of Shares (unit)',
            'Outstanding Size',
            'Trustee Fee Amount',
        ];
    }

    public function map($item): array
    {
        // Check if this is the final total row
        if (isset($item->is_total) && $item->is_total) {
            return [
                '',
                '',
                '',
                'TOTAL',
                $this->formatCurrency($item->trust_amount_escrow_sum),
                $this->formatNumber($item->no_of_share),
                $this->formatCurrency($item->outstanding_size),
                $this->formatCurrency($item->total_trustee_fee),
            ];
        }

        $this->rowNumber++;

        return [
            $this->rowNumber,
            $item->issuer_short_name,
            $item->issuer_name,
            $item->debenture,
            $this->formatCurrency($item->trust_amount_escrow_sum),
            $this->formatNumber($item->no_of_share),
            $this->formatCurrency($item->outstanding_size),
            $this->formatCurrency($item->total_trustee_fee),
        ];
    }

    private function appendTotals()
    {
        $totals = $this->items->reduce(function ($carry, $item) {
            $carry['trust_amount_escrow_sum'] += $item->trust_amount_escrow_sum ?? 0;
            $carry['no_of_share'] += $item->no_of_share ?? 0;
            $carry['outstanding_size'] += $item->outstanding_size ?? 0;
            $carry['total_trustee_fee'] += $item->total_trustee_fee ?? 0;
            return $carry;
        }, [
            'trust_amount_escrow_sum' => 0,
            'no_of_share' => 0,
            'outstanding_size' => 0,
            'total_trustee_fee' => 0,
        ]);

        // Append as a new row
        $this->items->push((object)[
            'is_total' => true,
            'trust_amount_escrow_sum' => $totals['trust_amount_escrow_sum'],
            'no_of_share' => $totals['no_of_share'],
            'outstanding_size' => $totals['outstanding_size'],
            'total_trustee_fee' => $totals['total_trustee_fee'],
        ]);
    }

    private function formatNumber($value)
    {
        return ($value && $value != 0) ? number_format($value, 0) : '-';
    }

    private function formatCurrency($value)
    {
        return ($value && $value != 0) ? number_format($value, 2, '.', ',') : '-';
    }
}
