<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TrusteeFee extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'month',
        'date',
        'description',
        'trustee_fee_amount_1',
        'trustee_fee_amount_2',
        'start_anniversary_date',
        'end_anniversary_date',
        'memo_to_fad',
        'invoice_no',
        'date_letter_to_issuer',
        'first_reminder',
        'second_reminder',
        'third_reminder',
        'payment_received',
        'tt_cheque_no',
        'memo_receipt_to_fad',
        'receipt_to_issuer',
        'receipt_no',
        'status',
        'prepared_by',
        'verified_by',
        'remarks',
        'approval_datetime',
        'facility_information_id'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_anniversary_date' => 'date',
        'end_anniversary_date' => 'date',
        'memo_to_fad' => 'date',
        'date_letter_to_issuer' => 'date',
        'first_reminder' => 'date',
        'second_reminder' => 'date',
        'third_reminder' => 'date',
        'payment_received' => 'date',
        'memo_receipt_to_fad' => 'date',
        'receipt_to_issuer' => 'date',
        'trustee_fee_amount_1' => 'decimal:2',
        'trustee_fee_amount_2' => 'decimal:2',
        'approval_datetime' => 'datetime',
        'deleted_at' => 'datetime',
    ];
    
    /**
     * Get the issuer that the trustee fee belongs to.
     */
    public function facility()
    {
        return $this->belongsTo(FacilityInformation::class, 'facility_information_id');
    }
    
    /**
     * Check if the trustee fee has been paid.
     *
     * @return bool
     */
    public function isPaid()
    {
        return $this->payment_received !== null;
    }
    
    /**
     * Get the payment status.
     *
     * @return string
     */
    public function getPaymentStatus()
    {
        return $this->isPaid() ? 'Paid' : 'Pending';
    }
    
    /**
     * Get the days since invoice was created.
     *
     * @return int|null
     */
    public function getDaysSinceInvoice()
    {
        if ($this->date_letter_to_issuer) {
            return now()->diffInDays($this->date_letter_to_issuer);
        }
        
        return null;
    }
    
    /**
     * Get the days until payment was received.
     *
     * @return int|null
     */
    public function getDaysUntilPayment()
    {
        if ($this->date_letter_to_issuer && $this->payment_received) {
            return $this->date_letter_to_issuer->diffInDays($this->payment_received);
        }
        
        return null;
    }
    
    /**
     * Get the total trustee fee amount.
     *
     * @return float
     */
    public function getTotalAmount()
    {
        return (float)$this->trustee_fee_amount_1 + (float)$this->trustee_fee_amount_2;
    }
    
    /**
     * Scope a query to only include paid trustee fees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePaid($query)
    {
        return $query->whereNotNull('payment_received');
    }
    
    /**
     * Scope a query to only include unpaid trustee fees.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpaid($query)
    {
        return $query->whereNull('payment_received');
    }
    
    /**
     * Scope a query to filter by month.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $month
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByMonth($query, $month)
    {
        return $query->where('month', $month);
    }
}