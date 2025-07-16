<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\WorkExperience;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class WorkExperienceController extends Controller
{
    /**
     * Display the specified applicant.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\View\View
     */
    public function show(Applicant $applicant)
    {
        // Eager load both educationalAttainments and workExperiences
        $applicant->load(['educationalAttainments', 'workExperiences']);
        return view('applicants.show', compact('applicant'));
    }

    /**
     * Show the form for adding work experiences for a specific applicant.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\View\View
     */
    public function create(Applicant $applicant)
    {
        return view('work_experiences.create', compact('applicant'));
    }

    /**
     * Store multiple newly created work experience records in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Applicant $applicant)
    {
        $request->validate([
            'work_experiences' => ['required', 'array'],
            'work_experiences.*.company_name' => ['required', 'string', 'max:255'],
            'work_experiences.*.role' => ['required', 'string', 'max:255'],
            'work_experiences.*.start_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'work_experiences.*.end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5), 'after_or_equal:work_experiences.*.start_year'],
        ]);

        $applicantId = $applicant->id;

        foreach ($request->input('work_experiences') as $experienceData) {
            // Only create if there's actual data in the row
            if (!empty(array_filter($experienceData))) {
                $experienceData['applicant_id'] = $applicantId;
                WorkExperience::create($experienceData);
            }
        }

        return redirect()->route('applicants.show', $applicant)
            ->with('success', 'Work experience records added successfully!');
    }

    /**
     * Show the form for editing a specific work experience record.
     *
     * @param  \App\Models\WorkExperience  $workExperience // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function edit(WorkExperience $workExperience)
    {
        // Eager load applicant for displaying name in the view
        $workExperience->load('applicant');
        return view('work_experiences.edit', compact('workExperience'));
    }

    /**
     * Update the specified work experience record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkExperience  $workExperience // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, WorkExperience $workExperience)
    {
        $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
            'start_year' => ['required', 'integer', 'min:1900', 'max:' . date('Y')],
            'end_year' => ['nullable', 'integer', 'min:1900', 'max:' . (date('Y') + 5), 'after_or_equal:start_year'],
        ]);

        $workExperience->update($request->all());

        return redirect()->route('applicants.show', $workExperience->applicant_id)
            ->with('success', 'Work experience record updated successfully!');
    }

    /**
     * Remove the specified work experience record from storage.
     *
     * @param  \App\Models\WorkExperience  $workExperience // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(WorkExperience $workExperience)
    {
        $applicantId = $workExperience->applicant_id; // Get applicant ID before deleting

        $workExperience->delete();

        return redirect()->route('applicants.show', $applicantId)
            ->with('success', 'Work experience record deleted successfully!');
    }
}
