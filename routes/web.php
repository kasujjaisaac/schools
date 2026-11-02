<?php

use App\Http\Controllers\Admin\AdmissionIntakeController as AdminAdmissionIntakeController;
use App\Http\Controllers\Admin\ArticleController as AdminArticleController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\EducationJobController as AdminEducationJobController;
use App\Http\Controllers\Admin\EnquiryController as AdminEnquiryController;
use App\Http\Controllers\Admin\InstitutionClaimController as AdminInstitutionClaimController;
use App\Http\Controllers\Admin\InstitutionController as AdminInstitutionController;
use App\Http\Controllers\Admin\ProgrammeController as AdminProgrammeController;
use App\Http\Controllers\Admin\ScholarshipController as AdminScholarshipController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\InstitutionClaimController;
use App\Http\Controllers\InstitutionPortalController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/institutions', [PublicController::class, 'institutions'])->name('institutions.index');
Route::get('/institutions/{institution:slug}', [PublicController::class, 'institution'])->name('institutions.show');
Route::post('/institutions/{institution:slug}/enquiries', [EnquiryController::class, 'store'])->middleware('throttle:6,1')->name('institutions.enquiries.store');
Route::post('/institutions/{institution:slug}/claims', [InstitutionClaimController::class, 'store'])->middleware('throttle:3,10')->name('institutions.claims.store');
Route::get('/programmes', [PublicController::class, 'programmes'])->name('programmes.index');
Route::get('/programmes/{programme:slug}', [PublicController::class, 'programme'])->name('programmes.show');
Route::get('/admissions', [PublicController::class, 'admissions'])->name('admissions.index');
Route::get('/locations', [PublicController::class, 'locations'])->name('locations.index');
Route::get('/locations/{location:slug}', [PublicController::class, 'location'])->name('locations.show');
Route::get('/careers', [PublicController::class, 'careers'])->name('careers.index');
Route::get('/scholarships', [PublicController::class, 'scholarships'])->name('scholarships.index');
Route::get('/jobs', [PublicController::class, 'jobs'])->name('jobs.index');
Route::get('/guides', [PublicController::class, 'guides'])->name('guides.index');
Route::get('/contact', [PublicController::class, 'contact'])->name('contact');

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:login');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle:6,1')->name('register.store');
});

Route::middleware('auth')->group(function (): void {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', DashboardController::class)->name('dashboard');
});

Route::middleware(['auth', 'role:institution-admin,admin,super-admin'])->prefix('institution-portal')->name('institution.')->group(function (): void {
    Route::get('/', [InstitutionPortalController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [InstitutionPortalController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [InstitutionPortalController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin,super-admin'])->prefix('admin')->name('admin.')->group(function (): void {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::resource('institutions', AdminInstitutionController::class);
    Route::resource('programmes', AdminProgrammeController::class);
    Route::resource('admissions', AdminAdmissionIntakeController::class);
    Route::resource('scholarships', AdminScholarshipController::class);
    Route::resource('education-jobs', AdminEducationJobController::class);
    Route::resource('articles', AdminArticleController::class);
    Route::resource('careers', AdminCareerController::class);
    Route::resource('enquiries', AdminEnquiryController::class)->only(['index', 'show', 'update']);
    Route::resource('claims', AdminInstitutionClaimController::class)->only(['index', 'show', 'update']);
});
