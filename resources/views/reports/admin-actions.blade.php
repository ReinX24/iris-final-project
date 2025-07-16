<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Actions Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="p-6 text-gray-900">
                    <h1 class="text-3xl font-bold text-gray-900 mb-6">Admin Actions Report</h1>

                    {{-- Filter Form --}}
                    <form method="GET" action="{{ route('reports.admin-actions') }}"
                        class="mb-6 bg-gray-50 p-4 rounded-lg shadow-inner">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {{-- Admin Name/Email Filter --}}
                            <div>
                                <label for="admin_name_email" class="block text-sm font-medium text-gray-700">Admin Name
                                    or Email</label>
                                <input type="text" name="admin_name_email" id="admin_name_email"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="e.g., Admin User or admin@example.com"
                                    value="{{ request('admin_name_email') }}">
                            </div>

                            {{-- Action Type Filter --}}
                            <div>
                                <label for="action_type" class="block text-sm font-medium text-gray-700">Action
                                    Type</label>
                                <select name="action_type" id="action_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Action Types</option>
                                    @foreach ($actionTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ request('action_type') == $type ? 'selected' : '' }}>
                                            {{ Str::title(str_replace('_', ' ', $type)) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Target Type Filter --}}
                            <div>
                                <label for="target_type" class="block text-sm font-medium text-gray-700">Target
                                    Type</label>
                                <select name="target_type" id="target_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">All Target Types</option>
                                    @foreach ($targetTypes as $type)
                                        <option value="{{ $type }}"
                                            {{ request('target_type') == $type ? 'selected' : '' }}>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Target ID Filter --}}
                            <div>
                                <label for="target_id" class="block text-sm font-medium text-gray-700">Target ID</label>
                                <input type="number" name="target_id" id="target_id"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    placeholder="e.g., 123" value="{{ request('target_id') }}">
                            </div>

                            {{-- Start Date Filter --}}
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Action
                                    From</label>
                                <input type="date" name="start_date" id="start_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ request('start_date') }}">
                            </div>

                            {{-- End Date Filter --}}
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">Action To</label>
                                <input type="date" name="end_date" id="end_date"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                    value="{{ request('end_date') }}">
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
                            <a href="{{ route('reports.admin-actions') }}"
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-offset-2 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear Filters
                            </a>

                            {{-- Download Button --}}
                            <a href="{{ route('reports.admin-actions.download-csv', request()->query()) }}"
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

                    {{-- Admin Actions Table --}}
                    <div class="overflow-x-auto shadow-md sm:rounded-lg">
                        <table id="adminActionsTable" class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Log ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Admin</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Target Type</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Target ID</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Target Details</th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action At</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($adminActions as $action)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $action->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $action->admin->name ?? 'Deleted Admin' }}<br>
                                            <span
                                                class="text-gray-500 text-xs">{{ $action->admin->email ?? 'N/A' }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            <span
                                                class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ Str::title(str_replace('_', ' ', $action->action_type)) }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ Str::afterLast($action->target_type, '\\') ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $action->target_id }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-900 max-w-xs truncate"
                                            title="{{ json_encode($action->details) }}">
                                            @if ($action->target_type === 'App\Models\User' && $action->target)
                                                Name: {{ $action->target->name ?? 'N/A' }}<br>
                                                Email: {{ $action->target->email ?? 'N/A' }}<br>
                                                Role: {{ $action->target->role ?? 'N/A' }}
                                            @elseif ($action->details)
                                                {{-- <pre class="text-xs text-gray-700">{{ json_encode($action->details, JSON_PRETTY_PRINT) }}</pre> --}}
                                                Name: {{ $action->details['name'] ?? 'N/A' }}<br>
                                                Email: {{ $action->details['email'] ?? 'N/A' }}<br>
                                                Role: {{ $action->details['role'] ?? 'N/A' }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                            {{ $action->created_at->format('M d, Y H:i:s') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7"
                                            class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                            No admin actions found matching your criteria.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination Links --}}
                    <div class="mt-4">
                        {{ $adminActions->appends(request()->query())->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
