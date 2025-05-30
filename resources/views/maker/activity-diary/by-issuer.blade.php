<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Activities for') }}: {{ $issuer->issuer_name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Issuer Information Card -->
                <div class="px-4 py-5 sm:px-6 bg-gray-50">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <div>
                            <h3 class="text-lg leading-6 font-medium text-gray-900">{{ $issuer->issuer_name }}</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">{{ $issuer->issuer_short_name }}</p>
                        </div>
                        <div class="mt-4 md:mt-0">
                            <a href="{{ route('activity-diary-m.create') }}?issuer_id={{ $issuer->id }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                                New Activity for {{ $issuer->issuer_short_name }}
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('activity-diary-m.by-issuer', $issuer->id) }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <!-- Status Filter -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Filter Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Search
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Statistics Summary -->
                <div class="px-4 py-5 sm:px-6 grid grid-cols-1 md:grid-cols-4 gap-4">
                    @php
                        $pendingCount = $activities->where('status', 'pending')->count();
                        $inProgressCount = $activities->where('status', 'in_progress')->count();
                        $completedCount = $activities->where('status', 'completed')->count();
                        $overdueCount = $activities->where('status', 'overdue')->count();
                        $totalCount = $activities->count();
                    @endphp
                    
                    <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                        <p class="text-sm font-medium text-gray-500">Total Activities</p>
                        <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $totalCount }}</p>
                    </div>
                    
                    <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                        <p class="text-sm font-medium text-blue-700">In Progress</p>
                        <p class="mt-1 text-3xl font-semibold text-blue-900">{{ $inProgressCount }}</p>
                    </div>
                    
                    <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                        <p class="text-sm font-medium text-green-700">Completed</p>
                        <p class="mt-1 text-3xl font-semibold text-green-900">{{ $completedCount }}</p>
                    </div>
                    
                    <div class="bg-red-50 rounded-lg p-4 border border-red-200">
                        <p class="text-sm font-medium text-red-700">Overdue</p>
                        <p class="mt-1 text-3xl font-semibold text-red-900">{{ $overdueCount }}</p>
                    </div>
                </div>

                <!-- Activity Diaries Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Purpose</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Due Date</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prepared By</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($activities as $activity)
                            <tr>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">{{ Str::limit($activity->purpose, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity->due_date ? $activity->due_date->format('d/m/Y') : '-' }}</div>
                                    @if($activity->hasExtensions())
                                        <div class="text-xs text-indigo-600 mt-1">Has extensions</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                        $activity->status == 'completed' ? 'bg-green-100 text-green-800' : 
                                        ($activity->status == 'overdue' ? 'bg-red-100 text-red-800' : 
                                        ($activity->status == 'in_progress' ? 'bg-blue-100 text-blue-800' : 
                                        ($activity->status == 'compiled' ? 'bg-purple-100 text-purple-800' : 
                                        ($activity->status == 'notification' ? 'bg-orange-100 text-orange-800' : 
                                        ($activity->status == 'passed' ? 'bg-teal-100 text-teal-800' : 'bg-yellow-100 text-yellow-800'))))) 
                                    }}">
                                        {{ ucfirst(str_replace('_', ' ', $activity->status ?? 'pending')) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $activity->prepared_by }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('activity-diary-m.show', $activity) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('activity-diary-m.edit', $activity) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </a>
                                        @if($activity->status != 'completed')
                                        <form action="{{ route('activity-diary-m.update-status', $activity) }}" method="POST" class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <input type="hidden" name="status" value="completed">
                                            <button type="submit" onclick="return confirm('Mark this activity as completed?');" class="text-green-600 hover:text-green-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No activity diaries found for this issuer</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $activities->links() }}
                </div>

                <!-- Back Button -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <div class="flex justify-start">
                        <a href="{{ route('activity-diary-m.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to All Activities
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>