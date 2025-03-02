<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PortfolioType extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'portfolio_id',
        'name',
        'description',
        'status',
    ];

    /**
     * Get the portfolio that owns the portfolio type.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }
}