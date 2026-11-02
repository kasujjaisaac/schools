<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\Programme;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CareerController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:draft,published,archived'],
        ]);

        return view('admin.careers.index', [
            'careers' => Career::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('title', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->withCount('programmes')->orderBy('title')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.careers.form', $this->formData(new Career(['status' => 'published'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $programmeIds = Arr::pull($data, 'programme_ids', []);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title']);

        $career = Career::create($data);
        $career->programmes()->sync($programmeIds);

        return redirect()->route('admin.careers.show', $career)->with('status', 'Career created.');
    }

    public function show(Career $career): View
    {
        return view('admin.careers.show', [
            'career' => $career->load('programmes'),
        ]);
    }

    public function edit(Career $career): View
    {
        return view('admin.careers.form', $this->formData($career->load('programmes')));
    }

    public function update(Request $request, Career $career): RedirectResponse
    {
        $data = $this->validatedData($request, $career);
        $programmeIds = Arr::pull($data, 'programme_ids', []);
        $data['slug'] = $this->uniqueSlug(filled($data['slug'] ?? null) ? $data['slug'] : $data['title'], $career);

        $career->update($data);
        $career->programmes()->sync($programmeIds);

        return redirect()->route('admin.careers.show', $career)->with('status', 'Career updated.');
    }

    public function destroy(Career $career): RedirectResponse
    {
        $career->delete();

        return redirect()->route('admin.careers.index')->with('status', 'Career deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(Career $career): array
    {
        return [
            'career' => $career,
            'programmes' => Programme::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request, ?Career $career = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('careers', 'slug')->ignore($career)],
            'summary' => ['required', 'string', 'max:1000'],
            'duties' => ['nullable', 'string', 'max:5000'],
            'skills' => ['nullable', 'string', 'max:5000'],
            'recommended_subjects' => ['nullable', 'string', 'max:5000'],
            'education_pathway' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'in:draft,published,archived'],
            'programme_ids' => ['array'],
            'programme_ids.*' => ['integer', 'exists:programmes,id'],
        ]);
    }

    private function uniqueSlug(string $value, ?Career $career = null): string
    {
        $slug = Str::slug($value);
        $candidate = $slug;
        $counter = 2;

        while (Career::where('slug', $candidate)->when($career, fn ($query) => $query->whereKeyNot($career->getKey()))->exists()) {
            $candidate = "{$slug}-{$counter}";
            $counter++;
        }

        return $candidate;
    }
}
