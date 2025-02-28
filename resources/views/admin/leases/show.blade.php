<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Lease Details
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('leases.edit', $lease) }}" 
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Edit Lease
                </a>
                <a href="{{ route('leases.generate-document', $lease) }}" 
                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    Generate Document
                </a>
                <a href="{{ route('leases.index') }}" 
                    class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                    Back to Leases
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

            <!-- Lease Summary Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Status</div>
                        <div class="text-2xl font-bold">
                            <span class="px-2 py-1 text-sm rounded-full 
                                @if($lease->status === 'active') bg-green-100 text-green-800
                                @elseif($lease->status === 'upcoming') bg-blue-100 text-blue-800
                                @elseif($lease->status === 'expired') bg-gray-100 text-gray-800
                                @elseif($lease->status === 'terminated') bg-red-100 text-red-800
                                @else bg-purple-100 text-purple-800 @endif">
                                {{ ucfirst($lease->status) }}
                            </span>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Monthly Rent</div>
                        <div class="text-2xl font-bold">${{ number_format($lease->monthly_rent, 2) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Lease Period</div>
                        <div class="text-lg font-medium">{{ $lease->start_date->format('M d, Y') }} - {{ $lease->end_date->format('M d, Y') }}</div>
                        <div class="text-sm text-gray-500">{{ $leaseMetrics['days_total'] }} days</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">
                            @if($lease->status === 'active')
                                Time Remaining
                            @elseif($lease->status === 'upcoming')
                                Starts In
                            @else
                                Lease Value
                            @endif
                        </div>
                        <div class="text-2xl font-bold">
                            @if($lease->status === 'active')
                                {{ $leaseMetrics['days_remaining'] }} days
                            @elseif($lease->status === 'upcoming')
                                {{ now()->diffInDays($lease->start_date) }} days
                            @else
                                ${{ number_format($leaseMetrics['total_value'], 2) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Lease Progress (Only for Active Leases) -->
            @if($lease->status === 'active')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Lease Progress</h3>
                    <div class="relative pt-1">
                        <div class="flex mb-2 items-center justify-between">
                            <div>
                                <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-blue-600 bg-blue-200">
                                    {{ number_format($leaseMetrics['elapsed_percentage'], 1) }}% Complete
                                </span>
                            </div>
                            <div class="text-right">
                                <span class="text-xs font-semibold inline-block text-blue-600">
                                    {{ $leaseMetrics['days_elapsed'] }} of {{ $leaseMetrics['days_total'] }} days
                                </span>
                            </div>
                        </div>
                        <div class="overflow-hidden h-2 mb-4 text-xs flex rounded bg-blue-200">
                            <div style="width:{{ $leaseMetrics['elapsed_percentage'] }}%" class="shadow-none flex flex-col text-center whitespace-nowrap text-white justify-center bg-blue-500"></div>
                        </div>
                        <div class="flex justify-between text-xs text-gray-500">
                            <span>{{ $lease->start_date->format('M d, Y') }}</span>
                            <span>{{ $lease->end_date->format('M d, Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
                <!-- Left Column - Lease Details -->
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lease Details</h3>
                            
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Property & Unit</h4>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Property</div>
                                        <div class="font-medium">
                                            <a href="{{ route('properties.show', $lease->unit->property) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $lease->unit->property->name }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Unit</div>
                                        <div class="font-medium">
                                            <a href="{{ route('units.show', $lease->unit) }}" class="text-blue-600 hover:text-blue-900">
                                                Unit {{ $lease->unit->unit_number }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Unit Type</div>
                                        <div>{{ $lease->unit->unit_type ?? 'Not specified' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Square Footage</div>
                                        <div>{{ number_format($lease->unit->square_footage ?? 0) }} sq ft</div>
                                    </div>
                                </div>
                                
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Lease Terms</h4>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Start Date</div>
                                        <div>{{ $lease->start_date->format('M d, Y') }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">End Date</div>
                                        <div>{{ $lease->end_date->format('M d, Y') }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Duration</div>
                                        <div>{{ $leaseMetrics['days_total'] }} days ({{ round($lease->start_date->diffInMonths($lease->end_date)) }} months)</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500">Renewable</div>
                                        <div>{{ $lease->renewable ? 'Yes' : 'No' }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-medium text-gray-700 mb-2">Financial Details</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Monthly Rent</div>
                                        <div class="font-medium">${{ number_format($lease->monthly_rent, 2) }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Total Value</div>
                                        <div>${{ number_format($leaseMetrics['total_value'], 2) }}</div>
                                    </div>
                                    @if($lease->status === 'active')
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Remaining Value</div>
                                        <div>${{ number_format($leaseMetrics['remaining_value'], 2) }}</div>
                                    </div>
                                    @endif
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Security Deposit</div>
                                        <div>${{ number_format($lease->security_deposit, 2) }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Pet Deposit</div>
                                        <div>${{ number_format($lease->pet_deposit, 2) }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Utilities Included</div>
                                        <div>{{ $lease->utilities_included ? 'Yes' : 'No' }}</div>
                                    </div>
                                    @if($lease->parking_fee > 0)
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Parking Fee</div>
                                        <div>${{ number_format($lease->parking_fee, 2) }}</div>
                                    </div>
                                    @endif
                                    @if($lease->storage_fee > 0)
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Storage Fee</div>
                                        <div>${{ number_format($lease->storage_fee, 2) }}</div>
                                    </div>
                                    @endif
                                    @if($lease->late_fee > 0)
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Late Fee</div>
                                        <div>${{ number_format($lease->late_fee, 2) }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            
                            @if($lease->move_in_inspection || $lease->move_out_inspection)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-medium text-gray-700 mb-2">Inspections</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    @if($lease->move_in_inspection)
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Move-in Inspection</div>
                                        <div>{{ $lease->move_in_inspection->format('M d, Y') }}</div>
                                    </div>
                                    @endif
                                    @if($lease->move_out_inspection)
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Move-out Inspection</div>
                                        <div>{{ $lease->move_out_inspection->format('M d, Y') }}</div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                            
                            @if(isset($lease->guarantor_info) && !empty($lease->guarantor_info))
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-medium text-gray-700 mb-2">Guarantor Information</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Name</div>
                                        <div>{{ $lease->guarantor_info['name'] ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Relationship</div>
                                        <div>{{ $lease->guarantor_info['relationship'] ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Phone</div>
                                        <div>{{ $lease->guarantor_info['phone'] ?? 'Not provided' }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-500">Email</div>
                                        <div>{{ $lease->guarantor_info['email'] ?? 'Not provided' }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($lease->status === 'terminated')
                            <div class="mt-6 pt-6 border-t border-gray-200 bg-red-50 p-4 rounded">
                                <h4 class="font-medium text-red-800 mb-2">Termination Details</h4>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-700">Termination Reason</div>
                                        <div class="font-medium">{{ $lease->termination_reason }}</div>
                                    </div>
                                    <div class="mb-2">
                                        <div class="text-sm text-gray-700">Security Deposit Returned</div>
                                        <div class="font-medium">${{ number_format($lease->security_deposit_returned ?? 0, 2) }}</div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            
                            @if($lease->notes)
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <h4 class="font-medium text-gray-700 mb-2">Notes</h4>
                                <div class="bg-gray-50 p-4 rounded">
                                    {{ $lease->notes }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Maintenance Records -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-medium text-gray-900">Maintenance Records</h3>
                                <a href="{{ route('maintenance-records.create', ['unit_id' => $lease->unit_id]) }}" 
                                    class="text-blue-600 hover:text-blue-900 text-sm">
                                    Create New Request
                                </a>
                            </div>
                            
                            @if(count($maintenanceRecords) > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issue</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cost</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($maintenanceRecords as $record)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_date->format('M d, Y') }}</td>
                                            <td class="px-6 py-4">
                                                <div class="font-medium">{{ $record->issue_type }}</div>
                                                <div class="text-sm text-gray-500 truncate max-w-xs">{{ $record->description }}</div>
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
                                                ${{ number_format($record->actual_cost ?? $record->estimated_cost ?? 0, 2) }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <a href="{{ route('maintenance-records.show', $record) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @else
                            <div class="text-gray-500 italic">No maintenance records found for this lease period</div>
                            @endif
                        </div>
                    </div>
                </div>
                
                <!-- Right Column - Tenant Info -->
                <div>
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tenant Information</h3>
                            
                            <div class="flex items-center mb-4">
                                <div class="flex-shrink-0 h-16 w-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <span class="text-gray-700 font-medium text-xl">{{ substr($lease->tenant->first_name, 0, 1) }}{{ substr($lease->tenant->last_name, 0, 1) }}</span>
                                </div>
                                <div class="ml-4">
                                    <h4 class="text-lg font-medium">
                                        <a href="{{ route('tenants.show', $lease->tenant) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $lease->tenant->first_name }} {{ $lease->tenant->last_name }}
                                        </a>
                                    </h4>
                                    <div class="text-sm text-gray-500">
                                        @if($lease->tenant->active_status)
                                            <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Active</span>
                                        @else
                                            <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="border-t border-gray-200 pt-4">
                                <div class="mb-2">
                                    <div class="text-sm text-gray-500">Email</div>
                                    <div><a href="mailto:{{ $lease->tenant->email }}" class="text-blue-600 hover:text-blue-900">{{ $lease->tenant->email }}</a></div>
                                </div>
                                <div class="mb-2">
                                    <div class="text-sm text-gray-500">Phone</div>
                                    <div><a href="tel:{{ $lease->tenant->phone }}" class="text-blue-600 hover:text-blue-900">{{ $lease->tenant->phone }}</a></div>
                                </div>
                                @if($lease->tenant->date_of_birth)
                                <div class="mb-2">
                                    <div class="text-sm text-gray-500">Date of Birth</div>
                                    <div>{{ $lease->tenant->date_of_birth->format('M d, Y') }} ({{ $lease->tenant->date_of_birth->age }} years)</div>
                                </div>
                                @endif
                                @if($lease->tenant->occupation)
                                <div class="mb-2">
                                    <div class="text-sm text-gray-500">Occupation</div>
                                    <div>{{ $lease->tenant->occupation }}</div>
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm text-gray-500">Tenant Since</div>
                                    <div>{{ $lease->tenant->created_at->format('M d, Y') }}</div>
                                </div>
                            </div>
                            
                            <div class="mt-4 flex justify-end">
                                <a href="{{ route('tenants.payment-history', $lease->tenant) }}" class="text-sm text-blue-600 hover:text-blue-900">
                                    View Payment History
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    @if($lease->status === 'active')
                    <!-- Action Buttons for Active Leases -->
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lease Actions</h3>
                            
                            <div class="space-y-3">
                                <button type="button" onclick="openTerminateModal()" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-100 border border-transparent rounded-md font-medium text-red-800 hover:bg-red-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    Terminate Lease
                                </button>
                                
                                <button type="button" onclick="openRenewModal()" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-100 border border-transparent rounded-md font-medium text-green-800 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                    </svg>
                                    Renew Lease
                                </button>
                                
                                <a href="{{ route('maintenance-records.create', ['unit_id' => $lease->unit_id]) }}" 
                                    class="w-full inline-flex justify-center items-center px-4 py-2 bg-yellow-100 border border-transparent rounded-md font-medium text-yellow-800 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                                    </svg>
                                    Create Maintenance Request
                                </a>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    <!-- Lease History -->
                    @if(isset($lease->previous_lease_id) || Lease::where('previous_lease_id', $lease->id)->exists())
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Lease History</h3>
                            
                            @if(isset($lease->previous_lease_id))
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700">Previous Lease</h4>
                                @php
                                    $previousLease = App\Models\Lease::find($lease->previous_lease_id);
                                @endphp
                                @if($previousLease)
                                <div class="mt-2 p-3 bg-gray-50 rounded">
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="text-sm text-gray-500">Period</div>
                                            <div>{{ $previousLease->start_date->format('M d, Y') }} - {{ $previousLease->end_date->format('M d, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Monthly Rent</div>
                                            <div>${{ number_format($previousLease->monthly_rent, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('leases.show', $previousLease) }}" class="text-sm text-blue-600 hover:text-blue-900">
                                            View previous lease details
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="text-gray-500 italic">Previous lease data not available</div>
                                @endif
                            </div>
                            @endif
                            
                            @php
                                $renewedLease = App\Models\Lease::where('previous_lease_id', $lease->id)->first();
                            @endphp
                            @if($renewedLease)
                            <div>
                                <h4 class="text-sm font-medium text-gray-700">Renewed Lease</h4>
                                <div class="mt-2 p-3 bg-gray-50 rounded">
                                    <div class="flex justify-between">
                                        <div>
                                            <div class="text-sm text-gray-500">Period</div>
                                            <div>{{ $renewedLease->start_date->format('M d, Y') }} - {{ $renewedLease->end_date->format('M d, Y') }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500">Monthly Rent</div>
                                            <div>${{ number_format($renewedLease->monthly_rent, 2) }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <a href="{{ route('leases.show', $renewedLease) }}" class="text-sm text-blue-600 hover:text-blue-900">
                                            View renewed lease details
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Terminate Lease Modal (Hidden by default) -->
    <div id="terminateModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-lg w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Terminate Lease</h3>
                    <button type="button" onclick="closeTerminateModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('leases.terminate', $lease) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="termination_date" class="block text-sm font-medium text-gray-700">Termination Date</label>
                        <input type="date" id="termination_date" name="termination_date" required
                            min="{{ $lease->start_date->format('Y-m-d') }}" max="{{ $lease->end_date->format('Y-m-d') }}"
                            value="{{ now()->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    
                    <div>
                        <label for="termination_reason" class="block text-sm font-medium text-gray-700">Reason for Termination</label>
                        <select id="termination_reason" name="termination_reason" required
                            class="mt-1 block w-full rounded-md border-gray-300">
                            <option value="Tenant Request">Tenant Request</option>
                            <option value="Non-payment">Non-payment</option>
                            <option value="Lease Violation">Lease Violation</option>
                            <option value="Property Damage">Property Damage</option>
                            <option value="Mutual Agreement">Mutual Agreement</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="final_inspection_date" class="block text-sm font-medium text-gray-700">Final Inspection Date</label>
                        <input type="date" id="final_inspection_date" name="final_inspection_date"
                            class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    
                    <div>
                        <label for="security_deposit_returned" class="block text-sm font-medium text-gray-700">Security Deposit Returned</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" id="security_deposit_returned" name="security_deposit_returned" step="0.01"
                                max="{{ $lease->security_deposit }}"
                                class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Max: ${{ number_format($lease->security_deposit, 2) }}</p>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" onclick="closeTerminateModal()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                            Terminate Lease
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Renew Lease Modal (Hidden by default) -->
    <div id="renewModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
        <div class="bg-white rounded-lg overflow-hidden shadow-xl max-w-lg w-full">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">Renew Lease</h3>
                    <button type="button" onclick="closeRenewModal()" class="text-gray-400 hover:text-gray-500">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form action="{{ route('leases.renew', $lease) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="new_start_date" class="block text-sm font-medium text-gray-700">New Start Date</label>
                        <input type="date" id="new_start_date" name="new_start_date" required
                            min="{{ $lease->end_date->format('Y-m-d') }}"
                            value="{{ $lease->end_date->addDays(1)->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    
                    <div>
                        <label for="new_end_date" class="block text-sm font-medium text-gray-700">New End Date</label>
                        <input type="date" id="new_end_date" name="new_end_date" required
                            min="{{ $lease->end_date->addDays(1)->format('Y-m-d') }}"
                            value="{{ $lease->end_date->addYear()->format('Y-m-d') }}"
                            class="mt-1 block w-full rounded-md border-gray-300">
                    </div>
                    
                    <div>
                        <label for="new_monthly_rent" class="block text-sm font-medium text-gray-700">New Monthly Rent</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" id="new_monthly_rent" name="new_monthly_rent" step="0.01" required
                                value="{{ $lease->monthly_rent }}"
                                class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                        </div>
                    </div>
                    
                    <div>
                        <label for="security_deposit" class="block text-sm font-medium text-gray-700">Security Deposit</label>
                        <div class="mt-1 relative rounded-md shadow-sm">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 sm:text-sm">$</span>
                            </div>
                            <input type="number" id="security_deposit" name="security_deposit" step="0.01" required
                                value="{{ $lease->security_deposit }}"
                                class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                        </div>
                    </div>
                    
                    <div>
                        <label for="renewable" class="inline-flex items-center">
                            <input type="checkbox" id="renewable" name="renewable" value="1" 
                                {{ $lease->renewable ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <span class="ml-2">Renewable</span>
                        </label>
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                        <textarea id="notes" name="notes" rows="3"
                            class="mt-1 block w-full rounded-md border-gray-300"></textarea>
                    </div>
                    
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button type="button" onclick="closeRenewModal()" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </button>
                        <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Renew Lease
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <script>
        function openTerminateModal() {
            document.getElementById('terminateModal').classList.remove('hidden');
        }
        
        function closeTerminateModal() {
            document.getElementById('terminateModal').classList.add('hidden');
        }
        
        function openRenewModal() {
            document.getElementById('renewModal').classList.remove('hidden');
        }
        
        function closeRenewModal() {
            document.getElementById('renewModal').classList.add('hidden');
        }
    </script>
</x-app-layout>