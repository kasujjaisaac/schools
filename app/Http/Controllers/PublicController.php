<?php

namespace App\Http\Controllers;

use App\Models\AdmissionIntake;
use App\Models\Article;
use App\Models\Career;
use App\Models\EducationJob;
use App\Models\EducationLevel;
use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\Location;
use App\Models\Programme;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    public function home(): View
    {
        return view('home', [
            'featuredInstitutions' => Institution::with(['category', 'location', 'educationLevels'])->where('status', 'published')->where('is_featured', true)->latest()->take(3)->get(),
            'openAdmissions' => AdmissionIntake::with('institution')->whereHas('institution', fn ($query) => $query->where('status', 'published'))->where('status', 'open')->orderBy('closing_date')->take(4)->get(),
            'programmes' => Programme::withCount(['institutions' => fn ($query) => $query->where('status', 'published')])->orderByDesc('institutions_count')->take(6)->get(),
            'careers' => Career::where('status', 'published')->latest()->take(3)->get(),
            'levels' => EducationLevel::orderBy('id')->get(),
            'categories' => InstitutionCategory::orderBy('name')->get(),
            'locations' => Location::whereIn('type', ['city', 'district'])->orderBy('name')->take(8)->get(),
            'institutionCount' => Institution::where('status', 'published')->count(),
        ]);
    }

    public function institutions(Request $request): View
    {
        $institutions = Institution::with(['category', 'location', 'educationLevels'])
            ->where('status', 'published')
            ->when($request->string('q')->trim()->value(), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('short_name', 'like', "%{$search}%")
                        ->orWhereHas('programmes', fn ($query) => $query->where('name', 'like', "%{$search}%"));
                });
            })
            ->when($request->integer('category'), fn ($query, $category) => $query->where('institution_category_id', $category))
            ->when($request->integer('location'), fn ($query, $location) => $query->where('location_id', $location))
            ->when($request->integer('level'), fn ($query, $level) => $query->whereHas('educationLevels', fn ($query) => $query->whereKey($level)))
            ->when($request->filled('ownership'), fn ($query) => $query->where('ownership', $request->string('ownership')))
            ->when($request->filled('boarding_type'), fn ($query) => $query->where('boarding_type', $request->string('boarding_type')))
            ->when($request->boolean('verified'), fn ($query) => $query->where('is_verified', true))
            ->orderByDesc('is_featured')->orderBy('name')
            ->paginate(9)->withQueryString();

        return view('institutions.index', [
            'institutions' => $institutions,
            'categories' => InstitutionCategory::orderBy('name')->get(),
            'locations' => Location::whereIn('type', ['city', 'district'])->orderBy('name')->get(),
            'levels' => EducationLevel::orderBy('id')->get(),
        ]);
    }

    public function institution(Institution $institution): View
    {
        abort_unless($institution->status === 'published', 404);
        $institution->load([
            'category',
            'location.parent',
            'educationLevels',
            'programmes',
            'facilities',
            'admissions' => fn ($query) => $query->orderBy('closing_date'),
        ]);

        return view('institutions.show', compact('institution'));
    }

    public function programmes(Request $request): View
    {
        $programmes = Programme::withCount(['institutions' => fn ($query) => $query->where('status', 'published')])
            ->when($request->string('q')->trim()->value(), function ($query, string $search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('field', 'like', "%{$search}%");
                });
            })
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        return view('programmes.index', compact('programmes'));
    }

    public function programme(Programme $programme): View
    {
        $programme->load(['institutions' => fn ($query) => $query->where('status', 'published')->with(['category', 'location'])]);

        return view('programmes.show', compact('programme'));
    }

    public function admissions(Request $request): View
    {
        $admissions = AdmissionIntake::with(['institution.category', 'institution.location'])
            ->whereHas('institution', fn ($query) => $query->where('status', 'published'))
            ->when($request->integer('institution'), fn ($query, $institution) => $query->where('institution_id', $institution))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->string('status')))
            ->orderByRaw('closing_date is null')
            ->orderBy('closing_date')
            ->paginate(12)
            ->withQueryString();

        return view('admissions.index', [
            'admissions' => $admissions,
            'institutions' => Institution::where('status', 'published')->orderBy('name')->get(['id', 'name']),
        ]);
    }

    public function locations(): View
    {
        return view('locations.index', [
            'locations' => Location::withCount(['institutions' => fn ($query) => $query->where('status', 'published')])
                ->whereIn('type', ['city', 'district'])
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function location(Location $location): View
    {
        $institutions = Institution::with(['category', 'educationLevels'])
            ->where('status', 'published')
            ->whereBelongsTo($location)
            ->orderBy('name')
            ->paginate(12);

        return view('locations.show', compact('location', 'institutions'));
    }

    public function careers(): View
    {
        return view('careers.index', [
            'careers' => Career::with('programmes')->where('status', 'published')->orderBy('title')->paginate(12),
        ]);
    }

    public function scholarships(): View
    {
        return view('scholarships.index', [
            'scholarships' => Scholarship::where('status', 'published')->orderByRaw('deadline is null')->orderBy('deadline')->paginate(12),
        ]);
    }

    public function jobs(): View
    {
        return view('jobs.index', [
            'jobs' => EducationJob::with('institution')->where('status', 'published')->orderByRaw('deadline is null')->orderBy('deadline')->paginate(12),
        ]);
    }

    public function guides(): View
    {
        return view('guides.index', [
            'articles' => Article::where('status', 'published')->latest('published_at')->paginate(12),
        ]);
    }

    public function contact(): View
    {
        return view('contact');
    }
}
