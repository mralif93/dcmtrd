<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Portfolio extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];
    
    protected $casts = [
        'foundation_date' => 'date',
        'fiscal_year_end' => 'date',
        'active_status' => 'boolean',
        'total_assets' => 'decimal:2',
        'market_cap' => 'decimal:2',
        'available_funds' => 'decimal:2',
        'target_return' => 'decimal:2'
    ];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function financialReports()
    {
        return $this->hasMany(FinancialReport::class);
    }
}
