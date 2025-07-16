<?php

namespace App\Http\Controllers;

use App\Models\Applicant;
use App\Models\Reference;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ReferenceController extends Controller
{
    /**
     * Show the form for adding references for a specific applicant.
     *
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\View\View
     */
    public function create(Applicant $applicant)
    {
        return view('references.create', compact('applicant'));
    }

    /**
     * Store multiple newly created reference records in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Applicant  $applicant
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Applicant $applicant)
    {
        $request->validate([
            'references' => ['required', 'array'],
            'references.*.name' => ['required', 'string', 'max:255'],
            'references.*.email' => ['nullable', 'email', 'max:255'],
            'references.*.phone_number' => ['nullable', 'string', 'max:20'],
            'references.*.company' => ['required', 'string', 'max:255'],
            'references.*.role' => ['required', 'string', 'max:255'],
        ]);

        $applicantId = $applicant->id;

        foreach ($request->input('references') as $referenceData) {
            if (!empty(array_filter($referenceData))) {
                $referenceData['applicant_id'] = $applicantId;
                Reference::create($referenceData);
            }
        }

        return redirect()->route('applicants.show', $applicant)
            ->with('success', 'Reference records added successfully!');
    }

    /**
     * Show the form for editing a specific reference record.
     *
     * @param  \App\Models\Reference  $reference // Route Model Binding
     * @return \Illuminate\View\View
     */
    public function edit(Reference $reference)
    {
        $reference->load('applicant'); // Eager load applicant for displaying name in the view
        return view('references.edit', compact('reference'));
    }

    /**
     * Update the specified reference record in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Reference  $reference // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Reference $reference)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'company' => ['required', 'string', 'max:255'],
            'role' => ['required', 'string', 'max:255'],
        ]);

        $reference->update($request->all());

        return redirect()->route('applicants.show', $reference->applicant_id)
            ->with('success', 'Reference record updated successfully!');
    }

    /**
     * Remove the specified reference record from storage.
     *
     * @param  \App\Models\Reference  $reference // Route Model Binding
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Reference $reference)
    {
        $applicantId = $reference->applicant_id; // Get applicant ID before deleting

        $reference->delete();

        return redirect()->route('applicants.show', $applicantId)
            ->with('success', 'Reference record deleted successfully!');
    }
}
