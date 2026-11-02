<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EducationJob;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EducationJobController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:draft,published,archived'],
        ]);

        return view('admin.jobs.index', [
            'jobs' => EducationJob::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('title', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->with('institution')->orderByRaw('deadline is null')->orderBy('deadline')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.jobs.form', $this->formData(new EducationJob(['status' => 'published'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title']);

        $job = EducationJob::create($data);

        return redirect()->route('admin.education-jobs.show', $job)->with('status', 'Education job created.');
    }

    public function show(EducationJob $educationJob): View
    {
        return view('admin.jobs.show', [
            'job' => $educationJob->load('institution'),
        ]);
    }

    public function edit(EducationJob $educationJob): View
    {
        return view('admin.jobs.form', $this->formData($educationJob));
    }

    public function update(Request $request, EducationJob $educationJob): RedirectResponse
    {
        $data = $this->validatedData($request, $educationJob);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title'], $educationJob);

        $educationJob->update($data);

        return redirect()->route('admin.education-jobs.show', $educationJob)->with('status', 'Education job updated.');
    }

    public function destroy(EducationJob $educationJob): RedirectResponse
    {
        $educationJob->delete();

        return redirect()->route('admin.education-jobs.index')->with('status', 'Education job deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(EducationJob $job): array
    {
        return [
            'job' => $job,
            'institutions' => Institution::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?EducationJob $job = null): array
    {
        return $request->validate([
            'institution_id' => ['nullable', 'integer', 'exists:institutions,id'],
            'employer_name' => ['nullable', 'string', 'max:255'],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('education_jobs', 'slug')->ignore($job)],
            'category' => ['nullable', 'string', 'max:255'],
            'employment_type' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'qualifications' => ['nullable', 'string', 'max:5000'],
            'application_instructions' => ['nullable', 'string', 'max:5000'],
            'deadline' => ['nullable', 'date'],
            'status' => ['required', 'in:draft,published,archived'],
        ]);
    }

    private function uniqueSlug(string $value, ?EducationJob $job = null): string
    {
        $slug = Str::slug($value);
        $candidate = $slug;
        $counter = 2;

        while (EducationJob::where('slug', $candidate)->when($job, fn ($query) => $query->whereKeyNot($job->getKey()))->exists()) {
            $candidate = "{$slug}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
