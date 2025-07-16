<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                {{-- Dismissible Flash Message for 'success' --}}
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

                <div class="p-6 text-gray-900">
                    <!-- Job Title -->
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $job->title }}</h1>

                    <!-- Location -->
                    <p class="text-lg text-gray-700 mb-3 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-indigo-600" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-semibold me-2">Location:</span> {{ $job->location }}
                    </p>

                    <!-- Status Badge -->
                    <div class="mb-4">
                        @php
                            $statusClass = '';
                            switch ($job->status) {
                                case 'active':
                                    $statusClass = 'bg-green-100 text-green-800';
                                    break;
                                case 'inactive':
                                    $statusClass = 'bg-yellow-100 text-yellow-800';
                                    break;
                                case 'expired':
                                    $statusClass = 'bg-red-100 text-red-800';
                                    break;
                                default:
                                    $statusClass = 'bg-gray-100 text-gray-800';
                                    break;
                            }
                        @endphp
                        <span
                            class="inline-flex items-center px-3 py-0.5 rounded-full text-lg font-medium {{ $statusClass }}">
                            {{ ucfirst($job->status) }}
                        </span>
                    </div>

                    {{-- Toggle for Active/Inactive Status (only if not expired) --}}
                    @if ($job->status !== 'expired' && ($job->date_expiry === null || \Carbon\Carbon::now()->lessThan($job->date_expiry)))
                        <div class="mt-4 mb-6">
                            <label for="status-toggle" class="flex items-center cursor-pointer">
                                <div class="relative">
                                    <input type="checkbox" id="status-toggle" class="sr-only"
                                        {{ $job->status === 'active' ? 'checked' : '' }}
                                        onchange="
                                            let newStatus = this.checked ? 'active' : 'inactive';
                                            document.getElementById('hidden-status-input').value = newStatus;
                                            document.getElementById('status-update-form').submit();
                                        ">
                                    <div class="block bg-gray-600 w-14 h-8 rounded-full"></div>
                                    <div class="dot absolute left-1 top-1 bg-white w-6 h-6 rounded-full transition">
                                    </div>
                                </div>
                                <div id="status-text" class="ml-3 text-gray-700 font-medium">
                                    {{ $job->status === 'active' ? 'Job is Active' : 'Job is Inactive' }}
                                </div>
                            </label>
                            {{-- Hidden form to submit status update --}}
                            <form id="status-update-form" action="{{ route('jobs.update', $job->id) }}" method="POST"
                                class="hidden">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" id="hidden-status-input"
                                    value="{{ $job->status }}">
                                {{-- Ensure date_needed is always a valid string. It's required, so it should exist. --}}
                                <input type="hidden" name="date_needed"
                                    value="{{ $job->date_needed ? $job->date_needed->format('Y-m-d') : '' }}">
                                {{-- Ensure date_expiry is always a valid string or empty if null --}}
                                <input type="hidden" name="date_expiry"
                                    value="{{ $job->date_expiry ? $job->date_expiry->format('Y-m-d') : '' }}">
                                <input type="hidden" name="title" value="{{ $job->title }}">
                                <input type="hidden" name="description" value="{{ $job->description }}">
                                <input type="hidden" name="location" value="{{ $job->location }}">
                            </form>
                        </div>
                        <style>
                            /* Custom styles for the toggle switch */
                            input:checked+.block {
                                background-color: #48bb78;
                                /* Tailwind green-500 */
                            }

                            input:checked+.block+.dot {
                                transform: translateX(100%);
                            }
                        </style>
                    @elseif ($job->status !== 'expired' && $job->date_expiry && \Carbon\Carbon::now()->greaterThanOrEqualTo($job->date_expiry))
                        {{-- Mark as Expired Button --}}
                        <div class="mt-4 mb-6">
                            <form action="{{ route('jobs.update', $job->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure you want to mark this job as expired? This action cannot be undone.');">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="status" value="expired">
                                {{-- Ensure date_needed is always a valid string. It's required, so it should exist. --}}
                                <input type="hidden" name="date_needed"
                                    value="{{ $job->date_needed ? $job->date_needed->format('Y-m-d') : '' }}">
                                {{-- Ensure date_expiry is always a valid string or empty if null --}}
                                <input type="hidden" name="date_expiry"
                                    value="{{ $job->date_expiry ? $job->date_expiry->format('Y-m-d') : '' }}">
                                <input type="hidden" name="title" value="{{ $job->title }}">
                                <input type="hidden" name="description" value="{{ $job->description }}">
                                <input type="hidden" name="location" value="{{ $job->location }}">

                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Mark as Expired
                                </button>
                            </form>
                        </div>
                    @endif

                    <!-- Dates -->
                    <div class="text-md text-gray-600 mb-6">
                        <p class="flex items-center mb-2">
                            <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            <span class="font-semibold text-gray-800 me-2">Start Date:</span>
                            {{ $job->date_needed->format('F d, Y') }}
                        </p>
                        @if ($job->date_expiry)
                            <p class="flex items-center">
                                <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold text-gray-800 me-2">Expires On:</span>
                                {{ $job->date_expiry->format('F d, Y') }}
                            </p>
                        @else
                            <p class="flex items-center text-gray-500">
                                <svg class="w-5 h-5 mr-2 text-gray-500" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <span class="font-semibold text-gray-800 me-2">Expires:</span> Open until filled
                            </p>
                        @endif
                    </div>

                    <!-- Job Description -->
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Job Description</h3>
                    <div class="prose max-w-none text-gray-700 leading-relaxed mb-8">
                        {{-- Using nl2br to preserve line breaks from the database --}}
                        {!! nl2br(e($job->description)) !!}
                    </div>

                    <!-- Timestamps -->
                    <div class="text-sm text-gray-500 mt-6 pt-4 border-t border-gray-200">
                        <p class="mb-1">
                            <span class="font-medium text-gray-700">Created:</span>
                            {{ $job->created_at->format('F d, Y H:i:s') }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-700">Last Updated:</span>
                            {{ $job->updated_at->format('F d, Y H:i:s') }}
                        </p>
                    </div>

                    {{-- Applicants for this Job Opening --}}
                    <div class="mt-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-4">Applicants for this Job</h3>

                        <!-- Create Job Button -->
                        <div class="flex justify-end mb-6">
                            <a href="{{ route('jobs.add_applicant', $job) }}"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4">
                                    </path>
                                </svg>
                                Add Applicant
                            </a>
                        </div>

                        <div class="overflow-x-auto shadow-md sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            ID
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Name
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Age
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Educational Attainment
                                        </th>
                                        <th scope="col"
                                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Status
                                        </th>
                                        <th scope="col" class="relative px-6 py-3">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse ($job->applicants as $applicant)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $applicant->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $applicant->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $applicant->age }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $applicant->educational_attainment }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                {{ $applicant->status }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <a href="{{ route('applicants.show', $applicant->id) }}"
                                                    class="text-indigo-600 hover:text-indigo-900 mr-2">View</a>
                                                {{-- Detach/Remove Button --}}
                                                <form
                                                    action="{{ route('jobs.detach_applicant', ['job' => $job, 'applicant' => $applicant]) }}"
                                                    method="POST" class="inline-block"
                                                    onsubmit="return confirm('Are you sure you want to remove {{ $applicant->name }} from this job opening?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                                        Remove
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6"
                                                class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                No applicants are currently associated with this job opening.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Back Button -->
                        <a href="{{ route('jobs.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Job Openings
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('jobs.edit', $job) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Job
                        </a>

                        <!-- Delete Button (using a form for proper DELETE request) -->
                        <form action="{{ route('jobs.destroy', $job) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this job opening?');">
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
                                Delete Job
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
