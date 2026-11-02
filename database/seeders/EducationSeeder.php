<?php

namespace Database\Seeders;

use App\Models\AdmissionIntake;
use App\Models\Article;
use App\Models\Career;
use App\Models\EducationJob;
use App\Models\EducationLevel;
use App\Models\Facility;
use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\Location;
use App\Models\Programme;
use App\Models\Role;
use App\Models\Scholarship;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment(['local', 'testing'])) {
            return;
        }

        $roles = collect([
            'student' => 'Student / Parent',
            'institution-admin' => 'Institution Administrator',
            'admin' => 'Platform Administrator',
            'super-admin' => 'Super Administrator',
        ])->map(fn ($label, $name) => Role::updateOrCreate(['name' => $name], ['label' => $label]));

        $levels = collect(['Kindergarten', 'Primary', 'Secondary', 'TVET', 'College', 'University'])->mapWithKeys(fn ($name) => [$name => EducationLevel::updateOrCreate(['slug' => str($name)->slug()], ['name' => $name])]);
        $categories = collect(['Kindergarten / Nursery', 'Primary School', 'Secondary School', 'TVET Institute', 'College', 'University', 'Computer Training Centre'])->mapWithKeys(fn ($name) => [$name => InstitutionCategory::updateOrCreate(['slug' => str($name)->slug()], ['name' => $name])]);
        $masaka = Location::updateOrCreate(['slug' => 'masaka-city'], ['name' => 'Masaka City', 'type' => 'city']);
        $kalungu = Location::updateOrCreate(['slug' => 'kalungu'], ['name' => 'Kalungu', 'type' => 'district']);
        $bukomansimbi = Location::updateOrCreate(['slug' => 'bukomansimbi'], ['name' => 'Bukomansimbi', 'type' => 'district']);
        $lyantonde = Location::updateOrCreate(['slug' => 'lyantonde'], ['name' => 'Lyantonde', 'type' => 'district']);

        $facilities = collect(['Library', 'Computer Laboratory', 'Science Laboratory', 'Sports Facilities', 'Dormitories', 'Dining Hall', 'Medical Room'])->mapWithKeys(fn ($name) => [$name => Facility::updateOrCreate(['slug' => str($name)->slug()], ['name' => $name])]);

        Institution::whereIn('slug', [
            'lakeview-academy',
            'masaka-technical-college',
            'greater-masaka-institute-of-business',
        ])->update([
            'telephone' => null,
            'email' => null,
            'website' => null,
        ]);

        $programmes = collect([
            ['name' => 'Information Technology', 'field' => 'Computing', 'qualification' => 'Diploma', 'duration' => '2 years'],
            ['name' => 'Business Administration', 'field' => 'Business', 'qualification' => 'Certificate', 'duration' => '1 year'],
            ['name' => 'Agribusiness Management', 'field' => 'Agriculture', 'qualification' => 'Diploma', 'duration' => '2 years'],
            ['name' => 'Electrical Installation', 'field' => 'Engineering', 'qualification' => 'Certificate', 'duration' => '2 years'],
            ['name' => 'Early Childhood Development', 'field' => 'Education', 'qualification' => 'Certificate', 'duration' => '1 year'],
        ])->map(fn ($data) => Programme::updateOrCreate(['slug' => str($data['name'])->slug()], $data + ['description' => 'A practical, learner-centred programme designed for the next chapter of work and study.', 'career_prospects' => 'Career pathways vary by institution and qualification level.']))->keyBy('name');

        $demo = [
            ['name' => 'Lakeview Academy Demo', 'short_name' => 'LVA', 'category' => 'Secondary School', 'location' => $masaka, 'levels' => ['Primary', 'Secondary'], 'tagline' => 'Curious minds. Grounded futures.', 'primary_color' => '#176b5b', 'secondary_color' => '#f2b84b', 'accent_color' => '#e96d4c', 'cover_image_url' => 'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1600&q=80', 'description' => 'A fictional day and boarding school demo profile for evaluating the platform experience.', 'verified' => true, 'featured' => true, 'programmes' => ['Business Administration'], 'facilities' => ['Library', 'Sports Facilities', 'Dormitories']],
            ['name' => 'Masaka Technical College Demo', 'short_name' => 'MATEC', 'category' => 'TVET Institute', 'location' => $kalungu, 'levels' => ['TVET', 'College'], 'tagline' => 'Build what matters.', 'primary_color' => '#213a67', 'secondary_color' => '#e9b949', 'accent_color' => '#54b4d3', 'cover_image_url' => 'https://images.unsplash.com/photo-1564981797816-1043664bf78d?auto=format&fit=crop&w=1600&q=80', 'description' => 'A fictional technical institute demo profile focused on useful skills and local enterprise.', 'verified' => true, 'featured' => true, 'programmes' => ['Electrical Installation', 'Information Technology'], 'facilities' => ['Computer Laboratory', 'Science Laboratory', 'Dining Hall']],
            ['name' => 'Greater Masaka Institute of Business Demo', 'short_name' => 'GMIB', 'category' => 'College', 'location' => $bukomansimbi, 'levels' => ['College'], 'tagline' => 'Make your next move count.', 'primary_color' => '#7a2f3b', 'secondary_color' => '#f0d8b6', 'accent_color' => '#176b5b', 'cover_image_url' => 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80', 'description' => 'A fictional college demo profile helping test business programme discovery.', 'verified' => false, 'featured' => true, 'programmes' => ['Information Technology', 'Business Administration'], 'facilities' => ['Library', 'Computer Laboratory']],
            ['name' => 'Lyantonde Skills Centre Demo', 'short_name' => 'LSC', 'category' => 'Computer Training Centre', 'location' => $lyantonde, 'levels' => ['TVET'], 'tagline' => 'Practical digital confidence.', 'primary_color' => '#2b5f73', 'secondary_color' => '#f6c65b', 'accent_color' => '#a33f2a', 'cover_image_url' => null, 'description' => null, 'verified' => false, 'featured' => false, 'programmes' => ['Information Technology', 'Early Childhood Development'], 'facilities' => []],
        ];

        foreach ($demo as $data) {
            $institution = Institution::updateOrCreate(['slug' => str($data['name'])->slug()], [
                'name' => $data['name'], 'slug' => str($data['name'])->slug(), 'short_name' => $data['short_name'], 'tagline' => $data['tagline'],
                'institution_category_id' => $categories[$data['category']]->id, 'location_id' => $data['location']->id, 'ownership' => 'Private', 'gender_type' => 'Mixed', 'boarding_type' => 'Day and boarding',
                'description' => $data['description'], 'mission' => 'To equip learners with knowledge, character and practical confidence.', 'vision' => 'A thriving community of capable, compassionate citizens.',
                'cover_image_url' => $data['cover_image_url'], 'logo_url' => 'https://ui-avatars.com/api/?name='.urlencode($data['short_name']).'&background='.ltrim($data['primary_color'], '#').'&color=fff&bold=true',
                'primary_color' => $data['primary_color'], 'secondary_color' => $data['secondary_color'], 'accent_color' => $data['accent_color'], 'telephone' => null, 'email' => null, 'address' => $data['location']->name, 'is_verified' => $data['verified'], 'is_featured' => $data['featured'], 'established_year' => 2008, 'status' => 'published',
            ]);
            $institution->educationLevels()->sync($levels->only($data['levels'])->pluck('id'));
            $institution->programmes()->sync($programmes->only($data['programmes'])->pluck('id'));
            $institution->facilities()->sync($facilities->only($data['facilities'])->pluck('id'));
            AdmissionIntake::updateOrCreate(['institution_id' => $institution->id, 'name' => 'January intake'], ['academic_year' => '2027', 'opening_date' => now()->subDays(8), 'closing_date' => now()->addDays(42), 'description' => 'Applications are currently being received for the next learning cycle.', 'requirements' => 'Contact the institution for current entry requirements.', 'status' => 'open', 'is_featured' => true]);
        }

        $admin = User::updateOrCreate(['email' => 'admin@studygreatermasaka.test'], ['name' => 'SGM Admin', 'password' => Hash::make('password'), 'role_id' => $roles['admin']->id]);
        $institution = Institution::where('slug', 'lakeview-academy-demo')->first();
        User::updateOrCreate(['email' => 'institution@studygreatermasaka.test'], ['name' => 'Institution Admin', 'password' => Hash::make('password'), 'role_id' => $roles['institution-admin']->id, 'institution_id' => $institution?->id]);
        User::updateOrCreate(['email' => 'student@studygreatermasaka.test'], ['name' => 'Student User', 'password' => Hash::make('password'), 'role_id' => $roles['student']->id]);

        $software = Career::updateOrCreate(['slug' => 'software-developer'], ['title' => 'Software Developer', 'summary' => 'Designs and builds useful digital products.', 'duties' => 'Build, test and maintain software.', 'skills' => 'Problem solving, communication, programming.', 'recommended_subjects' => 'Mathematics, ICT, English.', 'education_pathway' => 'Secondary subjects into computing certificates, diplomas or degrees.', 'status' => 'published']);
        $software->programmes()->sync($programmes->only(['Information Technology'])->pluck('id'));
        Career::updateOrCreate(['slug' => 'business-officer'], ['title' => 'Business Officer', 'summary' => 'Supports finance, operations and enterprise growth.', 'education_pathway' => 'Business certificates, diplomas and entrepreneurship training.', 'status' => 'published']);

        Scholarship::updateOrCreate(['slug' => 'greater-masaka-demo-merit-support'], ['title' => 'Greater Masaka Demo Merit Support', 'provider' => 'Study Greater Masaka Demo Fund', 'description' => 'A fictional scholarship record for testing deadline and opportunity discovery.', 'eligible_level' => 'Secondary and TVET', 'funding_type' => 'Partial tuition support', 'deadline' => now()->addMonths(2), 'status' => 'published', 'is_featured' => true]);
        EducationJob::updateOrCreate(['slug' => 'demo-mathematics-teacher'], ['institution_id' => $institution?->id, 'title' => 'Mathematics Teacher Demo Vacancy', 'category' => 'Teaching', 'employment_type' => 'Full time', 'location' => 'Masaka City', 'description' => 'A fictional vacancy for evaluating the education jobs module.', 'qualifications' => 'Appropriate teaching qualification.', 'application_instructions' => 'Use institution contact details when published.', 'deadline' => now()->addMonth(), 'status' => 'published']);
        Article::updateOrCreate(['slug' => 'how-to-compare-schools-objectively'], ['title' => 'How to Compare Schools Objectively', 'category' => 'Parents', 'excerpt' => 'Use location, levels, facilities, admissions and verified contacts instead of rankings.', 'content' => 'A practical guide for comparing available education information without relying on fake ratings.', 'published_at' => now(), 'status' => 'published']);
    }
}
