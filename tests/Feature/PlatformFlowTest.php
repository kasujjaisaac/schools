<?php

namespace Tests\Feature;

use App\Models\AdmissionIntake;
use App\Models\Article;
use App\Models\Career;
use App\Models\EducationJob;
use App\Models\EducationLevel;
use App\Models\Enquiry;
use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\InstitutionClaim;
use App\Models\Location;
use App\Models\Programme;
use App\Models\Role;
use App\Models\Scholarship;
use App\Models\User;
use Database\Seeders\EducationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PlatformFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_public_discovery_pages_load(): void
    {
        $this->seed(EducationSeeder::class);

        $this->get('/')->assertOk()->assertSee('Study Greater Masaka');
        $this->get('/institutions')->assertOk()->assertSee('Find Institutions');
        $this->get('/programmes')->assertOk()->assertSee('Programme Finder');
        $this->get('/admissions')->assertOk()->assertSee('Admissions');
        $this->get('/careers')->assertOk()->assertSee('Career Explorer');
        $this->get('/scholarships')->assertOk()->assertSee('Scholarships');
        $this->get('/jobs')->assertOk()->assertSee('Education Jobs');
        $this->get('/contact')->assertOk()->assertSee('Contact Study Greater Masaka');
    }

    public function test_institution_profile_accepts_enquiry_and_claim(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();

        $this->post(route('institutions.enquiries.store', $institution), [
            'name' => 'Parent Tester',
            'telephone' => '+256700111222',
            'email' => 'parent@example.test',
            'preferred_contact_method' => 'phone',
            'message' => 'Please share admission details.',
        ])->assertRedirect();

        $this->post(route('institutions.claims.store', $institution), [
            'claimant_name' => 'Head Teacher',
            'role_title' => 'Head teacher',
            'phone' => '+256700333444',
            'email' => 'head@example.test',
            'proof' => 'I can provide official documents.',
        ])->assertRedirect();

        $this->assertDatabaseHas(Enquiry::class, ['institution_id' => $institution->id, 'status' => 'new']);
        $this->assertDatabaseHas(InstitutionClaim::class, ['institution_id' => $institution->id, 'status' => 'submitted']);
    }

    public function test_authentication_and_role_redirects_work(): void
    {
        $this->seed(EducationSeeder::class);

        $this->post('/login', [
            'email' => 'student@studygreatermasaka.test',
            'password' => 'password',
        ])->assertRedirect(route('dashboard'));

        $this->get('/dashboard')->assertOk()->assertSee('My Education Dashboard');
    }

    public function test_admin_can_create_institution(): void
    {
        $this->seed(EducationSeeder::class);
        $admin = User::where('email', 'admin@studygreatermasaka.test')->firstOrFail();
        $category = InstitutionCategory::firstOrFail();
        $location = Location::firstOrFail();
        $level = EducationLevel::firstOrFail();

        $this->actingAs($admin)->post(route('admin.institutions.store'), [
            'name' => 'New Demo School',
            'slug' => 'new-demo-school',
            'institution_category_id' => $category->id,
            'location_id' => $location->id,
            'education_level_ids' => [$level->id],
            'primary_color' => '#176b5b',
            'secondary_color' => '#f2b84b',
            'accent_color' => '#e96d4c',
            'status' => 'published',
        ])->assertRedirect(route('admin.institutions.index'));

        $this->assertDatabaseHas(Institution::class, ['slug' => 'new-demo-school']);
    }

    public function test_admin_management_pages_and_content_creation_work(): void
    {
        $this->seed(EducationSeeder::class);
        $admin = User::where('email', 'admin@studygreatermasaka.test')->firstOrFail();
        $institution = Institution::firstOrFail();

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk()->assertSee('Management Dashboard');
        $this->actingAs($admin)->get(route('admin.programmes.index'))->assertOk()->assertSee('Programmes');
        $this->actingAs($admin)->get(route('admin.admissions.index'))->assertOk()->assertSee('Admissions');
        $this->actingAs($admin)->get(route('admin.scholarships.index'))->assertOk()->assertSee('Scholarships');
        $this->actingAs($admin)->get(route('admin.education-jobs.index'))->assertOk()->assertSee('Education Jobs');
        $this->actingAs($admin)->get(route('admin.articles.index'))->assertOk()->assertSee('Guides');
        $this->actingAs($admin)->get(route('admin.careers.index'))->assertOk()->assertSee('Careers');
        $this->actingAs($admin)->get(route('admin.enquiries.index'))->assertOk()->assertSee('Enquiries');
        $this->actingAs($admin)->get(route('admin.claims.index'))->assertOk()->assertSee('Profile Claims');

        $this->actingAs($admin)->post(route('admin.programmes.store'), [
            'name' => 'Agribusiness Management',
            'field' => 'Business',
            'qualification' => 'Certificate',
            'duration' => '1 year',
            'institution_ids' => [$institution->id],
        ])->assertRedirect(route('admin.programmes.index'));

        $this->actingAs($admin)->post(route('admin.scholarships.store'), [
            'title' => 'Local Learner Support',
            'provider' => 'Study Greater Masaka',
            'description' => 'Support for local learners.',
            'status' => 'published',
        ])->assertRedirect();

        $this->actingAs($admin)->post(route('admin.education-jobs.store'), [
            'institution_id' => $institution->id,
            'title' => 'Admissions Officer',
            'description' => 'Manage learner admissions.',
            'status' => 'published',
        ])->assertRedirect();

        $this->actingAs($admin)->post(route('admin.admissions.store'), [
            'institution_id' => $institution->id,
            'name' => 'May intake',
            'status' => 'open',
        ])->assertRedirect();

        $this->actingAs($admin)->post(route('admin.articles.store'), [
            'title' => 'How to Prepare for Admissions',
            'category' => 'Admissions',
            'excerpt' => 'A short admissions guide.',
            'status' => 'published',
            'published_at' => '2026-09-03 10:00:00',
        ])->assertRedirect();

        $programme = Programme::where('name', 'Agribusiness Management')->where('field', 'Business')->firstOrFail();

        $this->actingAs($admin)->post(route('admin.careers.store'), [
            'title' => 'Agribusiness Officer',
            'summary' => 'Supports agricultural enterprise growth.',
            'status' => 'published',
            'programme_ids' => [$programme->id],
        ])->assertRedirect();

        $enquiry = Enquiry::factory()->create(['institution_id' => $institution->id, 'status' => 'new']);
        $claim = InstitutionClaim::factory()->create(['institution_id' => $institution->id, 'status' => 'submitted']);

        $this->actingAs($admin)->put(route('admin.enquiries.update', $enquiry), [
            'status' => 'contacted',
        ])->assertRedirect(route('admin.enquiries.show', $enquiry));

        $this->actingAs($admin)->put(route('admin.claims.update', $claim), [
            'status' => 'approved',
        ])->assertRedirect(route('admin.claims.show', $claim));

        $this->assertDatabaseHas(Programme::class, ['name' => 'Agribusiness Management', 'field' => 'Business']);
        $this->assertDatabaseHas(Scholarship::class, ['slug' => 'local-learner-support']);
        $this->assertDatabaseHas(EducationJob::class, ['slug' => 'admissions-officer']);
        $this->assertDatabaseHas(AdmissionIntake::class, ['name' => 'May intake']);
        $this->assertDatabaseHas(Article::class, ['slug' => 'how-to-prepare-for-admissions']);
        $this->assertDatabaseHas(Career::class, ['slug' => 'agribusiness-officer']);
        $this->assertDatabaseHas(Enquiry::class, ['id' => $enquiry->id, 'status' => 'contacted']);
        $this->assertDatabaseHas(InstitutionClaim::class, ['id' => $claim->id, 'status' => 'approved']);
    }

    public function test_institution_admin_cannot_update_another_institution(): void
    {
        $this->seed(EducationSeeder::class);
        $owned = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $other = Institution::where('slug', 'masaka-technical-college-demo')->firstOrFail();
        $role = Role::where('name', 'institution-admin')->firstOrFail();
        $user = User::factory()->create(['role_id' => $role->id, 'institution_id' => $owned->id]);

        $this->actingAs($user)->put(route('admin.institutions.update', $other), [
            'name' => 'Changed name',
            'institution_category_id' => $other->institution_category_id,
            'primary_color' => '#176b5b',
            'secondary_color' => '#f2b84b',
            'accent_color' => '#e96d4c',
            'status' => 'published',
        ])->assertForbidden();
    }
}
