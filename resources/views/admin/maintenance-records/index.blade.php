<!-- resources/views/maintenance/index.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Maintenance Records') }}
            </h2>
            <a href="{{ route('maintenance-records.create') }}" 
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Create Maintenance Request
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

            <!-- Summary Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Total Records</div>
                        <div class="text-2xl font-bold">{{ $totalRecords }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Pending</div>
                        <div class="text-2xl font-bold">{{ $pendingRecords }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">In Progress</div>
                        <div class="text-2xl font-bold">{{ $inProgressRecords }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">Completed</div>
                        <div class="text-2xl font-bold">{{ $completedRecords }}</div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="text-sm text-gray-500">High Priority</div>
                        <div class="text-2xl font-bold">{{ $highPriorityRecords }}</div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <form action="{{ route('maintenance-records.index') }}" method="GET" class="space-y-4">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300" 
                                    placeholder="Search by description, reported by, etc.">
                            </div>
                            
                            <div>
                                <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                <select name="property_id" id="property_id" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Properties</option>
                                    @foreach(App\Models\Property::all() as $property)
                                        <option value="{{ $property->id }}" {{ request('property_id') == $property->id ? 'selected' : '' }}>
                                            {{ $property->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Statuses</option>
                                    <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="Completed" {{ request('status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ request('status') == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="priority" class="block text-sm font-medium text-gray-700">Priority</label>
                                <select name="priority" id="priority" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Priorities</option>
                                    <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Emergency" {{ request('priority') == 'Emergency' ? 'selected' : '' }}>Emergency</option>
                                </select>
                            </div>

                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category" class="mt-1 block w-full rounded-md border-gray-300">
                                    <option value="">All Categories</option>
                                    <option value="Plumbing" {{ request('category') == 'Plumbing' ? 'selected' : '' }}>Plumbing</option>
                                    <option value="Electrical" {{ request('category') == 'Electrical' ? 'selected' : '' }}>Electrical</option>
                                    <option value="HVAC" {{ request('category') == 'HVAC' ? 'selected' : '' }}>HVAC</option>
                                    <option value="Structural" {{ request('category') == 'Structural' ? 'selected' : '' }}>Structural</option>
                                    <option value="Appliance" {{ request('category') == 'Appliance' ? 'selected' : '' }}>Appliance</option>
                                    <option value="Landscaping" {{ request('category') == 'Landscaping' ? 'selected' : '' }}>Landscaping</option>
                                    <option value="Pest Control" {{ request('category') == 'Pest Control' ? 'selected' : '' }}>Pest Control</option>
                                    <option value="Other" {{ request('category') == 'Other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300">
                            </div>
                        </div>

                        <div class="w-full md:w-1/3 md:self-end">
                            <div class="flex space-x-2">
                                <button type="submit" class="w-full bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                    Search
                                </button>
                                <a href="{{ route('maintenance-records.index') }}" class="w-full text-center bg-gray-200 hover:bg-gray-300 text-gray-800 font-bold py-2 px-4 rounded">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Maintenance Records List -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">WO #</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property / Unit</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reported By</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Request Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Priority</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($maintenanceRecords as $record)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('maintenance-records.show', $record) }}" class="text-blue-600 hover:text-blue-900">
                                            {{ $record->work_order_number }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $record->property->name }} 
                                        @if($record->unit)
                                            / Unit {{ $record->unit->unit_number }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_type }}</td>
                                    <td class="px-6 py-4">
                                        <div class="truncate max-w-xs">{{ $record->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->reported_by }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $record->request_date->format('M d, Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($record->priority === 'Low') bg-green-100 text-green-800
                                            @elseif($record->priority === 'Medium') bg-blue-100 text-blue-800
                                            @elseif($record->priority === 'High') bg-yellow-100 text-yellow-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ $record->priority }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs rounded-full 
                                            @if($record->status === 'Pending') bg-yellow-100 text-yellow-800
                                            @elseif($record->status === 'In Progress') bg-blue-100 text-blue-800
                                            @elseif($record->status === 'Completed') bg-green-100 text-green-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ $record->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('maintenance-records.edit', $record) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <a href="{{ route('maintenance-records.show', $record) }}" class="text-blue-600 hover:text-blue-900 mr-3">View</a>
                                        <form action="{{ route('maintenance-records.destroy', $record) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Are you sure you want to delete this maintenance record?')">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="px-6 py-4 text-center">No maintenance records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $maintenanceRecords->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const propertySelect = document.getElementById('property_id');
            const unitSelect = document.getElementById('unit_id');
            
            if (propertySelect && unitSelect) {
                propertySelect.addEventListener('change', function() {
                    const propertyId = this.value;
                    
                    if (propertyId) {
                        fetch(`/api/properties/${propertyId}/units`)
                            .then(response => response.json())
                            .then(units => {
                                unitSelect.innerHTML = '<option value="">All Units</option>';
                                
                                units.forEach(unit => {
                                    const option = document.createElement('option');
                                    option.value = unit.id;
                                    option.textContent = unit.unit_number;
                                    unitSelect.appendChild(option);
                                });
                                
                                unitSelect.disabled = false;
                            });
                    } else {
                        unitSelect.innerHTML = '<option value="">All Units</option>';
                        unitSelect.disabled = true;
                    }
                });
            }
        });
    </script>
</x-app-layout>