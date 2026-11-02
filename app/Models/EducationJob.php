<?php

namespace App\Models;

use Database\Factories\EducationJobFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EducationJob extends Model
{
    /** @use HasFactory<EducationJobFactory> */
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'employer_name',
        'title',
        'slug',
        'category',
        'employment_type',
        'location',
        'description',
        'qualifications',
        'application_instructions',
        'deadline',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'deadline' => 'date',
        ];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
