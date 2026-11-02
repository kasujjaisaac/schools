<?php

namespace Tests\Feature;

use App\Models\AdmissionIntake;
use App\Models\Article;
use App\Models\Career;
use App\Models\EducationJob;
use App\Models\Enquiry;
use App\Models\Institution;
use App\Models\InstitutionClaim;
use App\Models\Programme;
use App\Models\Scholarship;
use App\Models\User;
use Database\Seeders\EducationSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminWorkspaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_every_create_edit_and_detail_page(): void
    {
        $this->seed(EducationSeeder::class);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        foreach ([
            ['institutions', Institution::firstOrFail()],
            ['programmes', Programme::firstOrFail()],
            ['admissions', AdmissionIntake::firstOrFail()],
            ['scholarships', Scholarship::firstOrFail()],
            ['education-jobs', EducationJob::firstOrFail()],
            ['articles', Article::firstOrFail()],
            ['careers', Career::firstOrFail()],
        ] as [$module, $record]) {
            $this->get(route('admin.'.$module.'.create'))->assertOk()->assertSee('Admin workspace');
            $this->get(route('admin.'.$module.'.edit', $record))->assertOk();
            $this->get(route('admin.'.$module.'.show', $record))->assertOk();
        }
    }

    public function test_all_module_searches_return_empty_results_for_unmatched_text(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::firstOrFail();
        Enquiry::factory()->create(['institution_id' => $institution->id]);
        InstitutionClaim::factory()->create(['institution_id' => $institution->id]);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        foreach (['institutions', 'programmes', 'admissions', 'scholarships', 'education-jobs', 'articles', 'careers', 'enquiries', 'claims'] as $module) {
            $key = $module === 'education-jobs' ? 'jobs' : $module;
            $this->get(route('admin.'.$module.'.index', ['q' => 'no-matching-record-987']))
                ->assertOk()->assertSee('No records found.')
                ->assertViewHas($key, fn ($records): bool => $records->total() === 0);
        }
    }

    public function test_search_and_status_filters_are_applied_together(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $institution->update(['status' => 'pending']);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        $this->get(route('admin.institutions.index', ['q' => 'Lakeview', 'status' => 'pending']))
            ->assertOk()->assertViewHas('institutions', fn ($records): bool => $records->total() === 1 && $records->first()->id === $institution->id);
        $this->get(route('admin.institutions.index', ['q' => 'Lakeview', 'status' => 'published']))
            ->assertOk()->assertViewHas('institutions', fn ($records): bool => $records->total() === 0);
    }

    public function test_each_status_filter_excludes_records_with_another_status(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::firstOrFail();
        Enquiry::factory()->create(['institution_id' => $institution->id, 'status' => 'new']);
        InstitutionClaim::factory()->create(['institution_id' => $institution->id, 'status' => 'submitted']);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        foreach (['institutions' => 'draft', 'admissions' => 'draft', 'scholarships' => 'draft', 'education-jobs' => 'draft', 'articles' => 'draft', 'careers' => 'draft', 'enquiries' => 'closed', 'claims' => 'rejected'] as $module => $status) {
            $key = $module === 'education-jobs' ? 'jobs' : $module;
            $this->get(route('admin.'.$module.'.index', ['status' => $status]))
                ->assertOk()->assertViewHas($key, fn ($records): bool => $records->total() === 0);
            $this->get(route('admin.'.$module.'.index', ['status' => 'invalid']))
                ->assertSessionHasErrors('status');
        }
    }

    public function test_admin_can_follow_school_relationship_links(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $enquiry = Enquiry::factory()->create(['institution_id' => $institution->id]);
        $claim = InstitutionClaim::factory()->create(['institution_id' => $institution->id]);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        $this->get(route('admin.institutions.show', $institution))->assertOk()
            ->assertSee(route('admin.enquiries.show', $enquiry), false)
            ->assertSee(route('admin.claims.show', $claim), false)
            ->assertSee(route('admin.programmes.show', $institution->programmes()->firstOrFail()), false)
            ->assertSee(route('admin.admissions.show', $institution->admissions()->firstOrFail()), false);
    }

    public function test_removing_school_hides_it_from_public_directory(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        $this->delete(route('admin.institutions.destroy', $institution))->assertRedirect(route('admin.institutions.index'));

        $this->assertSoftDeleted($institution);
        $this->get(route('institutions.show', $institution->slug))->assertNotFound();
    }

    public function test_admin_workspace_is_protected_for_guests_and_students(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
        $this->seed(EducationSeeder::class);
        $this->actingAs(User::where('email', 'student@studygreatermasaka.test')->firstOrFail());

        foreach (['dashboard', 'institutions.index', 'programmes.index', 'admissions.index', 'scholarships.index', 'education-jobs.index', 'articles.index', 'careers.index', 'enquiries.index', 'claims.index'] as $route) {
            $this->get(route('admin.'.$route))->assertForbidden();
        }
    }

    public function test_dashboard_counts_and_review_queue_use_current_data(): void
    {
        $this->seed(EducationSeeder::class);
        Institution::where('slug', 'lakeview-academy-demo')->update(['status' => 'pending']);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        $this->get(route('admin.dashboard'))->assertOk()
            ->assertViewHas('institutionCount', 4)
            ->assertViewHas('publishedInstitutionCount', 3)
            ->assertViewHas('pendingInstitutionCount', 1)
            ->assertSee(route('admin.institutions.index', ['status' => 'pending']), false);
    }

    public function test_admin_can_prepare_connected_content_for_unpublished_institution(): void
    {
        $this->seed(EducationSeeder::class);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $institution->update(['status' => 'draft']);
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        foreach (['programmes', 'admissions', 'education-jobs'] as $module) {
            $this->get(route('admin.'.$module.'.create'))->assertOk()
                ->assertViewHas('institutions', fn ($records): bool => $records->contains('id', $institution->id));
        }

        $this->post(route('admin.admissions.store'), [
            'institution_id' => $institution->id,
            'name' => 'Prepared intake',
            'status' => 'draft',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $this->assertDatabaseHas(AdmissionIntake::class, [
            'institution_id' => $institution->id,
            'name' => 'Prepared intake',
            'status' => 'draft',
        ]);
        $this->get(route('admissions.index'))->assertDontSee('Prepared intake');
    }

    public function test_programme_updates_are_persisted_and_visible_on_public_page(): void
    {
        $this->seed(EducationSeeder::class);
        $programme = Programme::where('name', 'Information Technology')->firstOrFail();
        $institution = Institution::where('slug', 'lakeview-academy-demo')->firstOrFail();
        $this->actingAs(User::where('email', 'admin@studygreatermasaka.test')->firstOrFail());

        $this->put(route('admin.programmes.update', $programme), [
            'name' => 'Applied Information Technology',
            'description' => 'Practical computing for local learners.',
            'institution_ids' => [$institution->id],
        ])->assertSessionHasNoErrors()->assertRedirect(route('admin.programmes.show', $programme));

        $this->assertDatabaseHas(Programme::class, [
            'id' => $programme->id,
            'name' => 'Applied Information Technology',
        ]);
        $this->get(route('programmes.show', $programme->fresh()->slug))
            ->assertOk()->assertSee('Applied Information Technology')->assertSee('Lakeview Academy Demo');
    }
}
