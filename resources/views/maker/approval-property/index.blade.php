<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Property Approvals Management') }}
            </h2>
            <a href="{{ route('maker.dashboard', ['section' => 'reits']) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Dashboard
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Property Approvals</h3>
                    <div class="flex gap-2">
                        <a href="{{ route('approval-property-m.create') }}" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Create New Approval
                        </a>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('approval-property-m.index') }}">
                        <div class="grid grid-cols-1 gap-4">
                            <!-- Row 1: Search (full width) -->
                            <div class="col-span-1">
                                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                                <div class="mt-1 flex rounded-md shadow-sm">
                                    <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                        placeholder="Search in description or remarks"
                                        class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            <!-- Row 2: Property and Status (2 columns) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Property Filter -->
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                    <select name="property_id" id="property_id" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">All Properties</option>
                                        @foreach(App\Models\Property::where('status', 'active')->get() as $property)
                                            <option value="{{ $property->id }}" @selected(request('property_id') == $property->id)>
                                                {{ $property->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Status Filter -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select name="status" id="status" 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">All Status</option>
                                        <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                        <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                                        <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                                        <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Row 3: Date Range (2 columns) -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Date From -->
                                <div>
                                    <label for="date_from" class="block text-sm font-medium text-gray-700">Date From</label>
                                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <!-- Date To -->
                                <div>
                                    <label for="date_to" class="block text-sm font-medium text-gray-700">Date To</label>
                                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}"
                                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                            
                            <!-- Row 4: Filter Buttons -->
                            <div class="flex justify-end space-x-2">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                    </svg>
                                    Filter
                                </button>

                                @if(request()->anyFilled(['property_id', 'status', 'date_from', 'date_to', 'search']))
                                    <a href="{{ route('approval-property-m.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-gray-700 hover:bg-gray-200">
                                        Clear
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Approvals Table -->
                <div class="overflow-x-auto border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Approval</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estimated Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($approvalProperties as $approval)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">
                                        <a href="{{ route('property-m.show', $approval->property) }}" class="text-indigo-600 hover:text-indigo-900">
                                            {{ $approval->property->name }}
                                        </a>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ Str::limit($approval->description, 50) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $approval->date_of_approval->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $approval->estimated_amount ? 'RM ' . $approval->formatted_amount : 'N/A' }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($approval->status)) {
                                            'approved' => 'bg-green-100 text-green-800',
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'draft' => 'bg-blue-100 text-blue-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst($approval->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end space-x-2">
                                        <a href="{{ route('approval-property-m.show', $approval) }}" class="text-indigo-600 hover:text-indigo-900" title="View Details">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                            </svg>
                                        </a>
                                        <a href="{{ route('approval-property-m.edit', $approval) }}" class="text-indigo-600 hover:text-indigo-900" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($approvalProperties->count() === 0)
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No property approvals found.</div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $approvalProperties->appends(request()->except('page'))->links() }}
                    
                    <!-- Results count -->
                    <div class="mt-2 text-sm text-gray-500">
                        Showing {{ $approvalProperties->firstItem() ?? 0 }} to {{ $approvalProperties->lastItem() ?? 0 }} of {{ $approvalProperties->total() }} property approvals
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>