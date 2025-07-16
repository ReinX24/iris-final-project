<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Applicant') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Edit Applicant: {{ $applicant->name }}</h1>

                    <form method="POST" action="{{ route('applicants.update', $applicant->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Use PUT method for updates --}}

                        {{-- Name --}}
                        <div class="mb-4">
                            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                            <input type="text" name="name" id="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('name', $applicant->name) }}" required autofocus>
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Age --}}
                        <div class="mb-4">
                            <label for="age" class="block text-sm font-medium text-gray-700">Age</label>
                            <input type="number" name="age" id="age"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                value="{{ old('age', $applicant->age) }}" required min="18" max="100">
                            @error('age')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Profile Photo --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo (Optional)</label>
                            <label for="profile_photo"
                                class="flex items-center px-4 py-2 bg-white text-indigo-600 rounded-md border border-gray-300 cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                <span>Upload New Profile Photo</span>
                                <input type="file" name="profile_photo" id="profile_photo" class="sr-only"
                                    onchange="document.getElementById('profile_photo_name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                            </label>
                            <span id="profile_photo_name" class="mt-2 text-sm text-gray-500 block">
                                {{ $applicant->profile_photo ? basename($applicant->profile_photo) : 'No file chosen' }}
                            </span>
                            @if ($applicant->profile_photo)
                                <p class="text-sm text-gray-500 mt-1">Current: <a
                                        href="{{ Storage::url($applicant->profile_photo) }}" target="_blank"
                                        class="text-indigo-600 hover:underline">View Current Photo</a></p>
                            @endif
                            @error('profile_photo')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Curriculum Vitae (Document) --}}
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Curriculum Vitae
                                (Optional)</label>
                            <label for="curriculum_vitae"
                                class="flex items-center px-4 py-2 bg-white text-indigo-600 rounded-md border border-gray-300 cursor-pointer hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                    </path>
                                </svg>
                                <span>Upload New Curriculum Vitae</span>
                                <input type="file" name="curriculum_vitae" id="curriculum_vitae" class="sr-only"
                                    onchange="document.getElementById('curriculum_vitae_name').innerText = this.files[0] ? this.files[0].name : 'No file chosen'">
                            </label>
                            <span id="curriculum_vitae_name" class="mt-2 text-sm text-gray-500 block">
                                {{ $applicant->curriculum_vitae ? basename($applicant->curriculum_vitae) : 'No file chosen' }}
                            </span>
                            @if ($applicant->curriculum_vitae)
                                <p class="text-sm text-gray-500 mt-1">Current: <a
                                        href="{{ Storage::url($applicant->curriculum_vitae) }}" target="_blank"
                                        class="text-indigo-600 hover:underline">View Current CV</a></p>
                            @endif
                            @error('curriculum_vitae')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Working Experience --}}
                        <div class="mb-4">
                            <label for="working_experience" class="block text-sm font-medium text-gray-700">Working
                                Experience (Optional)</label>
                            <textarea name="working_experience" id="working_experience" rows="6"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('working_experience', $applicant->working_experience) }}</textarea>
                            @error('working_experience')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Medical Status --}}
                        <div class="mb-4">
                            <label for="medical" class="block text-sm font-medium text-gray-700">Medical Status</label>
                            <select name="medical" id="medical"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach (['Pending', 'Fit To Work'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('medical', $applicant->medical) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('medical')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Applicant Status --}}
                        <div class="mb-6">
                            <label for="status" class="block text-sm font-medium text-gray-700">Applicant
                                Status</label>
                            <select name="status" id="status"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                required>
                                @foreach (['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'] as $status)
                                    <option value="{{ $status }}"
                                        {{ old('status', $applicant->status) == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
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
