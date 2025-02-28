<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $tenant->first_name }} {{ $tenant->last_name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('leases.create', ['tenant_id' => $tenant->id]) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Create Lease
                </a>
                <a href="{{ route('tenants.edit', $tenant) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Tenant
                </a>
                <a href="{{ route('tenants.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Tenants
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

            <!-- Tenant Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-2xl font-bold">
                            <span class="px-2 py-1 text-sm rounded-full 
                                @if($tenant->active_status) bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif">
                                {{ $tenant->active_status ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Current Lease</div>
                        <div class="text-2xl font-bold">
                            @if($tenant->currentLease)
                                <a href="{{ route('leases.show', $tenant->currentLease) }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $tenant->currentLease->unit->property->name }} - Unit {{ $tenant->currentLease->unit->unit_number }}
                                </a>
                            @else
                                <span class="text-yellow-600">No Active Lease</span>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Monthly Rent</div>
                        <div class="text-2xl font-bold">
                            @if($tenant->currentLease)
                                ${{ number_format($tenant->currentLease->monthly_rent, 2) }}
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Lease Ends</div>
                        <div class="text-2xl font-bold">
                            @if($tenant->currentLease)
                                {{ $tenant->currentLease->end_date->format('M d, Y') }}
                                <div class="text-sm font-normal text-gray-500">
                                    {{ $tenant->currentLease->end_date->diffForHumans() }}
                                </div>
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tenant Details -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tenant Details</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Full Name</div>
                                <div>{{ $tenant->first_name }} {{ $tenant->last_name }}</div>
                                
                                <div class="text-sm text-gray-500">Email</div>
                                <div>
                                    <a href="mailto:{{ $tenant->email }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $tenant->email }}
                                    </a>
                                </div>
                                
                                <div class="text-sm text-gray-500">Phone</div>
                                <div>
                                    <a href="tel:{{ $tenant->phone }}" class="text-blue-600 hover:text-blue-900">
                                        {{ $tenant->phone }}
                                    </a>
                                </div>
                                
                                <div class="text-sm text-gray-500">Date of Birth</div>
                                <div>{{ $tenant->date_of_birth ? $tenant->date_of_birth->format('M d, Y') : 'Not provided' }}</div>
                                
                                <div class="text-sm text-gray-500">Age</div>
                                <div>{{ $tenant->date_of_birth ? $tenant->date_of_birth->age . ' years' : 'Not provided' }}</div>
                                
                                <div class="text-sm text-gray-500">Has Pets</div>
                                <div>{{ $tenant->pets ? 'Yes' : 'No' }}</div>
                            </div>
                        </div>
                        
                        <div>
                            <div class="grid grid-cols-2 gap-4">
                                <div class="text-sm text-gray-500">Occupation</div>
                                <div>{{ $tenant->occupation ?? 'Not provided' }}</div>
                                
                                <div class="text-sm text-gray-500">Employer</div>
                                <div>{{ $tenant->employer ?? 'Not provided' }}</div>
                                
                                <div class="text-sm text-gray-500">Employer Phone</div>
                                <div>{{ $tenant->employer_phone ?? 'Not provided' }}</div>
                                
                                <div class="text-sm text-gray-500">Annual Income</div>
                                <div>${{ number_format($tenant->annual_income ?? 0, 2) }}</div>
                                
                                <div class="text-sm text-gray-500">Background Check</div>
                                <div>{{ $tenant->background_check_date ? $tenant->background_check_date->format('M d, Y') : 'Not completed' }}</div>
                                
                                <div class="text-sm text-gray-500">Tenant Since</div>
                                <div>{{ $tenant->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>
                    </div>
                    
                    @if($tenant->notes)
                    <div class="mt-6">
                        <div class="text-sm text-gray-500 mb-2">Notes</div>
                        <div class="p-4 bg-gray-50 rounded">{{ $tenant->notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Emergency Contact</h3>
                    
                    @if($tenant->emergency_contact_name)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">Name</div>
                            <div class="font-medium">{{ $tenant->emergency_contact_name }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Relationship</div>
                            <div class="font-medium">{{ $tenant->emergency_contact_relation ?? 'Not specified' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Phone</div>
                            <div class="font-medium">
                                <a href="tel:{{ $tenant->emergency_contact_phone }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $tenant->emergency_contact_phone }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="text-gray-500 italic">No emergency contact information provided</div>
                    @endif
                </div>
            </div>

            <!-- Vehicle Information -->
            @if(isset($tenant->vehicle_info) && !empty($tenant->vehicle_info))
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Vehicle Information</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-5 gap-6">
                        <div>
                            <div class="text-sm text-gray-500">Make</div>
                            <div class="font-medium">{{ $tenant->vehicle_info['make'] ?? 'N/A' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Model</div>
                            <div class="font-medium">{{ $tenant->vehicle_info['model'] ?? 'N/A' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Year</div>
                            <div class="font-medium">{{ $tenant->vehicle_info['year'] ?? 'N/A' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">Color</div>
                            <div class="font-medium">{{ $tenant->vehicle_info['color'] ?? 'N/A' }}</div>
                        </div>
                        
                        <div>
                            <div class="text-sm text-gray-500">License Plate</div>
                            <div class="font-medium">{{ $tenant->vehicle_info['license_plate'] ?? 'N/A' }}</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Lease History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold">Lease History</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('tenants.lease-history', $tenant) }}" 
                                class="text-blue-600 hover:text-blue-900 text-sm">
                                View Complete History
                            </a>
                            <a href="{{ route('leases.create', ['tenant_id' => $tenant->id]) }}" 
                                class="bg-green-500 hover:bg-green-700 text-white text-sm py-1 px-2 rounded">
                                Create New Lease
                            </a>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">End Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Rent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($leaseHistory ?? $tenant->leases as $lease)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('properties.show', $lease->unit->property) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $lease->unit->property->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('units.show', $lease->unit) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $lease->unit->unit_number }}
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
                                        <a href="{{ route('leases.show', $lease) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-6 py-4 text-center">No lease history found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Maintenance History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Recent Maintenance Requests</h3>
                    
                    @if(count($maintenanceRecords) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property/Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Completion</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($maintenanceRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $record->property->name }} - Unit {{ $record->unit->unit_number }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="truncate max-w-xs">{{ $record->issue_type }} - {{ $record->description }}</div>
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
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('maintenance-records.show', $record) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-gray-500 italic">No maintenance records found</div>
                    @endif
                </div>
            </div>

            <!-- Tenant Metrics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Tenant Metrics</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                        <div class="bg-gray-50 p-4 rounded">
                            <div class="text-sm text-gray-500">Leases</div>
                            <div class="text-2xl font-bold">{{ $tenantMetrics['lease_count'] }}</div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded">
                            <div class="text-sm text-gray-500">Avg. Lease Duration</div>
                            <div class="text-2xl font-bold">{{ $tenantMetrics['average_lease_duration'] }} days</div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded">
                            <div class="text-sm text-gray-500">Avg. Monthly Rent</div>
                            <div class="text-2xl font-bold">${{ number_format($tenantMetrics['average_monthly_rent'], 2) }}</div>
                        </div>
                        
                        <div class="bg-gray-50 p-4 rounded">
                            <div class="text-sm text-gray-500">Total Rent Paid</div>
                            <div class="text-2xl font-bold">${{ number_format($tenantMetrics['total_rent_paid'], 2) }}</div>
                            <div class="mt-1 text-xs text-gray-500">
                                <a href="{{ route('tenants.payment-history', $tenant) }}" class="text-blue-600 hover:text-blue-900">
                                    View Payment History
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>