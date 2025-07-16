<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-8">Centralized Reports Overview</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
                        {{-- Job Report Card --}}
                        <div
                            class="bg-blue-50 p-6 rounded-lg shadow-md border border-blue-200 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-blue-800 mb-2">Job Reports</h3>
                                <p class="text-sm text-blue-700 mb-4">
                                    View detailed reports on job openings, including status, applications received, and
                                    hiring progress.
                                </p>
                            </div>
                            <a href="{{ route('reports.jobs') }}" {{-- Replace with your actual job reports route --}}
                                class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 focus:bg-blue-700 active:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                View Job Report
                            </a>
                        </div>

                        {{-- Applicants Report Card --}}
                        <div
                            class="bg-green-50 p-6 rounded-lg shadow-md border border-green-200 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-green-800 mb-2">Applicants Reports</h3>
                                <p class="text-sm text-green-700 mb-4">
                                    Generate reports on applicant demographics, status, application history, and more.
                                </p>
                            </div>
                            <a href="{{ route('reports.applicants') }}" {{-- Replace with your actual applicants reports route --}}
                                class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 20h2a2 2 0 002-2V4a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2h2m0 0l4-4m-4 4l-4-4m4 4V4">
                                    </path>
                                </svg>
                                View Applicants Report
                            </a>
                        </div>

                        {{-- Login Events Report Card --}}
                        <div
                            class="bg-yellow-50 p-6 rounded-lg shadow-md border border-yellow-200 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-yellow-800 mb-2">Login Events Reports</h3>
                                <p class="text-sm text-yellow-700 mb-4">
                                    Track user login and logout activities, including timestamps and user details for
                                    security auditing.
                                </p>
                            </div>
                            <a href="{{ route('reports.login-events') }}" {{-- Replace with your actual login events reports route --}}
                                class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700 focus:bg-yellow-700 active:bg-yellow-900 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1">
                                    </path>
                                </svg>
                                View Login Events Report
                            </a>
                        </div>

                        {{-- Admin Actions Report Card --}}
                        <div
                            class="bg-red-50 p-6 rounded-lg shadow-md border border-red-200 flex flex-col justify-between">
                            <div>
                                <h3 class="text-xl font-semibold text-red-800 mb-2">Admin Actions Reports</h3>
                                <p class="text-sm text-red-700 mb-4">
                                    Monitor administrative activities, changes made by admins, and system
                                    configurations.
                                </p>
                            </div>
                            <a href="{{ route('reports.admin-actions') }}" {{-- Replace with your actual admin actions reports route --}}
                                class="mt-4 inline-flex items-center justify-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                    </path>
                                </svg>
                                View Admin Actions Report
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
