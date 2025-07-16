<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Application Fee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Create New Application Fee</h1>

                    <form method="POST" action="{{ route('application_fees.store') }}">
                        @csrf

                        {{-- Applicant ID --}}
                        <div class="mb-4">
                            <label for="applicant_id" class="block text-sm font-medium text-gray-700">Applicant</label>
                            <select name="applicant_id" id="applicant_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select an Applicant</option>
                                @foreach ($applicants as $applicant)
                                    <option value="{{ $applicant->id }}"
                                        {{ old('applicant_id') == $applicant->id ? 'selected' : '' }}>
                                        {{ $applicant->name }} (ID: {{ $applicant->id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('applicant_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Job Opening ID --}}
                        <div class="mb-4">
                            <label for="job_opening_id" class="block text-sm font-medium text-gray-700">Job Opening
                                (Optional)</label>
                            <select name="job_opening_id" id="job_opening_id"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">-- No Specific Job --</option>
                                @foreach ($jobOpenings as $jobOpening)
                                    <option value="{{ $jobOpening->id }}"
                                        {{ old('job_opening_id') == $jobOpening->id ? 'selected' : '' }}>
                                        {{ $jobOpening->title }} (ID: {{ $jobOpening->id }})
                                    </option>
                                @endforeach
                            </select>
                            @error('job_opening_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Amount --}}
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-700">Amount</label>
                            <input type="number" name="amount" id="amount" step="0.01"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('amount') }}" required min="0">
                            @error('amount')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Currency --}}
                        <div class="mb-4">
                            <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                            <select name="currency" id="currency"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach (['PHP', 'USD', 'EUR', 'GBP', 'JPY'] as $currencyOption)
                                    <option value="{{ $currencyOption }}"
                                        {{ old('currency', 'PHP') == $currencyOption ? 'selected' : '' }}>
                                        {{ $currencyOption }}
                                    </option>
                                @endforeach
                            </select>
                            @error('currency')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Payment Date --}}
                        <div class="mb-4">
                            <label for="payment_date" class="block text-sm font-medium text-gray-700">Payment Date
                                (Optional)</label>
                            <input type="datetime-local" name="payment_date" id="payment_date"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('payment_date') }}">
                            @error('payment_date')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Payment Method --}}
                        <div class="mb-4">
                            <label for="payment_method" class="block text-sm font-medium text-gray-700">Payment
                                Method</label>
                            <select name="payment_method" id="payment_method"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                <option value="">Select Method</option>
                                @foreach (['Cash', 'Bank Transfer', 'Credit Card', 'Online Gateway'] as $method)
                                    <option value="{{ $method }}"
                                        {{ old('payment_method') == $method ? 'selected' : '' }}>
                                        {{ $method }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Notes --}}
                        <div class="mb-6">
                            <label for="notes" class="block text-sm font-medium text-gray-700">Notes
                                (Optional)</label>
                            <textarea name="notes" id="notes" rows="4"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
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
                                Cancel
                            </a>

                            <!-- Create Application Fee Button -->
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"></path>
                                </svg>
                                Create Application Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
