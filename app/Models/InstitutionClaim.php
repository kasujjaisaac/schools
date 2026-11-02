<?php

namespace App\Models;

use Database\Factories\InstitutionClaimFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstitutionClaim extends Model
{
    /** @use HasFactory<InstitutionClaimFactory> */
    use HasFactory;

    protected $fillable = [
        'institution_id',
        'user_id',
        'claimant_name',
        'role_title',
        'phone',
        'email',
        'proof',
        'status',
        'reviewed_at',
    ];

    protected function casts(): array
    {
        return [
            'reviewed_at' => 'datetime',
        ];
    }

    public function institution(): BelongsTo
    {
        return $this->belongsTo(Institution::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
