<?php

namespace App\Models;

use App\Models\Issuer;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComplianceCovenant extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'financial_year_end',
        'audited_financial_statements',
        'unaudited_financial_statements',
        'compliance_certificate',
        'finance_service_cover_ratio',
        'annual_budget',
        'computation_of_finance_to_ebitda',
        'ratio_information_on_use_of_proceeds',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
        'issuer_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the issuer that this compliance covenant belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }

    /**
     * Check if an issuer has completed all required documents
     *
     * @return bool
     */
    public function isCompliant(): bool
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
    public function getMissingDocuments(): array
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
     * Scope a query to find compliance records by issuer ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $issuerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByIssuer(Builder $query, $issuerId): Builder
    {
        return $query->where('issuer_id', $issuerId);
    }

    /**
     * Scope a query to find records by financial year.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $year
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFinancialYear(Builder $query, $year): Builder
    {
        return $query->where('financial_year_end', 'like', "%{$year}%");
    }

    /**
     * Scope a query to find fully compliant records.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeCompliant(Builder $query): Builder
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
    public function scopeNonCompliant(Builder $query): Builder
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