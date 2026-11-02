<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Institution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'tagline',
        'institution_category_id',
        'location_id',
        'ownership',
        'gender_type',
        'boarding_type',
        'established_year',
        'description',
        'mission',
        'vision',
        'logo_url',
        'cover_image_url',
        'primary_color',
        'secondary_color',
        'accent_color',
        'telephone',
        'email',
        'website',
        'whatsapp',
        'address',
        'latitude',
        'longitude',
        'is_verified',
        'is_featured',
        'status',
        'seo_title',
        'seo_description',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
            'latitude' => 'float',
            'longitude' => 'float',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(InstitutionCategory::class, 'institution_category_id');
    }

    public function location(): BelongsTo
    {
        return $this->belongsTo(Location::class);
    }

    public function educationLevels(): BelongsToMany
    {
        return $this->belongsToMany(EducationLevel::class, 'institution_education_level');
    }

    public function programmes(): BelongsToMany
    {
        return $this->belongsToMany(Programme::class)->withPivot(['requirements', 'study_mode', 'is_active']);
    }

    public function admissions(): HasMany
    {
        return $this->hasMany(AdmissionIntake::class);
    }

    public function facilities(): BelongsToMany
    {
        return $this->belongsToMany(Facility::class)->withPivot('note');
    }

    public function enquiries(): HasMany
    {
        return $this->hasMany(Enquiry::class);
    }

    public function claims(): HasMany
    {
        return $this->hasMany(InstitutionClaim::class);
    }

    public function staff(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getProfileCompletenessAttribute(): int
    {
        $fields = ['logo_url', 'cover_image_url', 'description', 'telephone', 'email', 'location_id'];
        $complete = collect($fields)->filter(fn (string $field) => filled($this->{$field}))->count();
        $complete += $this->programmes()->exists() ? 1 : 0;
        $complete += $this->admissions()->exists() ? 1 : 0;

        return (int) round(($complete / 8) * 100);
    }
}
