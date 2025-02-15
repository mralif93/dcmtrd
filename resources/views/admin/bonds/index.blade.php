<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bonds List') }}
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
                    <form method="GET" action="{{ route('bonds.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search bond name, rating, or facility code..." 
                                class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('bonds.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                    
                    <a href="{{ route('bonds.create') }}" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                        </svg>
                        New Bond
                    </a>
                </div>

                <!-- Table Container -->
                <div class="border rounded-lg overflow-hidden">
                    <table class="w-full text-sm text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Bond Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Details</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Trading Info</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @forelse($bonds as $bond)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-indigo-600">{{ $bond->bond_sukuk_name }}</div>
                                        <div class="text-sm text-gray-500">{{ $bond->sub_name }}</div>
                                        <div class="text-xs text-gray-400 mt-1">{{ $bond->facility_code }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-medium">{{ $bond->category }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $bond->rating }}
                                            <span class="ml-2 px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">{{ $bond->residual_tenure }} yrs</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div>Price: RM {{ number_format($bond->last_traded_price, 2) }}</div>
                                            <div>Yield: {{ $bond->last_traded_yield }}%</div>
                                            <div class="text-gray-500 text-xs mt-1">
                                                {{ $bond->last_traded_date?->format('d M Y') ?? 'N/A' }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-1 rounded-full text-xs 
                                                {{ $bond->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ ucfirst($bond->status) }}
                                            </span>
                                            <div class="text-xs text-gray-500">
                                                O/S: RM {{ number_format($bond->o_s_amount, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('bonds.show', $bond) }}" 
                                        class="px-3 py-1 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                            View
                                        </a>
                                        <a href="{{ route('bonds.edit', $bond) }}" 
                                        class="px-3 py-1 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                            Edit
                                        </a>
                                        <form action="{{ route('bonds.destroy', $bond) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors"
                                                    onclick="return confirm('Delete {{ $bond->bond_sukuk_name }}?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No bonds found {{ $searchTerm ? 'matching your search' : '' }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if($bonds->hasPages())
                    <div class="mt-6">
                        {{ $bonds->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>