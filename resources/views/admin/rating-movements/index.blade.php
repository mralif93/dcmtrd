<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Rating Movements List') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('rating-movements.create') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                    Create Rating Movement
                </a>
                <a href="{{ route('upload.rating-movement') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded-lg hover:bg-green-700">
                    Upload Rating Movements
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
                    <form method="GET" action="{{ route('rating-movements.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search by agency, rating, or action..." 
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('rating-movements.index') }}" class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
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
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Rating Agency</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Rating Details</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions & Outlook</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Effective Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($ratingMovements as $movement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-indigo-600">{{ $movement->rating_agency }}</div>
                                        <div class="text-sm text-gray-500">{{ $movement->rating_tenure }} months</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ str_starts_with($movement->rating, 'A') ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $movement->rating }}
                                            </span>
                                            <div class="text-sm text-gray-500">
                                                {{ $movement->rating_action }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div class="flex items-center gap-2">
                                                <span class="px-2 py-1 text-xs rounded-full 
                                                    {{ $movement->rating_outlook === 'Positive' ? 'bg-blue-100 text-blue-800' : 
                                                    ($movement->rating_outlook === 'Negative' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                                                    {{ $movement->rating_outlook }}
                                                </span>
                                                @if($movement->rating_watch)
                                                <span class="px-2 py-1 text-xs text-yellow-800 bg-yellow-100 rounded-full">
                                                    Watch: {{ $movement->rating_watch }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $movement->effective_date->format('d M Y') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('rating-movements.show', $movement) }}" 
                                        class="px-3 py-1 text-blue-800 transition-colors bg-blue-100 rounded-md hover:bg-blue-200">
                                            View
                                        </a>
                                        <a href="{{ route('rating-movements.edit', $movement) }}" 
                                        class="px-3 py-1 text-green-800 transition-colors bg-green-100 rounded-md hover:bg-green-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('rating-movements.destroy', $movement) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 text-red-800 transition-colors bg-red-100 rounded-md hover:bg-red-200"
                                                    onclick="return confirm('Delete this rating movement?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No rating movements found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($ratingMovements->hasPages())
                    <div class="mt-6">
                        {{ $ratingMovements->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>