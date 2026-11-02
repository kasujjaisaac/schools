<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionIntake;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionIntakeController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:open,closed,draft'],
        ]);

        return view('admin.admissions.index', [
            'admissions' => AdmissionIntake::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('name', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->with('institution')->orderByRaw('closing_date is null')->orderBy('closing_date')->paginate(15)->withQueryString(),
        ]);
    }

    public function create(): View
    {
        return view('admin.admissions.form', $this->formData(new AdmissionIntake(['status' => 'open'])));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_featured'] = $request->boolean('is_featured');

        $admission = AdmissionIntake::create($data);

        return redirect()->route('admin.admissions.show', $admission)->with('status', 'Admission intake created.');
    }

    public function show(AdmissionIntake $admission): View
    {
        return view('admin.admissions.show', [
            'admission' => $admission->load('institution'),
        ]);
    }

    public function edit(AdmissionIntake $admission): View
    {
        return view('admin.admissions.form', $this->formData($admission));
    }

    public function update(Request $request, AdmissionIntake $admission): RedirectResponse
    {
        $data = $this->validatedData($request);
        $data['is_featured'] = $request->boolean('is_featured');

        $admission->update($data);

        return redirect()->route('admin.admissions.show', $admission)->with('status', 'Admission intake updated.');
    }

    public function destroy(AdmissionIntake $admission): RedirectResponse
    {
        $admission->delete();

        return redirect()->route('admin.admissions.index')->with('status', 'Admission intake deleted.');
    }

    /**
     * @return array<string, mixed>
     */
    private function formData(AdmissionIntake $admission): array
    {
        return [
            'admission' => $admission,
            'institutions' => Institution::orderBy('name')->get(['id', 'name']),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'institution_id' => ['required', 'integer', 'exists:institutions,id'],
            'name' => ['required', 'string', 'max:255'],
            'academic_year' => ['nullable', 'string', 'max:255'],
            'opening_date' => ['nullable', 'date'],
            'closing_date' => ['nullable', 'date', 'after_or_equal:opening_date'],
            'description' => ['nullable', 'string', 'max:5000'],
            'requirements' => ['nullable', 'string', 'max:5000'],
            'application_url' => ['nullable', 'url', 'max:2048'],
            'status' => ['required', 'in:open,closed,draft'],
            'is_featured' => ['boolean'],
        ]);
    }
}
