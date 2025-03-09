<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Trading Activities List') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('trading-activities.create') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                    Create Trading Activity
                </a>
                <a href="{{ route('upload.trading-activity') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded-lg hover:bg-green-700">
                    Upload Trading Activity
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6 bg-white rounded-lg shadow">
                <!-- Search and Create Header -->
                <div class="flex flex-col justify-between gap-4 mb-6 sm:flex-row">
                    <form method="GET" action="{{ route('trading-activities.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search by date or bond code..." 
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('trading-activities.index') }}" class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Table Container -->
                <div class="overflow-hidden border rounded-lg">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bond</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Trade Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Input Time</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Amount (RM'mil)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Price</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Yield (%)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Value Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($activities as $activity)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-indigo-600">{{ $activity->bond->bond_sukuk_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $activity->bond->sub_name }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ $activity->trade_date->format('d/m/Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ $activity->input_time->format('h:i A') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ number_format($activity->amount, 2) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ number_format($activity->price, 2) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ number_format($activity->yield, 2) }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <div>{{ $activity->value_date->format('d/m/Y') }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('trading-activities.show', $activity) }}" 
                                        class="px-3 py-1 text-blue-800 transition-colors bg-blue-100 rounded-md hover:bg-blue-200">
                                            View
                                        </a>
                                        <a href="{{ route('trading-activities.edit', $activity) }}" 
                                        class="px-3 py-1 text-green-800 transition-colors bg-green-100 rounded-md hover:bg-green-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('trading-activities.destroy', $activity) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 text-red-800 transition-colors bg-red-100 rounded-md hover:bg-red-200"
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