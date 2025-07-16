<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Educational Attainment') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Educational Record for
                        {{ $educationalAttainment->applicant->name }}</h1>

                    <form method="POST" action="{{ route('educational-attainments.update', $educationalAttainment) }}"
                        onsubmit="this.querySelector('button[type=submit]').disabled = true;">
                        @csrf
                        @method('PUT') {{-- Use PUT method for updates --}}

                        {{-- School --}}
                        <div class="mb-4">
                            <label for="school" class="block text-sm font-medium text-gray-700">School</label>
                            <input type="text" name="school" id="school"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('school', $educationalAttainment->school) }}" required>
                            @error('school')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Educational Level --}}
                        <div class="mb-4">
                            <label for="educational_level" class="block text-sm font-medium text-gray-700">Educational
                                Level</label>
                            <select name="educational_level" id="educational_level"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select Level</option>
                                @foreach (['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'] as $level)
                                    <option value="{{ $level }}"
                                        {{ old('educational_level', $educationalAttainment->educational_level) == $level ? 'selected' : '' }}>
                                        {{ $level }}
                                    </option>
                                @endforeach
                            </select>
                            @error('educational_level')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Start Year --}}
                        <div class="mb-4">
                            <label for="start_year" class="block text-sm font-medium text-gray-700">Start Year
                                (Optional)</label>
                            <input type="number" name="start_year" id="start_year"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('start_year', $educationalAttainment->start_year) }}" min="1900"
                                max="{{ date('Y') }}">
                            @error('start_year')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- End Year --}}
                        <div class="mb-6">
                            <label for="end_year" class="block text-sm font-medium text-gray-700">End Year
                                (Optional)</label>
                            <input type="number" name="end_year" id="end_year"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('end_year', $educationalAttainment->end_year) }}" min="1900"
                                max="{{ date('Y') + 5 }}">
                            @error('end_year')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-8 flex justify-end space-x-4">
                            <!-- Cancel Button -->
                            <a href="{{ route('applicants.show', $educationalAttainment->applicant_id) }}"
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
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
