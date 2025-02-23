<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FinancialReport extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'report_date' => 'date',
        'total_revenue' => 'decimal:2',
        'rental_revenue' => 'decimal:2',
        'other_revenue' => 'decimal:2',
        'operating_expenses' => 'decimal:2',
        'maintenance_expenses' => 'decimal:2',
        'administrative_expenses' => 'decimal:2',
        'utility_expenses' => 'decimal:2',
        'insurance_expenses' => 'decimal:2',
        'property_tax' => 'decimal:2',
        'net_operating_income' => 'decimal:2',
        'net_income' => 'decimal:2',
        'cash_flow' => 'decimal:2',
        'debt_service' => 'decimal:2',
        'capex' => 'decimal:2',
        'occupancy_rate' => 'decimal:2',
        'debt_ratio' => 'decimal:2',
        'roi' => 'decimal:2',
        'cap_rate' => 'decimal:2'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}