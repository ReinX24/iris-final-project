<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applicant Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Success/Error Flash Messages --}}
                @if (session('success'))
                    <div id="success-alert"
                        class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Success!</strong>
                        <span class="block sm:inline">{{ session('success') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer flex items-center"
                            onclick="document.getElementById('success-alert').style.display='none'">
                            <svg class="fill-current h-4 w-4 text-green-500" role="button"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" />
                            </svg>
                        </span>
                    </div>
                @endif
                @if (session('error'))
                    <div id="error-alert"
                        class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4"
                        role="alert">
                        <strong class="font-bold">Error!</strong>
                        <span class="block sm:inline">{{ session('error') }}</span>
                        <span class="absolute top-0 bottom-0 right-0 px-4 py-3 cursor-pointer flex items-center"
                            onclick="document.getElementById('error-alert').style.display='none'">
                            <svg class="fill-current h-4 w-4 text-red-500" role="button"
                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <title>Close</title>
                                <path
                                    d="M10 8.586L2.929 1.515 1.515 2.929 8.586 10l-7.071 7.071 1.414 1.414L10 11.414l7.071 7.071 1.414-1.414L11.414 10l7.071-7.071-1.414-1.414L10 8.586z" />
                            </svg>
                        </span>
                    </div>
                @endif

                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Applicant: {{ $applicant->name }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- Profile Photo --}}
                        <div class="flex flex-col items-center">
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Profile Photo</h3>
                            @if ($applicant->profile_photo)
                                <img src="{{ Storage::url($applicant->profile_photo) }}"
                                    alt="Profile Photo of {{ $applicant->name }}"
                                    class="w-48 h-48 object-cover rounded-full shadow-lg border-4 border-indigo-200">
                            @else
                                <div
                                    class="w-48 h-48 flex items-center justify-center bg-gray-200 text-gray-500 rounded-full shadow-lg border-4 border-gray-300">
                                    <svg class="w-24 h-24" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-500 mt-2">No profile photo available.</p>
                            @endif
                        </div>

                        {{-- Applicant Details --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Personal Information</h3>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Name:</span>
                                {{ $applicant->name }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Age:</span>
                                {{ $applicant->age }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Medical Status:</span>
                                {{ $applicant->medical }}</p>
                            <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Applicant Status:</span>
                                {{ $applicant->status }}</p>
                        </div>
                    </div>

                    {{-- Educational Attainment Section --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Educational Attainment</h3>

                        <!-- Add Educational Attainment Button -->
                        <div class="flex justify-end mb-6">
                            <a href="{{ route('educational-attainments.create', $applicant->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                                Add Educational Attainment
                            </a>
                        </div>

                        {{-- Educational attainment records of the applicant --}}
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            @if ($applicant->educationalAttainments->isNotEmpty())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                School</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Level</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Years</th>
                                            <th scope="col" class="relative px-6 py-3"><span
                                                    class="sr-only">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($applicant->educationalAttainments as $education)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $education->school }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $education->educational_level }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $education->start_year ?? 'N/A' }} -
                                                    {{ $education->end_year ?? 'Present' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('educational-attainments.edit', $education->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                    <form
                                                        action="{{ route('educational-attainments.destroy', $education->id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this educational record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow-inner text-center text-gray-500 italic">
                                    No educational attainment records found for this applicant.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Work Experience Section --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Work Experience</h3>

                        <!-- Add Work Experience Button -->
                        <div class="flex justify-end mb-6">
                            <a href="{{ route('work-experiences.create', $applicant->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                                Add Work Experience
                            </a>
                        </div>

                        {{-- Work experience records of the applicant --}}
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            @if ($applicant->workExperiences->isNotEmpty())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Company Name</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Years</th>
                                            <th scope="col" class="relative px-6 py-3"><span
                                                    class="sr-only">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($applicant->workExperiences as $experience)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $experience->company_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $experience->role }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $experience->start_year }} -
                                                    {{ $experience->end_year ?? 'Present' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('work-experiences.edit', $experience->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                    <form
                                                        action="{{ route('work-experiences.destroy', $experience->id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this work experience record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow-inner text-center text-gray-500 italic">
                                    No work experience records found for this applicant.
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Curriculum Vitae --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Curriculum Vitae</h3>
                        @if ($applicant->curriculum_vitae)
                            <div class="w-full flex flex-col items-start">
                                <embed src="{{ Storage::url($applicant->curriculum_vitae) }}" type="application/pdf"
                                    class="w-full h-screen mb-3 border border-gray-300 rounded-lg shadow-md">

                                <a href="{{ Storage::url($applicant->curriculum_vitae) }}" target="_blank"
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150 mt-4">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13l-3 3m0 0l-3-3m3 3V8m0 13a9 9 0 110-18 9 9 0 010 18z"></path>
                                    </svg>
                                    View CV (Opens in new tab)
                                </a>
                                <p class="text-sm text-gray-500 mt-2">
                                    If the CV does not display above, please click the "View CV" button to open it
                                    in a new tab.
                                </p>
                            </div>
                        @else
                            <div class="bg-gray-50 p-4 rounded-md shadow-inner text-center text-gray-500 italic">
                                No Curriculum Vitae available.
                            </div>
                        @endif
                    </div>

                    {{-- References Section --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">References</h3>

                        <!-- Add Reference Button -->
                        <div class="flex justify-end mb-6">
                            <a href="{{ route('references.create', $applicant->id) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                                Add Reference
                            </a>
                        </div>

                        {{-- Reference records of the applicant --}}
                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            @if ($applicant->references->isNotEmpty())
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Name</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Contact</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Company</th>
                                            <th scope="col"
                                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                Role</th>
                                            <th scope="col" class="relative px-6 py-3"><span
                                                    class="sr-only">Actions</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach ($applicant->references as $reference)
                                            <tr class="hover:bg-gray-50">
                                                <td
                                                    class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $reference->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    @if ($reference->email)
                                                        {{ $reference->email }}<br>
                                                    @endif
                                                    @if ($reference->phone_number)
                                                        {{ $reference->phone_number }}
                                                    @endif
                                                    @if (!$reference->email && !$reference->phone_number)
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $reference->company }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $reference->role }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                    <a href="{{ route('references.edit', $reference->id) }}"
                                                        class="text-indigo-600 hover:text-indigo-900 mr-2">Edit</a>
                                                    <form action="{{ route('references.destroy', $reference->id) }}"
                                                        method="POST" class="inline-block"
                                                        onsubmit="return confirm('Are you sure you want to delete this reference record?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="text-red-600 hover:text-red-900">Delete</button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="bg-gray-50 p-4 rounded-md shadow-inner text-center text-gray-500 italic">
                                    No reference records found for this applicant.
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="text-sm text-gray-500 mt-6 pt-4 border-t border-gray-200">
                        <p class="mb-1">
                            <span class="font-medium text-gray-700">Created:</span>
                            {{ $applicant->created_at->format('F d, Y H:i:s') }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-700">Last Updated:</span>
                            {{ $applicant->updated_at->format('F d, Y H:i:s') }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Back Button -->
                        <a href="{{ route('applicants.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Applicants
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('applicants.edit', $applicant->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Applicant
                        </a>

                        <!-- Delete Button (using a form for proper DELETE request) -->
                        <form action="{{ route('applicants.destroy', $applicant) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this applicant?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                    </path>
                                </svg>
                                Delete Applicant
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
