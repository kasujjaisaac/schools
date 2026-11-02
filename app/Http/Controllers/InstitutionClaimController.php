<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInstitutionClaimRequest;
use App\Models\Institution;
use App\Models\InstitutionClaim;
use Illuminate\Http\RedirectResponse;

class InstitutionClaimController extends Controller
{
    public function store(StoreInstitutionClaimRequest $request, Institution $institution): RedirectResponse
    {
        abort_unless($institution->status === 'published', 404);

        InstitutionClaim::create($request->validated() + [
            'institution_id' => $institution->id,
            'user_id' => $request->user()?->id,
            'status' => 'submitted',
        ]);

        return back()->with('status', 'Your claim request has been submitted for review.');
    }
}
