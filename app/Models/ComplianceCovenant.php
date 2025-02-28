<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplianceCovenant extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issuer_short_name',
        'financial_year_end',
        'audited_financial_statements',
        'unaudited_financial_statements',
        'compliance_certificate',
        'finance_service_cover_ratio',
        'annual_budget',
        'computation_of_finance_to_ebitda',
        'ratio_information_on_use_of_proceeds',
    ];

    /**
     * Check if an issuer has completed all required documents
     *
     * @return bool
     */
    public function isCompliant()
    {
        // Check if all document fields have values
        return !empty($this->audited_financial_statements) &&
               !empty($this->unaudited_financial_statements) &&
               !empty($this->compliance_certificate) &&
               !empty($this->finance_service_cover_ratio) &&
               !empty($this->annual_budget) &&
               !empty($this->computation_of_finance_to_ebitda) &&
               !empty($this->ratio_information_on_use_of_proceeds);
    }

    /**
     * Get all missing documents
     *
     * @return array
     */
    public function getMissingDocuments()
    {
        $missingDocuments = [];
        
        if (empty($this->audited_financial_statements)) {
            $missingDocuments[] = 'Audited Financial Statements';
        }
        
        if (empty($this->unaudited_financial_statements)) {
            $missingDocuments[] = 'Unaudited Financial Statements';
        }
        
        if (empty($this->compliance_certificate)) {
            $missingDocuments[] = 'Compliance Certificate';
        }
        
        if (empty($this->finance_service_cover_ratio)) {
            $missingDocuments[] = 'Finance Service Cover Ratio';
        }
        
        if (empty($this->annual_budget)) {
            $missingDocuments[] = 'Annual Budget';
        }
        
        if (empty($this->computation_of_finance_to_ebitda)) {
            $missingDocuments[] = 'Computation of Finance to EBITDA';
        }
        
        if (empty($this->ratio_information_on_use_of_proceeds)) {
            $missingDocuments[] = 'Ratio Information on use of proceeds';
        }
        
        return $missingDocuments;
    }

    /**
     * Scope a query to find issuers by name.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $issuerName
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByIssuer($query, $issuerName)
    {
        return $query->where('issuer_short_name', $issuerName);
    }

    /**
     * Scope a query to find records by financial year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFinancialYear($query, $year)
    {
        return $query->where('financial_year_end', 'like', "%{$year}%");
    }

    /**
     * Scope a query to find fully compliant records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompliant($query)
    {
        return $query->whereNotNull('audited_financial_statements')
                    ->whereNotNull('unaudited_financial_statements')
                    ->whereNotNull('compliance_certificate')
                    ->whereNotNull('finance_service_cover_ratio')
                    ->whereNotNull('annual_budget')
                    ->whereNotNull('computation_of_finance_to_ebitda')
                    ->whereNotNull('ratio_information_on_use_of_proceeds');
    }

    /**
     * Scope a query to find non-compliant records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeNonCompliant($query)
    {
        return $query->where(function($q) {
            $q->whereNull('audited_financial_statements')
              ->orWhereNull('unaudited_financial_statements')
              ->orWhereNull('compliance_certificate')
              ->orWhereNull('finance_service_cover_ratio')
              ->orWhereNull('annual_budget')
              ->orWhereNull('computation_of_finance_to_ebitda')
              ->orWhereNull('ratio_information_on_use_of_proceeds');
        });
    }
}
