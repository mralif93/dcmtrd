<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Redemptions List') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4">
                    <div class="bg-green-500 text-white p-4 rounded-lg">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <!-- Search and Create Header -->
                <div class="flex flex-col sm:flex-row justify-between gap-4 mb-6">
                    <form method="GET" action="{{ route('redemptions.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search by bond code or date..." 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('redemptions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                    
                    <a href="{{ route('redemptions.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Redemption
                    </a>
                </div>

                <!-- Table Container -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bond Information</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Partial Call</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Last Call Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Redemption Option</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($redemptions as $redemption)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-indigo-600">{{ $redemption->bondInfo->isin_code }}</div>
                                        <div class="text-sm text-gray-500">{{ $redemption->bondInfo->stock_code }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            {{ $redemption->allow_partial_call ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $redemption->allow_partial_call ? 'Allowed' : 'Not Allowed' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            {{ $redemption->last_call_date->format('d/m/Y') }}
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 rounded-full text-xs 
                                            {{ $redemption->redeem_nearest_denomination ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $redemption->redeem_nearest_denomination ? 'Nearest Denomination' : 'Standard' }}
                                        </span>
                                    </td>
                                    
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('redemptions.show', $redemption) }}" 
                                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('redemptions.edit', $redemption) }}" 
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('redemptions.destroy', $redemption) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors"
                                                    onclick="return confirm('Delete this redemption configuration?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No redemption configurations found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($redemptions->hasPages())
                    <div class="mt-6">
                        {{ $redemptions->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>