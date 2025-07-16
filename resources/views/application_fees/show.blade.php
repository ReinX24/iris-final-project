<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Application Fee Details') }}
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
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Application Fee ID: {{ $applicationFee->id }}</h1>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        {{-- Applicant Information --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Applicant Details</h3>
                            @if ($applicationFee->applicant)
                                <p class="text-lg text-gray-700 mb-2">
                                    <span class="font-semibold">Name:</span>
                                    <a href="{{ route('applicants.show', $applicationFee->applicant->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $applicationFee->applicant->name }}
                                    </a>
                                </p>
                                <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Applicant ID:</span>
                                    {{ $applicationFee->applicant->id }}</p>
                            @else
                                <p class="text-lg text-gray-700 mb-2 italic">Applicant not found or deleted.</p>
                            @endif
                        </div>

                        {{-- Job Opening Information --}}
                        <div>
                            <h3 class="text-xl font-semibold text-gray-800 mb-3">Job Opening Details</h3>
                            @if ($applicationFee->jobOpening)
                                <p class="text-lg text-gray-700 mb-2">
                                    <span class="font-semibold">Job Title:</span>
                                    <a href="{{ route('jobs.show', $applicationFee->jobOpening->id) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $applicationFee->jobOpening->title }}
                                    </a>
                                </p>
                                <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Job ID:</span>
                                    {{ $applicationFee->jobOpening->id }}</p>
                            @else
                                <p class="text-lg text-gray-700 mb-2 italic">Not associated with a specific job opening.
                                </p>
                            @endif
                        </div>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Payment Information</h3>
                        <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Amount:</span>
                            {{ number_format($applicationFee->amount, 2) }} {{ $applicationFee->currency }}</p>
                        <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Payment Date:</span>
                            {{ $applicationFee->payment_date ? $applicationFee->payment_date->format('F d, Y h:i A') : 'N/A' }}
                        </p>
                        <p class="text-lg text-gray-700 mb-2"><span class="font-semibold">Payment Method:</span>
                            {{ $applicationFee->payment_method ?? 'N/A' }}</p>
                    </div>

                    {{-- Notes --}}
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold text-gray-800 mb-3">Notes</h3>
                        <div
                            class="prose max-w-none text-gray-700 leading-relaxed bg-gray-50 p-4 rounded-md shadow-inner">
                            @if ($applicationFee->notes)
                                {!! nl2br(e($applicationFee->notes)) !!}
                            @else
                                <p class="text-gray-500 italic">No additional notes.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Timestamps -->
                    <div class="text-sm text-gray-500 mt-6 pt-4 border-t border-gray-200">
                        <p class="mb-1">
                            <span class="font-medium text-gray-700">Created:</span>
                            {{ $applicationFee->created_at->format('F d, Y H:i:s') }}
                        </p>
                        <p>
                            <span class="font-medium text-gray-700">Last Updated:</span>
                            {{ $applicationFee->updated_at->format('F d, Y H:i:s') }}
                        </p>
                    </div>

                    <!-- Action Buttons -->
                    <div class="mt-8 flex justify-end space-x-4">
                        <!-- Back Button -->
                        <a href="{{ route('application_fees.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                            </svg>
                            Back to Fees
                        </a>

                        <!-- Edit Button -->
                        <a href="{{ route('application_fees.edit', $applicationFee->id) }}"
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z">
                                </path>
                            </svg>
                            Edit Fee
                        </a>

                        <!-- Delete Button (using a form for proper DELETE request) -->
                        <form action="{{ route('application_fees.destroy', $applicationFee->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this application fee record?');">
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
                                Delete Fee
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
