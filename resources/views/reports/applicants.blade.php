<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Applicants Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Applicants Report</h1>

                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('reports.applicants') }}"
                        class="mb-6 bg-gray-50 p-4 rounded-lg shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {{-- Name Filter --}}
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Applicant
                                    Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="e.g., John Doe" value="{{ request('name') }}">
                            </div>

                            {{-- Age Range Filter --}}
                            <div class="flex space-x-2">
                                <div class="flex-1">
                                    <label for="min_age" class="block text-sm font-medium text-gray-700">Min
                                        Age</label>
                                    <input type="number" name="min_age" id="min_age"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        min="0" value="{{ request('min_age') }}">
                                </div>
                                <div class="flex-1">
                                    <label for="max_age" class="block text-sm font-medium text-gray-700">Max
                                        Age</label>
                                    <input type="number" name="max_age" id="max_age"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                        min="0" value="{{ request('max_age') }}">
                                </div>
                            </div>

                            {{-- Educational Attainment Filter --}}
                            <div>
                                <label for="educational_attainment"
                                    class="block text-sm font-medium text-gray-700">Educational Attainment</label>
                                <select name="educational_attainment" id="educational_attainment"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All</option>
                                    @foreach (['Primary', 'Secondary', 'Vocational', 'Bachelor', 'Master', 'Doctoral'] as $attainmentOption)
                                        <option value="{{ $attainmentOption }}"
                                            {{ request('educational_attainment') == $attainmentOption ? 'selected' : '' }}>
                                            {{ $attainmentOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Medical Status Filter --}}
                            <div>
                                <label for="medical" class="block text-sm font-medium text-gray-700">Medical
                                    Status</label>
                                <select name="medical" id="medical"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All</option>
                                    @foreach (['Pending', 'Fit To Work'] as $medicalOption)
                                        <option value="{{ $medicalOption }}"
                                            {{ request('medical') == $medicalOption ? 'selected' : '' }}>
                                            {{ $medicalOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Status Filter --}}
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Applicant
                                    Status</label>
                                <select name="status" id="status"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All</option>
                                    @foreach (['Line Up', 'On Process', 'For Interview', 'For Medical', 'Deployed'] as $statusOption)
                                        <option value="{{ $statusOption }}"
                                            {{ request('status') == $statusOption ? 'selected' : '' }}>
                                            {{ $statusOption }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="mt-6 flex justify-end space-x-4">
                            <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m12.75 15 3-3m0 0-3-3m3 3h-7.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                Apply Filters
                            </button>
                            <a href="{{ route('reports.applicants') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear Filters
                            </a>

                            {{-- Download Button --}}
                            <a href="{{ route('reports.applicants.download-csv', request()->query()) }}"
                                class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                                </svg>
                                Download as Excel (CSV)
                            </a>
                        </div>
                    </form>

                    {{-- Applicants Table --}}
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="applicantsTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Age</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Educational Attainment</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Medical</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Status</th>
                                    <th scope="col" class="relative px-6 py-3"><span
                                            class="sr-only">Actions</span></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($applicants as $applicant)
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
                                            @php
                                                $medicalClass = '';
                                                switch ($applicant->medical) {
                                                    case 'Pending':
                                                        $medicalClass = 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'Fit To Work':
                                                        $medicalClass = 'bg-green-100 text-green-800';
                                                        break;
                                                    default:
                                                        $medicalClass = 'bg-gray-100 text-gray-800';
                                                        break;
                                                }
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $medicalClass }}">
                                                {{ ucfirst($applicant->medical) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            @php
                                                $statusClass = '';
                                                switch ($applicant->status) {
                                                    case 'Line Up':
                                                        $statusClass = 'bg-blue-100 text-blue-800';
                                                        break;
                                                    case 'On Process':
                                                        $statusClass = 'bg-indigo-100 text-indigo-800';
                                                        break;
                                                    case 'For Interview':
                                                        $statusClass = 'bg-purple-100 text-purple-800';
                                                        break;
                                                    case 'For Medical':
                                                        $statusClass = 'bg-yellow-100 text-yellow-800';
                                                        break;
                                                    case 'Deployed':
                                                        $statusClass = 'bg-green-100 text-green-800';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-gray-100 text-gray-800';
                                                        break;
                                                }
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClass }}">
                                                {{ ucfirst($applicant->status) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <a href="{{ route('applicants.show', $applicant->id) }}"
                                                class="text-indigo-600 hover:text-indigo-900">View</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            No applicants found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        {{ $applicants->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
