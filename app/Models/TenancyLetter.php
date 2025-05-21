<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TenancyLetter extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tenancy_letters';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'lease_id',

        // letter head information
        'your_reference',
        'our_reference',
        'letter_date',

        // sender information
        'recipient_company',
        'recipient_address_line_1',
        'recipient_address_line_2',
        'recipient_address_line_3',
        'recipient_address_postcode',
        'recipient_address_city',
        'recipient_address_state',
        'recipient_address_country',

        // recipient information
        'attention_to_name',
        'attention_to_position',

        // letter content
        'description_1',
        'description_2',
        'description_3',
        'letter_offer_date',

        // signature information
        'trustee_name',
        'approver_name',
        'approver_position',
        'approver_department',

        // system information
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'letter_date' => 'date',
        'letter_offer_date' => 'date',
        'approval_datetime' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * Get the lease that owns the tenancy letter.
     */
    public function lease()
    {
        return $this->belongsTo(Lease::class);
    }
}