<?php

namespace App\Http\Controllers;

use App\Models\AdmissionIntake;
use App\Models\Enquiry;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if ($user->isAdministrator()) {
            return redirect()->route('admin.dashboard');
        }

        if ($user->hasRole('institution-admin') && $user->institution_id) {
            return redirect()->route('institution.dashboard');
        }

        return view('dashboard', [
            'savedMessage' => 'Student saving and deadline alerts are ready for the next account milestone.',
            'institutionCount' => Institution::where('status', 'published')->count(),
            'openAdmissionCount' => AdmissionIntake::where('status', 'open')->count(),
            'enquiryCount' => Enquiry::where('email', $user->email)->orWhere('telephone', $user->email)->count(),
        ]);
    }
}
