<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;

class ActivityDiary extends Model implements Auditable
{
    use HasFactory, SoftDeletes, \OwenIt\Auditing\Auditable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'issuer_id',
        'purpose',
        'letter_date',
        'due_date',
        'extension_date_1',
        'extension_note_1',
        'extension_date_2',
        'extension_note_2',
        'status',
        'remarks',
        'prepared_by',
        'verified_by',
        'approval_datetime'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'letter_date' => 'date',
        'due_date' => 'date',
        'extension_date_1' => 'date',
        'extension_date_2' => 'date',
        'approval_datetime' => 'datetime'
    ];

    /**
     * Get the issuer that owns the activity diary entry.
     */
    public function issuer()
    {
        return $this->belongsTo(Issuer::class);
    }

    /**
     * Get all due dates for this activity diary
     * 
     * @return array
     */
    public function getAllDueDates()
    {
        $dates = [];
        
        if ($this->due_date) {
            $dates[] = [
                'date' => $this->due_date,
                'note' => null
            ];
        }
        
        if ($this->extension_date_1) {
            $dates[] = [
                'date' => $this->extension_date_1,
                'note' => $this->extension_note_1
            ];
        }
        
        if ($this->extension_date_2) {
            $dates[] = [
                'date' => $this->extension_date_2,
                'note' => $this->extension_note_2
            ];
        }
        
        return $dates;
    }

    /**
     * Get the latest due date for this activity diary
     * 
     * @return \Carbon\Carbon|null
     */
    public function getLatestDueDate()
    {
        $latestDate = $this->due_date;
        
        if ($this->extension_date_1 && (!$latestDate || $this->extension_date_1 > $latestDate)) {
            $latestDate = $this->extension_date_1;
        }
        
        if ($this->extension_date_2 && (!$latestDate || $this->extension_date_2 > $latestDate)) {
            $latestDate = $this->extension_date_2;
        }
        
        return $latestDate;
    }

    /**
     * Check if this activity diary has any extensions
     * 
     * @return bool
     */
    public function hasExtensions()
    {
        return $this->extension_date_1 !== null || $this->extension_date_2 !== null;
    }

    /**
     * Format the due dates for display
     * 
     * @return string
     */
    public function formattedDueDates()
    {
        $output = '';
        $dates = $this->getAllDueDates();
        
        foreach ($dates as $index => $dateInfo) {
            $formattedDate = date('d-M-y', strtotime($dateInfo['date']));
            
            if ($index > 0) {
                $output .= '<br>';
            }
            
            $output .= $formattedDate;
            
            if ($dateInfo['note']) {
                $output .= ' ' . $dateInfo['note'];
            }
        }
        
        return $output;
    }
}