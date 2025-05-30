<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklists Management') }}
            </h2>
            <a href="{{ route('tenant-a.index', $property) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Tenant
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

            <!-- Property Summary Card (if applicable) -->
            @if(isset($property))
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">{{ $property->name }}</h3>
                        <p class="text-sm text-gray-600">{{ $property->category }} - {{ $property->city }}, {{ $property->state }}</p>
                    </div>
                    <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $property->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                        {{ ucfirst($property->status ?? 'unknown') }}
                    </span>
                </div>
                
                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Property</h4>
                            <p class="text-xl font-bold text-gray-800">{{ $property->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-600 mt-1">{{ $property->city ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Checklists</h4>
                            <p class="text-xl font-bold text-gray-800">{{ $checklists->where('status', 'active')->count() }} Active</p>
                            <p class="text-sm text-gray-600 mt-1">Total: {{ $checklists->count() }}</p>
                        </div>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Pending Items</h4>
                            <p class="text-xl font-bold text-gray-800">{{ $checklists->where('status', 'pending')->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Last Updated: {{ $checklists->max('updated_at') ? date('d M Y', strtotime($checklists->max('updated_at'))) : 'N/A' }}</p>
                        </div>
                        
                        <div class="px-4 py-5 sm:px-6">
                            <h4 class="text-sm font-medium text-gray-500 uppercase mb-2">Site Visits</h4>
                            <p class="text-xl font-bold text-gray-800">{{ $checklists->whereNotNull('site_visit_id')->count() }}</p>
                            <p class="text-sm text-gray-600 mt-1">Latest: {{ $checklists->whereNotNull('site_visit_id')->max('created_at') ? date('d M Y', strtotime($checklists->whereNotNull('site_visit_id')->max('created_at'))) : 'None' }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Checklists List -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Checklists List</h3>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200">
                    <form method="GET" action="{{ route('checklist-a.index', $property) }}" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Search Field -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                            <div class="mt-1 relative rounded-md shadow-sm">
                                <input type="text" name="search" id="search" value="{{ request('search') }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    placeholder="Search by property, tenant...">
                                <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <!-- Status Filter -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">All Status</option>
                                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                                <option value="active" @selected(request('status') === 'active')>Active</option>
                                <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                                <option value="rejected" @selected(request('status') === 'rejected')>Rejected</option>
                                <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                            </select>
                        </div>

                        <!-- Filter Button -->
                        <div class="flex items-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                                </svg>
                                Apply Filters
                            </button>

                            @if(request('search') || request('status'))
                                <a href="{{ route('checklist-a.index', $property) }}" class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300">
                                    Clear
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

                <!-- Checklists Table -->
                <div class="overflow-x-auto border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Main Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Status</th>
                                <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($checklists as $checklist)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            {{ $checklist->siteVisit->property->name ?? 'N/A' }}
                                        </div>
                                        <div class="text-xs text-gray-500">
                                            {{ $checklist->siteVisit->property->city ?? 'No location' }}
                                        </div>
                                        <div class="text-xs text-gray-500 mt-1">
                                            @if($checklist->approval_datetime)
                                                Last Updated: {{ date('d M Y', strtotime($checklist->updated_at)) }}
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ match(strtolower($checklist->status)) {
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'active' => 'bg-green-100 text-green-800',
                                                'inactive' => 'bg-gray-100 text-gray-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst($checklist->status ?? 'N/A') }}
                                        </span>
                                        @if($checklist->approval_datetime)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Approved: {{ date('d M Y', strtotime($checklist->approval_datetime)) }}
                                            </div>
                                        @endif
                                        @if($checklist->prepared_by)
                                            <div class="text-xs text-gray-500 mt-1">
                                                By: {{ $checklist->prepared_by }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-xs grid grid-cols-1 gap-1">
                                            @if($checklist->legalDocumentation)
                                                <div class="flex items-center">
                                                    <span class="w-24 text-gray-600">Legal Docs:</span>
                                                    <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($checklist->legalDocumentation->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($checklist->legalDocumentation->status ?? 'N/A') }}
                                                    </span>
                                                </div>
                                            @endif

                                            @if($checklist->tenants->count() > 0)
                                                <div class="flex items-center">
                                                    <span class="w-24 text-gray-600">Tenants:</span>
                                                    @php
                                                        $totalTenants = $checklist->tenants->count();
                                                        // Count tenants with specifically 'active' status
                                                        $activeCount = $checklist->tenants->where('pivot.status', 'active')->count();
                                                        // Set status based on whether all tenants are active
                                                        $isActive = ($activeCount == $totalTenants && $totalTenants > 0);
                                                        $status = $isActive ? 'active' : 'pending';
                                                        $statusText = $isActive ? 'Active' : 'Pending';
                                                    @endphp
                                                    
                                                    <!-- Overall status indicator -->
                                                    <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ $statusText }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($checklist->externalAreaCondition)
                                                <div class="flex items-center">
                                                    <span class="w-24 text-gray-600">External:</span>
                                                    <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($checklist->externalAreaCondition->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($checklist->externalAreaCondition->status ?? 'N/A') }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($checklist->internalAreaCondition)
                                                <div class="flex items-center">
                                                    <span class="w-24 text-gray-600">Internal:</span>
                                                    <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($checklist->internalAreaCondition->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($checklist->internalAreaCondition->status ?? 'N/A') }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($checklist->propertyDevelopment)
                                                <div class="flex items-center">
                                                    <span class="w-24 text-gray-600">Development:</span>
                                                    <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($checklist->propertyDevelopment->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($checklist->propertyDevelopment->status ?? 'N/A') }}
                                                    </span>
                                                </div>
                                            @endif
                                            
                                            @if($checklist->disposalInstallation && $checklist->disposalInstallation->count() > 0)
                                                <div class="flex flex-col space-y-3">
                                                    <div class="flex items-center">
                                                        <span class="w-24 text-gray-600">Disposal:</span>
                                                        @php
                                                            // Get all disposal installation items
                                                            $dispInstallItems = $checklist->disposalInstallation;
                                                            $totalItems = $dispInstallItems->count();
                                                            $completedCount = $dispInstallItems->where('status', 'active')->count();
                                                            
                                                            // Check if all items are completed
                                                            $allCompleted = ($completedCount == $totalItems && $totalItems > 0);
                                                            // Overall status is either "Completed" or "Pending"
                                                            $overallStatus = $allCompleted ? 'Active' : 'Pending';
                                                            // Status for color styling
                                                            $statusClass = $allCompleted ? 'active' : 'pending';
                                                        @endphp
                                                        
                                                        <!-- Overall status indicator -->
                                                        <span class="px-2 py-1 ml-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                            {{ match(strtolower($statusClass)) {
                                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                                'active' => 'bg-green-100 text-green-800',
                                                                'inactive' => 'bg-gray-100 text-gray-800',
                                                                'rejected' => 'bg-red-100 text-red-800',
                                                                default => 'bg-gray-100 text-gray-800'
                                                            } }}">
                                                            {{ $overallStatus }}
                                                        </span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex justify-end space-x-2">
                                            <a href="{{ route('checklist-a.show', $checklist) }}" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                                </svg>
                                            </a>
                                            <a href="#" class="text-indigo-600 hover:text-indigo-900">
                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-4 whitespace-nowrap text-sm text-center text-gray-500">No checklists found {{ request('search') ? 'matching your search' : '' }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination Links -->
                <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
                    {{ $checklists->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>