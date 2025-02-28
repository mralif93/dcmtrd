<!-- resources/views/admin/leases/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Lease Management') }}
            </h2>
            <a href="{{ route('leases.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Lease
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

            @if(session('error'))
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('leases.index') }}" method="GET" class="space-y-4">
                        <div class="flex flex-col md:flex-row md:space-x-4">
                            <div class="w-full md:w-1/3 py-2">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300" 
                                    placeholder="Search by tenant, unit, or property...">
                            </div>
                            
                            <div class="w-full md:w-1/4 py-2">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Statuses</option>
                                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    <option value="expired" {{ request('status') == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="terminated" {{ request('status') == 'terminated' ? 'selected' : '' }}>Terminated</option>
                                    <option value="renewed" {{ request('status') == 'renewed' ? 'selected' : '' }}>Renewed</option>
                                </select>
                            </div>
                            
                            <div class="w-full md:w-1/4 py-2">
                                <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                <select name="property_id" id="property_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Properties</option>
                                    @foreach($properties as $id => $name)
                                        <option value="{{ $id }}" {{ request('property_id') == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex flex-col md:flex-row md:space-x-4">
                            <div class="w-full md:w-1/4 py-2">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date (After)</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            
                            <div class="w-full md:w-1/4 py-2">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date (Before)</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            
                            <div class="w-full md:w-1/4 md:self-end py-2">
                                <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Filter
                                </button>
                            </div>
                            
                            <div class="w-full md:w-1/4 md:self-end py-2">
                                <a href="{{ route('leases.index') }}" class="block text-center w-full bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Active Leases</div>
                        <div class="text-2xl font-bold">{{ $activeLeases }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Expiring in 30 Days</div>
                        <div class="text-2xl font-bold">{{ $expiringLeases }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Monthly Revenue</div>
                        <div class="text-2xl font-bold">${{ number_format($totalMonthlyRevenue) }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Average Lease Length</div>
                        <div class="text-2xl font-bold">{{ $avgLeaseDays }} days</div>
                    </div>
                </div>
            </div>

            <!-- Leases List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property & Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dates</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Rent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($leases as $lease)
                                <tr>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('tenants.show', $lease->tenant) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $lease->tenant->first_name }} {{ $lease->tenant->last_name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>
                                            <a href="{{ route('properties.show', $lease->unit->property) }}" class="text-blue-600 hover:text-blue-900">
                                                {{ $lease->unit->property->name }}
                                            </a>
                                        </div>
                                        <div class="text-sm text-gray-500">
                                            <a href="{{ route('units.show', $lease->unit) }}" class="text-blue-600 hover:text-blue-900">
                                                Unit {{ $lease->unit->unit_number }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div>Start: {{ $lease->start_date->format('M d, Y') }}</div>
                                        <div>End: {{ $lease->end_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">
                                            @if($lease->status === 'active')
                                                {{ $lease->end_date->diffForHumans() }}
                                            @elseif($lease->status === 'upcoming')
                                                Starts {{ $lease->start_date->diffForHumans() }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">${{ number_format($lease->monthly_rent, 2) }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($lease->status === 'active') bg-green-100 text-green-800
                                            @elseif($lease->status === 'upcoming') bg-blue-100 text-blue-800
                                            @elseif($lease->status === 'expired') bg-gray-100 text-gray-800
                                            @elseif($lease->status === 'terminated') bg-red-100 text-red-800
                                            @else bg-purple-100 text-purple-800 @endif">
                                            {{ ucfirst($lease->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('leases.show', $lease) }}" class="text-blue-600 hover:text-blue-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('leases.edit', $lease) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('leases.generate-document', $lease) }}" class="text-green-600 hover:text-green-900" target="_blank">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </a>
                                            @if($lease->status === 'active')
                                            <button type="button" onclick="openTerminateModal({{ $lease->id }})" class="text-yellow-600 hover:text-yellow-900">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </button>
                                            @endif
                                            <form action="{{ route('leases.destroy', $lease) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this lease?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center">No leases found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    @if(method_exists($leases, 'links'))
                    <div class="mt-4">
                        {{ $leases->links() }}
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
                
                <form id="terminateForm" action="" method="POST" class="space-y-4">
                    @csrf
                    @method('PUT')
                    
                    <div>
                        <label for="termination_date" class="block text-sm font-medium text-gray-700">Termination Date</label>
                        <input type="date" id="termination_date" name="termination_date" required
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
                                class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                        </div>
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
    
    <script>
        function openTerminateModal(leaseId) {
            document.getElementById('terminateForm').action = `/admin/leases/${leaseId}/terminate`;
            document.getElementById('terminateModal').classList.remove('hidden');
        }
        
        function closeTerminateModal() {
            document.getElementById('terminateModal').classList.add('hidden');
        }
    </script>
</x-app-layout>