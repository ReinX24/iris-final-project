<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Add References for ') . $applicant->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Add References for {{ $applicant->name }}</h1>

                    <form method="POST" action="{{ route('references.store', $applicant) }}"
                        onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                        @csrf

                        {{-- Hidden Applicant ID --}}
                        <input type="hidden" name="applicant_id" value="{{ $applicant->id }}">

                        <div id="references-container">
                            {{-- Initial Reference Row --}}
                            <div class="reference-row border border-gray-200 rounded-lg p-4 mb-4 bg-gray-50">
                                <h3 class="text-lg font-semibold text-gray-800 mb-4">Reference #<span
                                        class="row-index">1</span></h3>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    {{-- Name --}}
                                    <div>
                                        <label for="references_0_name"
                                            class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="references[0][name]" id="references_0_name"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('references.0.name') }}" required>
                                        @error('references.0.name')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Email Address --}}
                                    <div>
                                        <label for="references_0_email"
                                            class="block text-sm font-medium text-gray-700">Email Address
                                            (Optional)</label>
                                        <input type="email" name="references[0][email]" id="references_0_email"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('references.0.email') }}">
                                        @error('references.0.email')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Phone Number --}}
                                    <div>
                                        <label for="references_0_phone_number"
                                            class="block text-sm font-medium text-gray-700">Phone Number
                                            (Optional)</label>
                                        <input type="text" name="references[0][phone_number]"
                                            id="references_0_phone_number"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('references.0.phone_number') }}">
                                        @error('references.0.phone_number')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Company --}}
                                    <div>
                                        <label for="references_0_company"
                                            class="block text-sm font-medium text-gray-700">Company</label>
                                        <input type="text" name="references[0][company]" id="references_0_company"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('references.0.company') }}" required>
                                        @error('references.0.company')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    {{-- Role --}}
                                    <div>
                                        <label for="references_0_role"
                                            class="block text-sm font-medium text-gray-700">Role</label>
                                        <input type="text" name="references[0][role]" id="references_0_role"
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            value="{{ old('references.0.role') }}" required>
                                        @error('references.0.role')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                {{-- Remove Button (hidden for the first row, shown for dynamically added rows) --}}
                                <div class="mt-4 text-right">
                                    <button type="button" onclick="removeReferenceRow(this)"
                                        class="remove-row-btn inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-600 focus:bg-red-600 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150 hidden">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                            </path>
                                        </svg>
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        {{-- Add New Row Button --}}
                        <div class="mt-6 flex justify-end">
                            <button type="button" onclick="addReferenceRow()"
                                class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Add Another Reference
                            </button>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('applicants.show', $applicant) }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                                </svg>
                                Cancel
                            </a>

                            <!-- Save Changes Button -->
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-3m-1-4l-3.5 3.5m-2.257-2.257a1.993 1.993 0 010-2.828l2.829-2.829a1.993 1.993 0 012.828 0L19 11.172V7.5a.5.5 0 00-.5-.5h-4.672l-3.5 3.5z">
                                    </path>
                                </svg>
                                Save References
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let referenceRowIndex = 0; // Keep track of the current index for new rows

        // Function to add a new reference row
        function addReferenceRow() {
            referenceRowIndex++; // Increment index for the new row

            const container = document.getElementById('references-container');
            const templateRow = container.querySelector('.reference-row'); // Get the first row as a template
            const newRow = templateRow.cloneNode(true); // Deep clone the template row

            // Update IDs, names, and clear values for the cloned inputs
            newRow.querySelectorAll('input, select, textarea').forEach(input => {
                const oldId = input.id;
                const oldName = input.name;

                // Update ID (e.g., references_0_name -> references_1_name)
                input.id = oldId.replace(/_(\d+)_/, `_${referenceRowIndex}_`);
                // Update Name (e.g., references[0][name] -> references[1][name])
                input.name = oldName.replace(/\[(\d+)\]/, `[${referenceRowIndex}]`);

                // Clear input values for the new row
                if (input.type === 'checkbox' || input.type === 'radio') {
                    input.checked = false;
                } else if (input.tagName === 'SELECT') {
                    input.value = ''; // Reset dropdown to default empty option
                } else {
                    input.value = ''; // Clear text/number/email inputs
                }

                // Remove error messages from cloned row if any were present
                const errorP = input.nextElementSibling;
                if (errorP && errorP.classList.contains('text-red-600')) {
                    errorP.remove();
                }
            });

            // Update the row index display
            newRow.querySelector('.row-index').textContent = referenceRowIndex + 1;

            // Show the remove button for the new row
            const removeBtn = newRow.querySelector('.remove-row-btn');
            if (removeBtn) {
                removeBtn.classList.remove('hidden');
            }

            container.appendChild(newRow); // Append the new row to the container
        }

        // Function to remove a reference row
        function removeReferenceRow(button) {
            const rowToRemove = button.closest('.reference-row');
            if (rowToRemove) {
                rowToRemove.remove();
                reindexReferenceRows(); // Reindex rows after removal
            }
        }

        // Function to reindex rows after one is removed
        function reindexReferenceRows() {
            const container = document.getElementById('references-container');
            const rows = container.querySelectorAll('.reference-row');
            referenceRowIndex = 0; // Reset global index

            rows.forEach((row, index) => {
                row.querySelectorAll('input, select, textarea').forEach(input => {
                    const oldId = input.id;
                    const oldName = input.name;

                    input.id = oldId.replace(/_(\d+)_/, `_${index}_`);
                    input.name = oldName.replace(/\[(\d+)\]/, `[${index}]`);
                });
                row.querySelector('.row-index').textContent = index + 1;

                // Hide remove button if it's the last remaining row
                const removeBtn = row.querySelector('.remove-row-btn');
                if (removeBtn) {
                    if (rows.length === 1) {
                        removeBtn.classList.add('hidden');
                    } else {
                        removeBtn.classList.remove('hidden');
                    }
                }
                referenceRowIndex = index; // Update global index to the last valid index
            });
        }

        // Initialize: Hide remove button if only one row exists on page load
        document.addEventListener('DOMContentLoaded', function() {
            reindexReferenceRows(); // Call once on load to set initial state
        });
    </script>
</x-app-layout>
