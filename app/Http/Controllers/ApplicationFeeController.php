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
    public function create()
    {
        Gate::authorize('isAdmin');

        $applicants = Applicant::all(); // Get all applicants for the dropdown
        $jobOpenings = JobOpening::all(); // Get all job openings for the dropdown

        return view('application_fees.create', compact('applicants', 'jobOpenings'));
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
            'amount' => 'required|numeric|min:0|max:999999.99',
            'currency' => ['required', 'string', 'max:3', Rule::in(['PHP', 'USD', 'EUR', 'GBP', 'JPY'])], // Adjust currency options as needed
            'payment_date' => 'nullable|date',
            'payment_method' => ['required', Rule::in(['Cash', 'Bank Transfer', 'Credit Card', 'Online Gateway'])],
            'notes' => 'nullable|string',
        ]);

        // Handle nullable fields properly
        if (empty($validatedData['job_opening_id'])) {
            $validatedData['job_opening_id'] = null;
        }
        if (empty($validatedData['payment_date'])) {
            $validatedData['payment_date'] = null;
        }

        ApplicationFee::create($validatedData);

        return redirect()->route('application_fees.index')
            ->with('success', 'Application fee created successfully!');
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

        $applicants = Applicant::all(); // Get all applicants for the dropdown
        $jobOpenings = JobOpening::all(); // Get all job openings for the dropdown

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
            'amount' => 'required|numeric|min:0|max:999999.99',
            'currency' => ['required', 'string', 'max:3', Rule::in(['PHP', 'USD', 'EUR', 'GBP', 'JPY'])], // Adjust currency options as needed
            'payment_date' => 'nullable|date',
            'payment_method' => ['required', Rule::in(['Cash', 'Bank Transfer', 'Credit Card', 'Online Gateway'])],
            'status' => ['required', Rule::in(['Paid', 'Pending', 'Failed', 'Refunded', 'Waived'])],
            'notes' => 'nullable|string',
        ]);

        // Handle nullable fields properly
        if (empty($validatedData['job_opening_id'])) {
            $validatedData['job_opening_id'] = null;
        }
        if (empty($validatedData['payment_date'])) {
            $validatedData['payment_date'] = null;
        }

        $applicationFee->update($validatedData);

        return redirect()->route('application_fees.show', $applicationFee)
            ->with('success', 'Application fee updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ApplicationFee $applicationFee)
    {
        Gate::authorize('isAdmin');

        $applicationFee->delete();

        return redirect()->route('application_fees.index')
            ->with('success', 'Application Fee deleted successfully!');
    }
}
