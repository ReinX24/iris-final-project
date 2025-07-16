<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold mb-6">Overview of IRIS</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        {{-- Applicants Card --}}
                        <div class="bg-blue-50 p-6 rounded-lg shadow-md border border-blue-200">
                            <h3 class="text-lg font-semibold text-blue-800 mb-2">Applicants</h3>
                            {{-- Display total applicants from the controller --}}
                            <p class="text-4xl font-bold text-blue-900 mb-4">{{ $totalApplicants ?? 'N/A' }}</p>
                            <p class="text-sm text-blue-700">Total applicants managed</p>
                            <a href="{{ route('applicants.index') }}"
                                class="mt-4 inline-flex items-center text-blue-600 hover:text-blue-800 text-sm font-medium">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>

                        {{-- Job Openings Card --}}
                        <div class="bg-green-50 p-6 rounded-lg shadow-md border border-green-200">
                            <h3 class="text-lg font-semibold text-green-800 mb-2">Job Openings</h3>
                            {{-- Display total job openings from the controller --}}
                            <p class="text-4xl font-bold text-green-900 mb-4">{{ $totalJobOpenings ?? 'N/A' }}</p>
                            <p class="text-sm text-green-700">Currently active positions</p>
                            <a href="{{ route('jobs.index') }}"
                                class="mt-4 inline-flex items-center text-green-600 hover:text-green-800 text-sm font-medium">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>

                        {{-- Registered Users Card --}}
                        <div class="bg-purple-50 p-6 rounded-lg shadow-md border border-purple-200">
                            <h3 class="text-lg font-semibold text-purple-800 mb-2">Registered Users</h3>
                            {{-- Display total registered users from the controller --}}
                            <p class="text-4xl font-bold text-purple-900 mb-4">{{ $totalUsers ?? 'N/A' }}</p>
                            <p class="text-sm text-purple-700">Total system users</p>
                            <a href="{{ route('user_management.index') }}"
                                class="mt-4 inline-flex items-center text-purple-600 hover:text-purple-800 text-sm font-medium">
                                View Details
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
