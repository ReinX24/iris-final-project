<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'references'; // Explicitly define the table name if it's not the plural of the model name

    /**
     * The attributes that are mass assignable.
     *
     * These fields can be filled using mass assignment (e.g., Reference::create($data)).
     * Ensure all fields you intend to set via forms are listed here.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'applicant_id',     // Foreign key to the Applicant model
        'name',             // Name of the reference person
        'email',            // Email address of the reference (nullable in migration)
        'phone_number',     // Phone number of the reference (nullable in migration)
        'company',          // Company where the reference works
        'role',             // Role of the reference at the company
    ];

    /**
     * Get the applicant that owns the reference record.
     *
     * This defines the inverse of the one-to-many relationship.
     * A Reference belongs to one Applicant.
     */
    public function applicant()
    {
        return $this->belongsTo(Applicant::class);
    }
}
