<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'work_experiences';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'applicant_id',
        'company_name',
        'role',
        'start_year',
        'end_year',
    ];

    /**
     * Get the applicant that owns the work experience record.
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
