<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Bonds List') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('bonds.create') }}" class="px-4 py-2 font-bold text-white bg-blue-500 rounded-lg hover:bg-blue-700">
                    Create Bond
                </a>
                <a href="{{ route('upload.bond') }}" class="px-4 py-2 font-bold text-white bg-green-500 rounded-lg hover:bg-green-700">
                    Upload Bonds
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
                    <form method="GET" action="{{ route('bonds.index') }}" class="w-full sm:w-1/2">
                        <div class="flex gap-2">
                            <input type="text" 
                                name="search" 
                                value="{{ $searchTerm }}"
                                placeholder="Search bond name, rating, or facility code..." 
                                class="w-full border-gray-300 rounded-lg focus:border-indigo-500 focus:ring-indigo-500">
                            
                            <button type="submit" class="px-4 py-2 text-white transition-colors bg-indigo-600 rounded-lg hover:bg-indigo-700">
                                Search
                            </button>
                            
                            @if($searchTerm)
                                <a href="{{ route('bonds.index') }}" class="px-4 py-2 text-gray-700 transition-colors bg-gray-100 rounded-lg hover:bg-gray-200">
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
                                        <div class="mt-1 text-xs text-gray-400">{{ $bond->facility_code }}</div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="font-medium">{{ $bond->category }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $bond->rating }}
                                            <span class="px-2 py-1 ml-2 text-xs text-blue-800 bg-blue-100 rounded-full">{{ $bond->residual_tenure }} yrs</span>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4">
                                        <div class="text-sm">
                                            <div>Price: RM {{ number_format($bond->last_traded_price, 2) }}</div>
                                            <div>Yield: {{ $bond->last_traded_yield }}%</div>
                                            <div class="mt-1 text-xs text-gray-500">
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
                                                O/S: (RM'mil) {{ number_format($bond->amount_outstanding, 2) }}
                                            </div>
                                        </div>
                                    </td>
                                    
                                    <td class="px-6 py-4 space-x-2">
                                        <a href="{{ route('bonds.show', $bond) }}" 
                                        class="px-3 py-1 text-blue-800 transition-colors bg-blue-100 rounded-md hover:bg-blue-200">
                                            View
                                        </a>
                                        <a href="{{ route('bonds.edit', $bond) }}" 
                                        class="px-3 py-1 text-green-800 transition-colors bg-green-100 rounded-md hover:bg-green-200">
                                            Edit
                                        </a>
                                        <form action="{{ route('bonds.destroy', $bond) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" 
                                                    class="px-3 py-1 text-red-800 transition-colors bg-red-100 rounded-md hover:bg-red-200"
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