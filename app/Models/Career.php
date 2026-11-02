<?php

namespace App\Models;

use Database\Factories\CareerFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Career extends Model
{
    /** @use HasFactory<CareerFactory> */
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'summary',
        'duties',
        'skills',
        'recommended_subjects',
        'education_pathway',
        'status',
    ];

    public function programmes(): BelongsToMany
    {
        return $this->belongsToMany(Programme::class);
    }
}
