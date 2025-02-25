<!-- resources/views/portfolios/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $portfolio->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('properties.create', ['portfolio_id' => $portfolio->id]) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Property
                </a>
                <a href="{{ route('portfolios.edit', $portfolio) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Portfolio
                </a>
            </div>
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

            <!-- Portfolio Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Properties</div>
                        <div class="text-2xl font-bold">{{ $portfolio->properties_count ?? $portfolio->properties->count() }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Units</div>
                        <div class="text-2xl font-bold">{{ $totalUnits }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Occupancy Rate</div>
                        <div class="text-2xl font-bold">{{ number_format($occupancyRate, 1) }}%</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Monthly Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($monthlyRevenue) }}</div>
                    </div>
                </div>
            </div>

            <!-- Portfolio Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Portfolio Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Portfolio Type</div>
                                <div>{{ $portfolio->type }}</div>
                                
                                <div class="text-sm text-gray-500">Foundation Date</div>
                                <div>{{ $portfolio->foundation_date->format('M d, Y') }}</div>
                                
                                <div class="text-sm text-gray-500">Total Assets</div>
                                <div>${{ number_format($portfolio->total_assets) }}</div>
                                
                                <div class="text-sm text-gray-500">Market Cap</div>
                                <div>${{ number_format($portfolio->market_cap) }}</div>
                                
                                <div class="text-sm text-gray-500">Available Funds</div>
                                <div>${{ number_format($portfolio->available_funds) }}</div>
                                
                                <div class="text-sm text-gray-500">Risk Profile</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        @if($portfolio->risk_profile === 'Low') bg-green-100 text-green-800
                                        @elseif($portfolio->risk_profile === 'Medium') bg-yellow-100 text-yellow-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ $portfolio->risk_profile }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Management Company</div>
                                <div>{{ $portfolio->management_company }}</div>
                                
                                <div class="text-sm text-gray-500">Portfolio Manager</div>
                                <div>{{ $portfolio->portfolio_manager }}</div>
                                
                                <div class="text-sm text-gray-500">Legal Entity Type</div>
                                <div>{{ $portfolio->legal_entity_type }}</div>
                                
                                <div class="text-sm text-gray-500">Currency</div>
                                <div>{{ $portfolio->currency }}</div>
                                
                                <div class="text-sm text-gray-500">Investment Strategy</div>
                                <div>{{ $portfolio->investment_strategy }}</div>
                                
                                <div class="text-sm text-gray-500">Target Return</div>
                                <div>{{ $portfolio->target_return }}%</div>
                                
                                <div class="text-sm text-gray-500">Status</div>
                                <div>
                                    <span class="px-2 py-1 text-xs rounded-full 
                                        {{ $portfolio->active_status ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $portfolio->active_status ? 'Active' : 'Inactive' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Description</div>
                        <div class="mt-1">{{ $portfolio->description }}</div>
                    </div>
                </div>
            </div>

            <!-- Properties List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Properties</h3>
                        <a href="{{ route('properties.create', ['portfolio_id' => $portfolio->id]) }}" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add Property
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occupancy</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($portfolio->properties as $property)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $property->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $property->address }}, {{ $property->city }}, {{ $property->state }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $property->property_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $property->units_count ?? $property->units->count() }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-16 bg-gray-200 rounded-full h-2.5">
                                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $property->occupancy_rate }}%"></div>
                                            </div>
                                            <span class="ml-2">{{ $property->occupancy_rate }}%</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($property->current_value) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($property->status === 'Active') bg-green-100 text-green-800
                                            @elseif($property->status === 'Under Renovation') bg-yellow-100 text-yellow-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ $property->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('properties.edit', $property) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="{{ route('properties.show', $property) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center">No properties found in this portfolio</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Financial Reports -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Financial Reports</h3>
                        <a href="{{ route('portfolios.analytics', $portfolio) }}" 
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            View Analytics
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Period</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Revenue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Expenses</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Net Income</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occupancy Rate</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($portfolio->financialReports ?? [] as $report)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->fiscal_period }} ({{ $report->report_date->format('M Y') }})</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->report_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->total_revenue) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->operating_expenses) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($report->net_income) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $report->occupancy_rate }}%</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="#" class="text-blue-600 hover:text-blue-900">View Details</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No financial reports found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>