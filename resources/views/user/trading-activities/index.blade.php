<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trading Activities List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
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

            <div class="bg-white shadow rounded-lg p-6">
                <!-- Search and Create Header -->
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                    <form method="GET" action="{{ route('trading-activities-info.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search by date or bond code..." 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('trading-activities-info.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                    
                    <a href="{{ route('trading-activities-info.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Activity
                    </a>
                </div>

                <!-- Table Container -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider">Bond</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Trade Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Input Time</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Amount (RM'mil)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Price</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-right">Yield (%)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Value Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase tracking-wider text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($activities as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="font-medium text-indigo-600">{{ $activity->bond->bond_sukuk_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $activity->bond->sub_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900">{{ $activity->trade_date->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900">{{ $activity->input_time->format('h:i:s A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm text-gray-900">{{ number_format($activity->amount, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm text-gray-900">{{ number_format($activity->price, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <div class="text-sm text-gray-900">{{ number_format($activity->yield, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-center">
                                        <div class="text-sm text-gray-900">{{ $activity->value_date->format('d/m/Y') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap space-x-2 text-center">
                                        <a href="{{ route('trading-activities-info.show', $activity) }}" 
                                            class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('trading-activities-info.edit', $activity) }}" 
                                            class="px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('trading-activities-info.destroy', $activity) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                class="px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors"
                                                onclick="return confirm('Delete this trading activity?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center text-gray-500">
                                        No trading activities found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($activities->hasPages())
                    <div class="mt-6">
                        {{ $activities->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>