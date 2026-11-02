<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdmissionIntake;
use App\Models\Article;
use App\Models\Career;
use App\Models\EducationJob;
use App\Models\Enquiry;
use App\Models\Institution;
use App\Models\InstitutionClaim;
use App\Models\Programme;
use App\Models\Scholarship;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'institutionCount' => Institution::count(),
            'publishedInstitutionCount' => Institution::where('status', 'published')->count(),
            'pendingInstitutionCount' => Institution::where('status', 'pending')->count(),
            'recentInstitutions' => Institution::with(['category', 'location'])->latest()->take(5)->get(),
            'programmeCount' => Programme::count(),
            'admissionCount' => AdmissionIntake::count(),
            'scholarshipCount' => Scholarship::count(),
            'jobCount' => EducationJob::count(),
            'articleCount' => Article::count(),
            'careerCount' => Career::count(),
            'newEnquiryCount' => Enquiry::where('status', 'new')->count(),
            'submittedClaimCount' => InstitutionClaim::where('status', 'submitted')->count(),
            'recentEnquiries' => Enquiry::with('institution')->latest()->take(5)->get(),
            'recentClaims' => InstitutionClaim::with('institution')->latest()->take(5)->get(),
        ]);
    }
}
