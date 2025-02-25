<!-- resources/views/properties/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $property->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('units.create', ['property_id' => $property->id]) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Add Unit
                </a>
                <a href="{{ route('maintenance-records.create', ['property_id' => $property->id]) }}" 
                    class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                    Create Maintenance
                </a>
                <a href="{{ route('properties.edit', $property) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Property
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
            
            <!-- Property Overview -->
            <div class="mb-6 flex items-center overflow-hidden">
                <div class="bg-white shadow-sm sm:rounded-lg p-6 flex-1">
                    <div class="flex flex-col md:flex-row md:items-center">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $property->address }}</h3>
                            <p class="text-gray-500">{{ $property->city }}, {{ $property->state }} {{ $property->postal_code }}</p>
                            <p class="text-gray-500">Added to Portfolio: {{ $property->acquisition_date->format('M d, Y') }}</p>
                        </div>
                        <div class="mt-4 md:mt-0 md:ml-6 flex flex-col md:items-end">
                            <span class="px-2 py-1 text-xs rounded-full 
                                @if($property->status === 'Active') bg-green-100 text-green-800
                                @elseif($property->status === 'Under Renovation') bg-yellow-100 text-yellow-800
                                @else bg-blue-100 text-blue-800 @endif inline-block mb-2">
                                {{ $property->status }}
                            </span>
                            <p class="text-gray-500">Portfolio: <a href="{{ route('portfolios.show', $property->portfolio) }}" class="text-blue-600 hover:text-blue-900">{{ $property->portfolio->name }}</a></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Property Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Units</div>
                        <div class="text-2xl font-bold">{{ $vacancyData['total_units'] }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Occupancy Rate</div>
                        <div class="text-2xl font-bold">{{ $property->occupancy_rate }}%</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Monthly Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($financialData['monthly_revenue']) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Current Value</div>
                        <div class="text-2xl font-bold">${{ number_format($property->current_value) }}</div>
                    </div>
                </div>
            </div>

            <!-- Property Details and Financial Info -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Property Details -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Property Details</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-sm text-gray-500">Property Type</div>
                            <div>{{ $property->property_type }}</div>
                            
                            <div class="text-sm text-gray-500">Year Built</div>
                            <div>{{ $property->year_built }}</div>
                            
                            <div class="text-sm text-gray-500">Building Class</div>
                            <div>{{ $property->building_class }}</div>
                            
                            <div class="text-sm text-gray-500">Square Footage</div>
                            <div>{{ number_format($property->square_footage) }} sq ft</div>
                            
                            <div class="text-sm text-gray-500">Land Area</div>
                            <div>{{ number_format($property->land_area) }} sq ft</div>
                            
                            <div class="text-sm text-gray-500">Number of Floors</div>
                            <div>{{ $property->number_of_floors }}</div>
                            
                            <div class="text-sm text-gray-500">Parking Spaces</div>
                            <div>{{ $property->parking_spaces }}</div>
                            
                            <div class="text-sm text-gray-500">Zoning Type</div>
                            <div>{{ $property->zoning_type }}</div>
                            
                            <div class="text-sm text-gray-500">Last Renovation</div>
                            <div>{{ $property->last_renovation_date ? $property->last_renovation_date->format('M d, Y') : 'N/A' }}</div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="text-sm text-gray-500">Property Manager</div>
                            <div>{{ $property->property_manager }}</div>
                        </div>
                    </div>
                </div>
                
                <!-- Financial Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-semibold">Financial Information</h3>
                            <a href="{{ route('properties.financial-report', $property) }}" class="text-blue-600 hover:text-blue-900 text-sm">View Full Report</a>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-sm text-gray-500">Purchase Price</div>
                            <div>${{ number_format($property->purchase_price) }}</div>
                            
                            <div class="text-sm text-gray-500">Current Value</div>
                            <div>${{ number_format($property->current_value) }}</div>
                            
                            <div class="text-sm text-gray-500">Expected ROI</div>
                            <div>{{ number_format($property->expected_roi, 2) }}%</div>
                            
                            <div class="text-sm text-gray-500">Monthly Revenue</div>
                            <div>${{ number_format($financialData['monthly_revenue']) }}</div>
                            
                            <div class="text-sm text-gray-500">Monthly Expenses</div>
                            <div>${{ number_format($financialData['monthly_expenses']) }}</div>
                            
                            <div class="text-sm text-gray-500">Monthly NOI</div>
                            <div>${{ number_format($financialData['monthly_noi']) }}</div>
                            
                            <div class="text-sm text-gray-500">Annual NOI</div>
                            <div>${{ number_format($financialData['annual_noi']) }}</div>
                            
                            <div class="text-sm text-gray-500">Cap Rate</div>
                            <div>{{ number_format($financialData['cap_rate'], 2) }}%</div>
                            
                            <div class="text-sm text-gray-500">ROI</div>
                            <div>{{ number_format($financialData['roi'], 2) }}%</div>
                        </div>
                        
                        <div class="mt-4">
                            <div class="text-sm text-gray-500">Property Tax</div>
                            <div>${{ number_format($property->annual_property_tax) }}/year</div>
                            
                            <div class="text-sm text-gray-500 mt-2">Insurance Cost</div>
                            <div>${{ number_format($property->insurance_cost) }}/year</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Vacancy Overview -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Vacancy Overview</h3>
                        <a href="{{ route('properties.vacancy-report', $property) }}" class="text-blue-600 hover:text-blue-900 text-sm">View Full Report</a>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-500">Total Units</div>
                            <div class="text-2xl font-bold">{{ $vacancyData['total_units'] }}</div>
                        </div>
                        
                        <div class="bg-green-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-500">Occupied Units</div>
                            <div class="text-2xl font-bold text-green-700">{{ $vacancyData['occupied_units'] }}</div>
                        </div>
                        
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-500">Vacant Units</div>
                            <div class="text-2xl font-bold text-blue-700">{{ $vacancyData['vacant_units'] }}</div>
                        </div>
                        
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <div class="text-sm text-gray-500">Under Maintenance</div>
                            <div class="text-2xl font-bold text-yellow-700">{{ $vacancyData['under_maintenance'] }}</div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h4 class="text-md font-medium mb-2">Occupancy Trend</h4>
                        <div class="w-full bg-gray-200 rounded-full h-4">
                            <div class="bg-blue-600 h-4 rounded-full" style="width: {{ $property->occupancy_rate }}%"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500 mt-1">
                            <span>0%</span>
                            <span>25%</span>
                            <span>50%</span>
                            <span>75%</span>
                            <span>100%</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Units Tab -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Units</h3>
                        <a href="{{ route('units.create', ['property_id' => $property->id]) }}" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Add Unit
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beds/Baths</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($property->units as $unit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('units.show', $unit) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $unit->unit_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $unit->unit_type }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $unit->bedrooms }}/{{ $unit->bathrooms }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ number_format($unit->square_footage) }} sq ft</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($unit->base_rent, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($unit->status === 'Occupied') bg-green-100 text-green-800
                                            @elseif($unit->status === 'Available') bg-blue-100 text-blue-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $unit->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($unit->currentTenant)
                                            <a href="{{ route('tenants.show', $unit->currentTenant) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $unit->currentTenant->first_name }} {{ $unit->currentTenant->last_name }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('units.edit', $unit) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="{{ route('units.show', $unit) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-center">No units found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Maintenance Records Tab -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Recent Maintenance</h3>
                        <a href="{{ route('maintenance-records.create', ['property_id' => $property->id]) }}" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Create Maintenance Request
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported On</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Cost</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($property->maintenanceRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('maintenance.show', $record) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $record->request_type }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($record->unit)
                                            <a href="{{ route('units.show', $record->unit) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $record->unit->unit_number }}
                                            </a>
                                        @else
                                            <span class="text-gray-500">Property-wide</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($record->priority === 'Emergency') bg-red-100 text-red-800
                                            @elseif($record->priority === 'High') bg-orange-100 text-orange-800
                                            @elseif($record->priority === 'Medium') bg-yellow-100 text-yellow-800
                                            @else bg-green-100 text-green-800 @endif">
                                            {{ $record->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($record->status === 'Pending') bg-yellow-100 text-yellow-800
                                            @elseif($record->status === 'In Progress') bg-blue-100 text-blue-800
                                            @elseif($record->status === 'Completed') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($record->estimated_cost, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('maintenance.show', $record) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        
                                        @if($record->status !== 'Completed' && $record->status !== 'Cancelled')
                                            <a href="{{ route('maintenance.edit', $record) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No maintenance records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if(count($property->maintenanceRecords) > 5)
                        <div class="mt-4 text-center">
                            <a href="{{ route('maintenance.index', ['property_id' => $property->id]) }}" 
                                class="text-blue-600 hover:text-blue-900">
                                View All Maintenance Records
                            </a>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Export Options -->
            <div class="mt-6 flex justify-end space-x-4">
                <a href="{{ route('properties.export', $property) }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Export Property Data
                </a>
                <a href="{{ route('properties.financial-report', $property) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Financial Report
                </a>
                <a href="{{ route('properties.vacancy-report', $property) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Vacancy Report
                </a>
            </div>
        </div>
    </div>
</x-app-layout>