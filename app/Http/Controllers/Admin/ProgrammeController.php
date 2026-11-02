<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProgrammeController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
        ]);

        return view('admin.programmes.index', [
            'programmes' => Programme::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('name', 'like', '%'.$filters['q'].'%'))
                ->withCount('institutions')->orderBy('name')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.programmes.form', $this->formData(new Programme));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $institutionIds = Arr::pull($data, 'institution_ids', []);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['name']);

        $programme = Programme::create($data);
        $programme->institutions()->sync($institutionIds);

        return redirect()->route('admin.programmes.index')->with('status', 'Programme created.');
    }

    public function show(Programme $programme): View
    {
        return view('admin.programmes.show', [
            'programme' => $programme->load('institutions'),
        ]);
    }

    public function edit(Programme $programme): View
    {
        return view('admin.programmes.form', $this->formData($programme->load('institutions')));
    }

    public function update(Request $request, Programme $programme): RedirectResponse
    {
        $data = $this->validatedData($request, $programme);
        $institutionIds = Arr::pull($data, 'institution_ids', []);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['name'], $programme);

        $programme->update($data);
        $programme->institutions()->sync($institutionIds);

        return redirect()->route('admin.programmes.show', $programme)->with('status', 'Programme updated.');
    }

    public function destroy(Programme $programme): RedirectResponse
    {
        $programme->delete();

        return redirect()->route('admin.programmes.index')->with('status', 'Programme deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Programme $programme): array
    {
        return [
            'programme' => $programme,
            'institutions' => Institution::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Programme $programme = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('programmes', 'slug')->ignore($programme)],
            'field' => ['nullable', 'string', 'max:255'],
            'qualification' => ['nullable', 'string', 'max:255'],
            'duration' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:5000'],
            'career_prospects' => ['nullable', 'string', 'max:5000'],
            'institution_ids' => ['array'],
            'institution_ids.*' => ['integer', 'exists:institutions,id'],
        ]);
    }

    private function uniqueSlug(string $value, ?Programme $programme = null): string
    {
        $slug = Str::slug($value);
        $candidate = $slug;
        $counter = 2;

        while (Programme::where('slug', $candidate)->when($programme, fn ($query) => $query->whereKeyNot($programme->getKey()))->exists()) {
            $candidate = "{$slug}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
