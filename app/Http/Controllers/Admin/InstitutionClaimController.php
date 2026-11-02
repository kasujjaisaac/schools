<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InstitutionClaim;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InstitutionClaimController extends Controller
{
    public function index(Request $request): View
    {
        $filters = $request->validate([
            'q' => ['nullable', 'string', 'max:120'],
            'status' => ['nullable', 'in:submitted,approved,rejected'],
        ]);

        return view('admin.claims.index', [
            'claims' => InstitutionClaim::query()
                ->when(filled($filters['q'] ?? null), fn ($query) => $query->where('claimant_name', 'like', '%'.$filters['q'].'%'))
                ->when(filled($filters['status'] ?? null), fn ($query) => $query->where('status', $filters['status']))
                ->with(['institution', 'user'])->latest()->paginate(15)->withQueryString(),
        ]);
    }

    public function show(InstitutionClaim $claim): View
    {
        return view('admin.claims.show', [
            'claim' => $claim->load(['institution', 'user']),
        ]);
    }

    public function update(Request $request, InstitutionClaim $claim): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', 'in:submitted,approved,rejected'],
        ]);

        $data['reviewed_at'] = $data['status'] === 'submitted' ? null : now();
        $claim->update($data);

        return redirect()->route('admin.claims.show', $claim)->with('status', 'Claim updated.');
    }
}
