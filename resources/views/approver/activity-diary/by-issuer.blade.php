<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Activities for') }}: {{ $issuer->issuer_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <!-- Issuer Information Card -->
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <div>
                            <h3 class="text-lg font-medium leading-6 text-gray-900">{{ $issuer->issuer_name }}</h3>
                            <p class="max-w-2xl mt-1 text-sm text-gray-500">{{ $issuer->issuer_short_name }}</p>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 sm:px-6">
                    <form method="GET" action="{{ route('activity-diary-a.by-issuer', $issuer->id) }}">
                        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                    <option value="in_progress" @selected(request('status') === 'in_progress')>In Progress</option>
                                    <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                                    <option value="overdue" @selected(request('status') === 'overdue')>Overdue</option>
                                    <option value="compiled" @selected(request('status') === 'compiled')>Compiled</option>
                                    <option value="notification" @selected(request('status') === 'notification')>Notification</option>
                                    <option value="passed" @selected(request('status') === 'passed')>Passed</option>
                                </select>
                            </div>

                            <!-- Date Range Filter -->
                            <div>
                                <label for="due_date" class="block text-sm font-medium text-gray-700">Due Date</label>
                                <input type="date" name="due_date" id="due_date" value="{{ request('due_date') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistics Summary -->
                <div class="grid grid-cols-1 gap-4 px-4 py-5 sm:px-6 md:grid-cols-4">
                    @php
                        $pendingCount = $activities->where('status', 'pending')->count();
                        $inProgressCount = $activities->where('status', 'in_progress')->count();
                        $completedCount = $activities->where('status', 'completed')->count();
                        $overdueCount = $activities->where('status', 'overdue')->count();
                        $totalCount = $activities->count();
                    @endphp

                    <div class="p-4 border border-gray-200 rounded-lg bg-gray-50">
                        <p class="text-sm font-medium text-gray-500">Total Activities</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalCount }}</p>
                    </div>

                    <div class="p-4 border border-blue-200 rounded-lg bg-blue-50">
                        <p class="text-sm font-medium text-blue-700">In Progress</p>
                        <p class="mt-1 text-3xl font-semibold text-blue-900">{{ $inProgressCount }}</p>
                    </div>

                    <div class="p-4 border border-green-200 rounded-lg bg-green-50">
                        <p class="text-sm font-medium text-green-700">Completed</p>
                        <p class="mt-1 text-3xl font-semibold text-green-900">{{ $completedCount }}</p>
                    </div>

                    <div class="p-4 border border-red-200 rounded-lg bg-red-50">
                        <p class="text-sm font-medium text-red-700">Overdue</p>
                        <p class="mt-1 text-3xl font-semibold text-red-900">{{ $overdueCount }}</p>
                    </div>
                </div>

                <!-- Activity Diaries Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Purpose</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Due Date</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Status</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Prepared By</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                    Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($activities as $activity)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">{{ Str::limit($activity->purpose, 50) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $activity->due_date ? $activity->due_date->format('d/m/Y') : '-' }}
                                        </div>
                                        @if ($activity->hasExtensions())
                                            <div class="mt-1 text-xs text-indigo-600">Has extensions</div>
                                        @endif
                                    </td>
                                    @php
                                        $statusColors = [
                                            'Completed' => 'bg-green-100 text-green-800',
                                            'Overdue' => 'bg-red-100 text-red-800',
                                            'In progress' => 'bg-blue-100 text-blue-800',
                                            'Compiled' => 'bg-purple-100 text-purple-800',
                                            'Notification' => 'bg-orange-100 text-orange-800',
                                            'Passed' => 'bg-teal-100 text-teal-800',
                                            'Draft' => 'bg-gray-100 text-gray-800',
                                            'Active' => 'bg-emerald-100 text-emerald-800',
                                            'Rejected' => 'bg-rose-100 text-rose-800',
                                            'Pending' => 'bg-yellow-100 text-yellow-800',
                                        ];

                                        $status = $activity->status ?? 'Pending';
                                        $statusClass = $statusColors[$status] ?? 'bg-yellow-100 text-yellow-800';
                                    @endphp

                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst(str_replace('_', ' ', $status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $activity->prepared_by }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('activity-diary-a.show', $activity) }}"
                                                class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center">
                                        <div class="text-sm text-gray-500">No activity diaries found for this issuer
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Links -->
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $activities->links() }}
                </div>

                <!-- Back Button -->
                <div class="px-4 py-4 border-t border-gray-200 bg-gray-50 sm:px-6">
                    <div class="flex justify-start">
                        <a href="{{ route('activity-diary-a.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z" />
                            </svg>
                            Back to All Activities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
