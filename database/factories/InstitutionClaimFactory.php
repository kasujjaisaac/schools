<?php

namespace Database\Factories;

use App\Models\InstitutionClaim;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<InstitutionClaim>
 */
class InstitutionClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'claimant_name' => fake()->name(),
            'role_title' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'email' => fake()->safeEmail(),
            'proof' => fake()->paragraph(),
            'status' => 'submitted',
        ];
    }
}
