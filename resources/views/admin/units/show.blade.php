<!-- resources/views/units/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Unit {{ $unit->unit_number }} - {{ $unit->property->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('leases.create', ['unit_id' => $unit->id]) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    New Lease
                </a>
                <a href="{{ route('units.edit', $unit) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Unit
                </a>
                <a href="{{ route('properties.show', $unit->property) }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Property
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

            <!-- Unit Status Summary -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Current Status</div>
                        <div class="text-2xl font-bold">
                            <span class="px-2 py-1 text-sm rounded-full 
                                @if($unit->currentLease) bg-green-100 text-green-800 @else bg-yellow-100 text-yellow-800 @endif">
                                {{ $unit->currentLease ? 'Occupied' : 'Vacant' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Base Rent</div>
                        <div class="text-2xl font-bold">${{ number_format($unit->base_rent, 2) }}/month</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Size</div>
                        <div class="text-2xl font-bold">{{ number_format($unit->square_footage) }} sq ft</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Type</div>
                        <div class="text-2xl font-bold">{{ $unit->type }}</div>
                    </div>
                </div>
            </div>

            <!-- Unit Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Unit Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Unit Number</div>
                                <div>{{ $unit->unit_number }}</div>
                                
                                <div class="text-sm text-gray-500">Floor</div>
                                <div>{{ $unit->floor }}</div>
                                
                                <div class="text-sm text-gray-500">Bedrooms</div>
                                <div>{{ $unit->bedrooms }}</div>
                                
                                <div class="text-sm text-gray-500">Bathrooms</div>
                                <div>{{ $unit->bathrooms }}</div>
                                
                                <div class="text-sm text-gray-500">Square Footage</div>
                                <div>{{ number_format($unit->square_footage) }} sq ft</div>
                                
                                <div class="text-sm text-gray-500">Ceiling Height</div>
                                <div>{{ $unit->ceiling_height }} ft</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Base Rent</div>
                                <div>${{ number_format($unit->base_rent, 2) }}</div>
                                
                                <div class="text-sm text-gray-500">Utility Cost</div>
                                <div>${{ number_format($unit->utility_cost, 2) }}</div>
                                
                                <div class="text-sm text-gray-500">Furnished</div>
                                <div>{{ $unit->furnished ? 'Yes' : 'No' }}</div>
                                
                                <div class="text-sm text-gray-500">Pets Allowed</div>
                                <div>{{ $unit->pets_allowed ? 'Yes' : 'No' }}</div>
                                
                                <div class="text-sm text-gray-500">Washer/Dryer</div>
                                <div>{{ $unit->washer_dryer ? 'Yes' : 'No' }}</div>
                                
                                <div class="text-sm text-gray-500">Parking Included</div>
                                <div>{{ $unit->parking_included ? 'Yes' : 'No' }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($unit->appliances_included)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500 mb-2">Appliances Included</div>
                        <div class="flex flex-wrap gap-2">
                            @foreach($unit->appliances_included as $appliance)
                                <span class="bg-gray-100 px-2 py-1 rounded">{{ $appliance }}</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-6">
                        <div class="text-sm text-gray-500">Last Renovation</div>
                        <div>{{ $unit->last_renovation ? $unit->last_renovation->format('M d, Y') : 'Not available' }}</div>
                    </div>
                </div>
            </div>

            <!-- Current Tenant Information (if any) -->
            @if($unit->currentTenant)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Current Tenant</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Name</div>
                                <div>
                                    <a href="{{ route('tenants.show', $unit->currentTenant) }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $unit->currentTenant->first_name }} {{ $unit->currentTenant->last_name }}
                                    </a>
                                </div>
                                
                                <div class="text-sm text-gray-500">Email</div>
                                <div>{{ $unit->currentTenant->email }}</div>
                                
                                <div class="text-sm text-gray-500">Phone</div>
                                <div>{{ $unit->currentTenant->phone }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Lease Start</div>
                                <div>{{ $unit->currentLease->start_date->format('M d, Y') }}</div>
                                
                                <div class="text-sm text-gray-500">Lease End</div>
                                <div>{{ $unit->currentLease->end_date->format('M d, Y') }}</div>
                                
                                <div class="text-sm text-gray-500">Monthly Rent</div>
                                <div>${{ number_format($unit->currentLease->monthly_rent, 2) }}</div>
                                
                                <div class="text-sm text-gray-500">Remaining</div>
                                <div>{{ now()->diffInDays($unit->currentLease->end_date) }} days</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4 flex justify-end">
                        <a href="{{ route('leases.show', $unit->currentLease) }}" 
                            class="text-blue-600 hover:text-blue-900">
                            View Lease Details
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <!-- Lease History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Lease History</h3>
                        <a href="{{ route('leases.create', ['unit_id' => $unit->id]) }}" 
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            New Lease
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Rent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($unit->leases as $lease)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('tenants.show', $lease->tenant) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $lease->tenant->first_name }} {{ $lease->tenant->last_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lease->start_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $lease->end_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($lease->monthly_rent, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($lease->status === 'active') bg-green-100 text-green-800
                                            @elseif($lease->status === 'upcoming') bg-blue-100 text-blue-800
                                            @elseif($lease->status === 'expired') bg-gray-100 text-gray-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($lease->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('leases.show', $lease) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <a href="{{ route('leases.edit', $lease) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">No lease history found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Maintenance Records -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Maintenance History</h3>
                        <a href="{{ route('maintenance-records.create', ['unit_id' => $unit->id]) }}" 
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">
                            New Maintenance Request
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($unit->maintenanceRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->issue_type }}</td>
                                    <td class="px-6 py-4">
                                        <div class="truncate max-w-xs">{{ $record->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($record->status === 'Completed') bg-green-100 text-green-800
                                            @elseif($record->status === 'In Progress') bg-yellow-100 text-yellow-800
                                            @elseif($record->status === 'Scheduled') bg-blue-100 text-blue-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $record->completion_date ? $record->completion_date->format('M d, Y') : 'Pending' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        ${{ $record->actual_cost ? number_format($record->actual_cost, 2) : number_format($record->estimated_cost, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('maintenance-records.show', $record) }}" class="text-blue-600 hover:text-blue-900">View</a>
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
                </div>
            </div>

            <!-- Site Visits / Showings -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Site Visits</h3>
                        <a href="{{ route('site-visits.create', ['unit_id' => $unit->id]) }}" 
                            class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                            Schedule Visit
                        </a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Visitor</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Contact</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Interested</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Follow-up</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($unit->siteVisits as $visit)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->visit_date->format('M d, Y g:i A') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($visit->tenant_id)
                                            <a href="{{ route('tenants.show', $visit->tenant) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $visit->tenant->first_name }} {{ $visit->tenant->last_name }}
                                            </a>
                                        @else
                                            {{ $visit->visitor_name }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $visit->visitor_email ?? $visit->visitor_phone }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            {{ $visit->interested ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ $visit->interested ? 'Yes' : 'No' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($visit->status === 'Completed') bg-green-100 text-green-800
                                            @elseif($visit->status === 'Scheduled') bg-blue-100 text-blue-800
                                            @elseif($visit->status === 'Cancelled') bg-red-100 text-red-800
                                            @else bg-yellow-100 text-yellow-800 @endif">
                                            {{ $visit->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($visit->follow_up_required)
                                            {{ $visit->follow_up_date ? $visit->follow_up_date->format('M d, Y') : 'Required' }}
                                        @else
                                            None
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('site-visits.show', $visit) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No site visits found</td>
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