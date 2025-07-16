<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobOpening extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date_needed',
        'date_expiry',
        'status',
        'location',
    ];

    protected function casts(): array
    {
        return [
            'date_needed' => 'date',
            'date_expiry' => 'date',
        ];
    }

    public function applicants()
    {
        return $this->belongsToMany(Applicant::class, 'job_opening_applicants', 'job_opening_id', 'applicant_id')
            ->withTimestamps();
    }
}
