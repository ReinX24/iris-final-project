<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Job Openings') }}
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
                    <!-- Create Job Button -->
                    <div class="flex justify-end mb-6">
                        <a href="{{ route('jobs.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Create New Job
                        </a>
                    </div>

                    <!-- Main container for job cards using grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                        @forelse ($jobs as $job)
                            <!-- Job Card Component -->
                            <div
                                class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-shadow duration-300 overflow-hidden">
                                <!-- Added flexbox properties to the inner content div -->
                                <div class="p-6 flex flex-col h-full">
                                    <!-- Job Title -->
                                    <h2 class="text-2xl font-semibold text-gray-900 mb-2">
                                        {{ $job->title }}
                                    </h2>

                                    <!-- Location -->
                                    <p class="text-md text-gray-600 mb-2 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor"
                                            viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd"
                                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        {{ $job->location }}
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
                                            class="inline-flex items-center px-3 py-0.5 rounded-full text-sm font-medium {{ $statusClass }}">
                                            {{ ucfirst($job->status) }}
                                        </span>
                                    </div>

                                    <!-- Job Description (truncated for card) -->
                                    <p class="text-gray-700 text-base leading-relaxed mb-4 flex-grow">
                                        {{ Str::limit($job->description, 64) }}
                                    </p>

                                    <!-- Dates -->
                                    <div class="text-sm text-gray-500 mb-4">
                                        <p class="flex items-center mb-1">
                                            <svg class="w-4 h-4 mr-1 text-green-500 me-1" fill="currentColor"
                                                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd"
                                                    d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span class="font-medium text-gray-700 me-1">Start Date:</span>
                                            {{ $job->date_needed->format('M d, Y') }}
                                        </p>
                                        @if ($job->date_expiry)
                                            <p class="flex items-center">
                                                <svg class="w-4 h-4 mr-1 text-red-500" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="font-medium text-gray-700 me-1">Expires:</span>
                                                {{ $job->date_expiry->format('M d, Y') }}
                                            </p>
                                        @else
                                            <p class="flex items-center text-gray-500">
                                                <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor"
                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd"
                                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l3 3a1 1 0 001.414-1.414L11 9.586V6z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                                <span class="font-medium text-gray-700 me-1">Expires:</span> Open until
                                                filled
                                            </p>
                                        @endif
                                    </div>

                                    <!-- Call to Action Button (e.g., View Details) -->
                                    <a href="{{ route('jobs.show', $job->id) }}"
                                        class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg font-semibold text-center
                                            hover:bg-indigo-700 transition-colors duration-200 focus:outline-none focus:ring-2
                                            focus:ring-indigo-500 focus:ring-offset-2 w-full mt-auto">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <!-- Message if no jobs are found -->
                            <div class="col-span-full text-center text-gray-600 py-10">
                                <p class="text-xl">No job openings found at the moment.</p>
                                <p class="text-md mt-2">Please check back later!</p>
                            </div>
                        @endforelse
                    </div>

                    {{-- Pagination links --}}
                    @if ($jobs instanceof \Illuminate\Pagination\LengthAwarePaginator)
                        <div class="mt-8">
                            {{ $jobs->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
