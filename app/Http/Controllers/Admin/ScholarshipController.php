<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholarship;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ScholarshipController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:draft,published,archived'],
        ]);

        return view('admin.scholarships.index', [
            'scholarships' => Scholarship::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('title', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->orderByRaw('deadline is null')->orderBy('deadline')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.scholarships.form', [
            'scholarship' => new Scholarship(['status' => 'published']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title']);
        $data['is_featured'] = $request->boolean('is_featured');

        $scholarship = Scholarship::create($data);

        return redirect()->route('admin.scholarships.show', $scholarship)->with('status', 'Scholarship created.');
    }

    public function show(Scholarship $scholarship): View
    {
        return view('admin.scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship): View
    {
        return view('admin.scholarships.form', compact('scholarship'));
    }

    public function update(Request $request, Scholarship $scholarship): RedirectResponse
    {
        $data = $this->validatedData($request, $scholarship);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title'], $scholarship);
        $data['is_featured'] = $request->boolean('is_featured');

        $scholarship->update($data);

        return redirect()->route('admin.scholarships.show', $scholarship)->with('status', 'Scholarship updated.');
    }

    public function destroy(Scholarship $scholarship): RedirectResponse
    {
        $scholarship->delete();

        return redirect()->route('admin.scholarships.index')->with('status', 'Scholarship deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Scholarship $scholarship = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('scholarships', 'slug')->ignore($scholarship)],
            'provider' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'eligible_level' => ['nullable', 'string', 'max:255'],
            'eligibility' => ['nullable', 'string', 'max:5000'],
            'funding_type' => ['nullable', 'string', 'max:255'],
            'opening_date' => ['nullable', 'date'],
            'deadline' => ['nullable', 'date', 'after_or_equal:opening_date'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:draft,published,archived'],
            'is_featured' => ['boolean'],
        ]);
    }

    private function uniqueSlug(string $value, ?Scholarship $scholarship = null): string
    {
        $slug = Str::slug($value);
        $candidate = $slug;
        $counter = 2;

        while (Scholarship::where('slug', $candidate)->when($scholarship, fn ($query) => $query->whereKeyNot($scholarship->getKey()))->exists()) {
            $candidate = "{$slug}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
