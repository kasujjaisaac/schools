<?php

namespace App\Models;

use Database\Factories\ScholarshipFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    /** @use HasFactory<ScholarshipFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'provider',
        'description',
        'eligible_level',
        'eligibility',
        'funding_type',
        'opening_date',
        'deadline',
        'application_url',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'opening_date' => 'date',
            'deadline' => 'date',
            'is_featured' => 'boolean',
        ];
    }
}
