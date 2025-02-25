<!-- resources/views/portfolios/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Portfolio Management') }}
            </h2>
            <a href="{{ route('portfolios.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Add Portfolio
            </a>
        </div>
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

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('portfolios.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/3">
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                class="mt-1 block w-full rounded-md border-gray-300" placeholder="Search portfolios...">
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                            <select name="type" id="type" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">All Types</option>
                                <option value="Residential" {{ request('type') == 'Residential' ? 'selected' : '' }}>Residential</option>
                                <option value="Commercial" {{ request('type') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                <option value="Mixed-Use" {{ request('type') == 'Mixed-Use' ? 'selected' : '' }}>Mixed-Use</option>
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/4">
                            <label for="risk_profile" class="block text-sm font-medium text-gray-700">Risk Profile</label>
                            <select name="risk_profile" id="risk_profile" class="mt-1 block w-full rounded-md border-gray-300">
                                <option value="">All Risk Profiles</option>
                                <option value="Low" {{ request('risk_profile') == 'Low' ? 'selected' : '' }}>Low</option>
                                <option value="Medium" {{ request('risk_profile') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                <option value="High" {{ request('risk_profile') == 'High' ? 'selected' : '' }}>High</option>
                            </select>
                        </div>
                        
                        <div class="w-full md:w-1/6 flex items-end">
                            <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Portfolios</div>
                        <div class="text-2xl font-bold">{{ $portfolios->total() }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Properties</div>
                        <div class="text-2xl font-bold">{{ $totalProperties }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Asset Value</div>
                        <div class="text-2xl font-bold">${{ number_format($totalAssetValue) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Average Occupancy</div>
                        <div class="text-2xl font-bold">{{ number_format($averageOccupancy, 1) }}%</div>
                    </div>
                </div>
            </div>

            <!-- Portfolios List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Properties</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Risk Profile</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target Return</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($portfolios as $portfolio)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('portfolios.show', $portfolio) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $portfolio->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $portfolio->type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $portfolio->properties_count }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($portfolio->total_assets) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($portfolio->risk_profile === 'Low') bg-green-100 text-green-800
                                            @elseif($portfolio->risk_profile === 'Medium') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $portfolio->risk_profile }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $portfolio->target_return }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('portfolios.edit', $portfolio) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="{{ route('portfolios.show', $portfolio) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <form action="{{ route('portfolios.destroy', $portfolio) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Are you sure you want to delete this portfolio?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No portfolios found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $portfolios->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>