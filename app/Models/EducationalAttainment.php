<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalAttainment extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'educational_attainments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'applicant_id',
        'school',
        'educational_level',
        'start_year',
        'end_year',
    ];

    /**
     * Get the applicant that owns the educational attainment record.
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
