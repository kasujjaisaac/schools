<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreInstitutionRequest;
use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\EducationLevel;
use App\Models\Institution;
use App\Models\InstitutionCategory;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\View\View;

class InstitutionController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:draft,pending,published,archived'],
        ]);

        return view('admin.institutions.index', [
            'institutions' => Institution::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('name', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->with(['category', 'location'])
                ->withCount(['enquiries', 'claims'])
                ->orderByDesc('created_at')
                ->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.institutions.form', $this->formData(new Institution([
            'primary_color' => '#176b5b',
            'secondary_color' => '#f2b84b',
            'accent_color' => '#e96d4c',
            'status' => 'published',
        ])));
    }

    public function store(StoreInstitutionRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $educationLevelIds = Arr::pull($data, 'education_level_ids', []);
        $data['slug'] = filled($data['slug'] ?? null) ? Str::slug($data['slug']) : Str::slug($data['name']);
        $data['is_verified'] = $request->boolean('is_verified');
        $data['is_featured'] = $request->boolean('is_featured');

        $institution = Institution::create($data);
        $institution->educationLevels()->sync($educationLevelIds);

        return redirect()->route('admin.institutions.index')->with('status', 'Institution created.');
    }

    public function show(Institution $institution): View
    {
        return view('admin.institutions.show', [
            'institution' => $institution->load(['category', 'location', 'educationLevels', 'programmes', 'admissions', 'enquiries', 'claims']),
        ]);
    }

    public function edit(Institution $institution): View
    {
        return view('admin.institutions.form', $this->formData($institution->load('educationLevels')));
    }

    public function update(UpdateInstitutionRequest $request, Institution $institution): RedirectResponse
    {
        $data = $request->validated();
        $educationLevelIds = Arr::pull($data, 'education_level_ids', []);

        if (array_key_exists('slug', $data) && filled($data['slug'])) {
            $data['slug'] = Str::slug($data['slug']);
        }

        $data['is_verified'] = $request->boolean('is_verified');
        $data['is_featured'] = $request->boolean('is_featured');

        $institution->update($data);
        $institution->educationLevels()->sync($educationLevelIds);

        return redirect()->route('admin.institutions.show', $institution)->with('status', 'Institution updated.');
    }

    public function destroy(Institution $institution): RedirectResponse
    {
        $institution->delete();

        return redirect()->route('admin.institutions.index')->with('status', 'Institution archived.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Institution $institution): array
    {
        return [
            'institution' => $institution,
            'categories' => InstitutionCategory::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
            'levels' => EducationLevel::orderBy('id')->get(),
        ];
    }
}
