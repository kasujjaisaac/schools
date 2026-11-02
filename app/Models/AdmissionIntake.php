<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AdmissionIntake extends Model
{
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'name',
        'academic_year',
        'opening_date',
        'closing_date',
        'description',
        'requirements',
        'application_url',
        'status',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'opening_date' => 'date',
            'closing_date' => 'date',
            'is_featured' => 'boolean',
        ];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }
}
