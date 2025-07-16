<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\ApplicationFee;
use App\Models\JobOpening;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class ApplicationFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Eager load applicant and jobOpening relationships for efficient display
        $applicationFees = ApplicationFee::with(['applicant', 'jobOpening'])
            ->latest()
            ->paginate(10);
        return view('application_fees.index', compact('applicationFees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        Gate::authorize('isAdmin');

        $applicants = Applicant::orderBy('name')->get(); // Fetch all applicants, ordered by name
        $jobOpenings = JobOpening::orderBy('title')->get(); // Fetch all job openings, ordered by title

        $selectedApplicant = null;
        // Check if applicant_id is present in the request (e.g., from applicant details page)
        if ($request->has('applicant_id')) {
            $selectedApplicant = Applicant::find($request->input('applicant_id'));
        }

        return view('application_fees.create', [
            'applicants' => $applicants,
            'jobOpenings' => $jobOpenings,
            'selectedApplicant' => $selectedApplicant, // Pass the selected applicant to the view
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('isAdmin');

        $validatedData = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'job_opening_id' => 'nullable|exists:job_openings,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'payment_date' => 'nullable|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,Credit Card,Online Gateway',
            'notes' => 'nullable|string|max:1000',
        ]);

        $fee = ApplicationFee::create($validatedData);

        // Redirect back to the applicant's show page or the application fees index
        if ($fee->applicant_id) {
            return redirect()->route('applicants.show', $fee->applicant_id)
                ->with('success', 'Application fee created successfully!');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ApplicationFee $applicationFee)
    {
        Gate::authorize('isAdmin');

        return view('application_fees.show', ['applicationFee' => $applicationFee]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApplicationFee $applicationFee)
    {
        Gate::authorize('isAdmin');

        // Fetch all applicants and job openings to populate the dropdowns
        $applicants = Applicant::orderBy('name')->get();
        $jobOpenings = JobOpening::orderBy('title')->get();

        return view('application_fees.edit', compact('applicationFee', 'applicants', 'jobOpenings'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApplicationFee $applicationFee)
    {
        Gate::authorize('isAdmin');

        $validatedData = $request->validate([
            'applicant_id' => 'required|exists:applicants,id',
            'job_opening_id' => 'nullable|exists:job_openings,id',
            'amount' => 'required|numeric|min:0',
            'currency' => 'required|string|max:3',
            'payment_date' => 'nullable|date',
            'payment_method' => 'required|in:Cash,Bank Transfer,Credit Card,Online Gateway',
            'notes' => 'nullable|string|max:1000',
        ]);

        $applicationFee->update($validatedData);

        // Redirect back to the application fees index or a show page if you have one
        return redirect()->route('applicants.show', $applicationFee->applicant_id)
            ->with('success', 'Application fee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicationFee $applicationFee)
    {
        Gate::authorize('isAdmin');

        $applicationFee->delete();

        return redirect()->route('applicants.show', $applicationFee->applicant_id)
            ->with('success', 'Application Fee deleted successfully!');
    }
}
