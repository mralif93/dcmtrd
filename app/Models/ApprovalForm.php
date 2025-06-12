<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ApprovalForm extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'approval_forms';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'portfolio_id',
        'property_id',
        'category',
        'details',
        'received_date',
        'send_date',
        'attachment',
        'remarks',
        'status',
        'prepared_by',
        'verified_by',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'received_date' => 'date',
        'send_date' => 'date',
        'approval_datetime' => 'datetime',
    ];

    /**
     * Get the portfolio associated with the approval form.
     */
    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    /**
     * Get the property associated with the approval form.
     */
    public function property()
    {
        return $this->belongsTo(Property::class);
    }


}
