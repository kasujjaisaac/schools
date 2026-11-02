<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateInstitutionRequest;
use App\Models\AdmissionIntake;
use App\Models\Enquiry;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class InstitutionPortalController extends Controller
{
    public function dashboard(Request $request): View
    {
        $institution = $this->institutionFor($request);
        Gate::authorize('view', $institution);

        return view('institution.dashboard', [
            'institution' => $institution->load(['category', 'location', 'programmes', 'facilities']),
            'enquiries' => Enquiry::whereBelongsTo($institution)->latest()->take(8)->get(),
            'openAdmissions' => AdmissionIntake::whereBelongsTo($institution)->where('status', 'open')->orderBy('closing_date')->get(),
        ]);
    }

    public function edit(Request $request): View
    {
        $institution = $this->institutionFor($request);
        Gate::authorize('update', $institution);

        return view('institution.edit', compact('institution'));
    }

    public function update(UpdateInstitutionRequest $request): RedirectResponse
    {
        $institution = $this->institutionFor($request);
        Gate::authorize('update', $institution);

        $institution->update($request->validated());

        return redirect()->route('institution.dashboard')->with('status', 'Institution profile updated.');
    }

    private function institutionFor(Request $request): Institution
    {
        return Institution::query()->findOrFail($request->user()->institution_id);
    }
}
