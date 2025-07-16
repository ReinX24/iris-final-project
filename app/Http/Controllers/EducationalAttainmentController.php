<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\EducationalAttainment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EducationalAttainmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Applicant $applicant)
    {
        return view("educational_attainments.create", [
            'applicant' => $applicant
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Applicant $applicant)
    {
        // Validate the incoming array of educational attainments
        $request->validate([
            'educational_attainments' => ['required', 'array'],
            'educational_attainments.*.school' => ['required', 'string', 'max:255'],
            'educational_attainments.*.educational_level' => ['required', 'string', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
            'educational_attainments.*.start_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'educational_attainments.*.end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5), 'after_or_equal:educational_attainments.*.start_year'],
        ]);

        // Delete existing educational attainments if you want to replace them,
        // or just add new ones if you want to append.
        // For this scenario, we'll assume you're adding new ones.
        // If you want to replace all, uncomment the line below:
        // $applicant->educationalAttainments()->delete();

        foreach ($request->input('educational_attainments') as $attainmentData) {
            // Ensure data is not empty (e.g., if a row was added but left blank)
            if (!empty(array_filter($attainmentData))) {
                $attainmentData["applicant_id"] = $applicant->id;
                $applicant->educationalAttainments()->create($attainmentData);
            }
        }

        return redirect()->route('applicants.show', $applicant)
            ->with('success', 'Educational attainment records added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(EducationalAttainment $educationalAttainment)
    {
        // This method correctly passes the educationalAttainment instance to the view.
        return view('educational_attainments.edit', compact('educationalAttainment'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, EducationalAttainment $educationalAttainment)
    {
        // Validate the incoming request data for the single educational attainment record
        $request->validate([
            'school' => ['required', 'string', 'max:255'],
            'educational_level' => ['required', 'string', Rule::in(['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'])],
            'start_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5), 'after_or_equal:start_year'],
        ]);

        // Update the educational attainment record with the validated data.
        // The `update` method on the Eloquent model will automatically save changes to the database.
        $educationalAttainment->update($request->all());

        // Redirect back to the applicant's show page.
        // We use $educationalAttainment->applicant_id to ensure we go back to the correct applicant.
        return redirect()->route('applicants.show', $educationalAttainment->applicant_id)
            ->with('success', 'Educational attainment record updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EducationalAttainment $educationalAttainment)
    {
        // Get the applicant_id before deleting the educational attainment record
        $applicantId = $educationalAttainment->applicant_id;

        // Delete the educational attainment record
        $educationalAttainment->delete();

        // Redirect back to the applicant's show page with a success message
        return redirect()->route('applicants.show', $applicantId)
            ->with('success', 'Educational attainment record deleted successfully!');
    }
}
