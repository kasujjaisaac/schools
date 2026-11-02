<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEnquiryRequest;
use App\Models\Enquiry;
use App\Models\Institution;
use Illuminate\Http\RedirectResponse;

class EnquiryController extends Controller
{
    public function store(StoreEnquiryRequest $request, Institution $institution): RedirectResponse
    {
        abort_unless($institution->status === 'published', 404);

        Enquiry::create($request->validated() + [
            'institution_id' => $institution->id,
            'status' => 'new',
        ]);

        return back()->with('status', 'Your enquiry has been sent to the institution team.');
    }
}
