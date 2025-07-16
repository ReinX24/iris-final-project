<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationFee extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicationFeeFactory> */
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'job_opening_id',
        'amount',
        'currency',
        'payment_date',
        'payment_method',
        'notes',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'payment_date' => 'datetime',
    ];

    /**
     * Get the applicant that owns the application fee.
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }

    /**
     * Get the job opening that the application fee is for.
     */
    public function jobOpening()
    {
        return $this->belongsTo(JobOpening::class);
    }
}
