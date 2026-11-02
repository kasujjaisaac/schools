<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Programme extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'field',
        'qualification',
        'duration',
        'description',
        'career_prospects',
    ];

    public function institutions(): BelongsToMany
    {
        return $this->belongsToMany(Institution::class)->withPivot(['requirements', 'study_mode', 'is_active']);
    }

    public function careers(): BelongsToMany
    {
        return $this->belongsToMany(Career::class);
    }
}
