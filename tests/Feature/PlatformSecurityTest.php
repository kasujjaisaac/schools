<?php

namespace Tests\Feature;

use App\Models\Institution;
use App\Models\Programme;
use App\Models\User;
use Database\Seeders\EducationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PlatformSecurityTest extends TestCase
{
    use RefreshDatabase;

    public function test_institution_admin_cannot_change_moderation_fields(): void
    {
        $this->seed(EducationSeeder::class);
        $user = User::where('email', 'institution@studygreatermasaka.test')->firstOrFail();
        $institution = $user->institution;
        $institution->update(['is_verified' => false, 'is_featured' => false, 'status' => 'pending']);

        $this->actingAs($user)->put(route('institution.profile.update'), [
            'is_verified' => true,
            'is_featured' => true,
            'status' => 'published',
        ])->assertSessionHasErrors(['is_verified', 'is_featured', 'status']);

        $this->assertDatabaseHas(Institution::class, ['id' => $institution->id, 'is_verified' => false, 'is_featured' => false, 'status' => 'pending']);
    }

    public function test_institution_admin_can_update_profile_details(): void
    {
        $this->seed(EducationSeeder::class);
        $user = User::where('email', 'institution@studygreatermasaka.test')->firstOrFail();

        $this->actingAs($user)->put(route('institution.profile.update'), [
            'tagline' => 'A brighter future',
        ])->assertSessionHasNoErrors()->assertRedirect(route('institution.dashboard'));

        $this->assertDatabaseHas(Institution::class, ['id' => $user->institution_id, 'tagline' => 'A brighter future']);
    }

    public function test_administrator_can_change_moderation_fields(): void
    {
        $this->seed(EducationSeeder::class);
        $user = User::where('email', 'admin@studygreatermasaka.test')->firstOrFail();
        $institution = Institution::firstOrFail();

        $this->actingAs($user)->put(route('admin.institutions.update', $institution), [
            'is_verified' => false,
            'is_featured' => false,
            'status' => 'pending',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $this->assertDatabaseHas(Institution::class, ['id' => $institution->id, 'is_verified' => false, 'is_featured' => false, 'status' => 'pending']);
    }

    public function test_public_admissions_and_programme_counts_exclude_unpublished_institutions(): void
    {
        $this->seed(EducationSeeder::class);
        Institution::where('slug', 'masaka-technical-college-demo')->update(['status' => 'draft']);
        $programme = Programme::where('name', 'Information Technology')->firstOrFail();

        $this->get(route('home'))->assertOk()
            ->assertDontSee('Masaka Technical College Demo')
            ->assertViewHas('programmes', fn ($programmes): bool => $programmes->firstWhere('id', $programme->id)->institutions_count === 2);
        $this->get(route('programmes.index'))->assertOk()
            ->assertViewHas('programmes', fn ($programmes): bool => $programmes->firstWhere('id', $programme->id)->institutions_count === 2);
        $this->get(route('institutions.show', 'masaka-technical-college-demo'))->assertNotFound();
    }

    public function test_demo_seeder_does_not_create_or_reset_accounts_in_production(): void
    {
        $user = User::factory()->create(['email' => 'admin@studygreatermasaka.test']);
        $password = $user->password;
        $this->app->instance('env', 'production');

        $this->app->make(EducationSeeder::class)->run();

        $this->assertDatabaseCount(User::class, 1);
        $this->assertDatabaseCount(Institution::class, 0);
        $this->assertSame($password, $user->fresh()->password);
    }

    public function test_registration_ignores_privileged_attributes(): void
    {
        $this->post(route('register.store'), [
            'name' => 'New Learner',
            'email' => 'learner@example.test',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'SecurePassword123!',
            'role_id' => 999,
            'institution_id' => 999,
        ])->assertSessionHasNoErrors()->assertRedirect(route('dashboard'));

        $user = User::where('email', 'learner@example.test')->firstOrFail();
        $this->assertSame('student', $user->role->name);
        $this->assertNull($user->institution_id);
        $this->assertTrue(Hash::check('SecurePassword123!', $user->password));
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_registration_does_not_create_account(): void
    {
        $this->post(route('register.store'), [
            'name' => 'New Learner',
            'email' => 'invalid-email',
            'password' => 'SecurePassword123!',
            'password_confirmation' => 'different',
        ])->assertSessionHasErrors(['email', 'password']);

        $this->assertDatabaseCount(User::class, 0);
        $this->assertGuest();
    }

    public function test_guest_cannot_update_institution_profile(): void
    {
        $this->put(route('institution.profile.update'), ['name' => 'Changed'])
            ->assertRedirect(route('login'));
    }

    public function test_registration_rejects_excessive_attempts(): void
    {
        for ($attempt = 0; $attempt < 6; $attempt++) {
            $this->post(route('register.store'))->assertSessionHasErrors(['name', 'email', 'password']);
        }

        $this->post(route('register.store'))->assertTooManyRequests();

        $this->assertDatabaseCount(User::class, 0);
    }
}
