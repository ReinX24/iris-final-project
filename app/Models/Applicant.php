<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    /** @use HasFactory<\Database\Factories\ApplicantFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'age',
        'profile_photo',
        'curriculum_vitae',
        'working_experience',
        'educational_attainment',
        'medical',
        'status',
    ];

    public function jobOpenings()
    {
        return $this->belongsToMany(JobOpening::class, 'job_opening_applicants', 'applicant_id', 'job_opening_id')
            ->withTimestamps();
    }

    public function educationalAttainments()
    {
        return $this->hasMany(EducationalAttainment::class);
    }

    public function workExperiences()
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function references()
    {
        return $this->hasMany(Reference::class);
    }
}
