<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Details') }}
            </h2>
            <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to List
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

            <!-- Checklist Overview Card -->
            <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
                <div class="px-4 py-5 sm:px-6 flex justify-between">
                    <div>
                        <h3 class="text-lg font-medium text-gray-900">
                            Checklist for: {{ $checklist->siteVisit->property->name ?? 'N/A' }}
                        </h3>
                        <p class="mt-1 max-w-2xl text-sm text-gray-500">
                            {{ $checklist->siteVisit->property->city ?? 'N/A' }}, {{ $checklist->siteVisit->property->state ?? 'N/A' }}
                        </p>
                    </div>
                    <span class="px-2 py-1 h-6 text-xs font-semibold rounded-full
                        {{ match(strtolower($checklist->status)) {
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'active' => 'bg-green-100 text-green-800',
                            'inactive' => 'bg-gray-100 text-gray-800',
                            'rejected' => 'bg-red-100 text-red-800',
                            default => 'bg-gray-100 text-gray-800'
                        } }}">
                        {{ ucfirst($checklist->status) }}
                    </span>
                </div>
                
                <div class="border-t border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-0 divide-y md:divide-y-0 md:divide-x divide-gray-200">
                        <div class="px-4 py-3 sm:px-6">
                            <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Site Visit Info</h4>
                            <p class="text-sm font-medium text-gray-900">{{ $checklist->siteVisit->date_visit ? date('d M Y', strtotime($checklist->siteVisit->date_visit)) : 'N/A' }}</p>
                            <p class="text-sm text-gray-500">{{ $checklist->siteVisit->trustee ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="px-4 py-3 sm:px-6">
                            <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Approval</h4>
                            <p class="text-sm font-medium text-gray-900">{{ $checklist->approval_datetime ? date('d M Y', strtotime($checklist->approval_datetime)) : 'Pending' }}</p>
                            @if($checklist->verified_by)
                                <p class="text-sm text-gray-500">Verified by: {{ $checklist->verified_by }}</p>
                            @endif
                        </div>
                        
                        <div class="px-4 py-3 sm:px-6">
                            <h4 class="text-xs font-medium text-gray-500 uppercase mb-1">Components Status</h4>
                            <div class="flex flex-wrap gap-1">
                                @if($checklist->legalDocumentation)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ match(strtolower($checklist->legalDocumentation->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        Legal: {{ ucfirst($checklist->legalDocumentation->status ?? 'N/A') }}
                                    </span>
                                @endif

                                @php
                                    // Get tenant statuses to determine an overall status
                                    $tenantStatuses = $checklist->tenants->pluck('pivot.status')->unique();
                                    
                                    // Determine an overall status
                                    $overallStatus = 'draft';
                                    if($tenantStatuses->contains('pending')) {
                                        $overallStatus = 'pending';
                                    } elseif($tenantStatuses->count() > 0 && $tenantStatuses->every(function($status) { return $status === 'active'; })) {
                                        $overallStatus = 'active';
                                    } elseif($tenantStatuses->isNotEmpty()) {
                                        $overallStatus = 'not available';
                                    }
                                    
                                    // Set the appropriate CSS classes based on status
                                    $statusClasses = match($overallStatus) {
                                        'active' => 'bg-green-100 text-green-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    };
                                @endphp
                                
                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses }}">
                                    Tenants: {{ ucfirst($overallStatus) }}
                                </span>
                                
                                @if($checklist->externalAreaCondition)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ match(strtolower($checklist->externalAreaCondition->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        External: {{ ucfirst($checklist->externalAreaCondition->status ?? 'N/A') }}
                                    </span>
                                @endif
                                
                                @if($checklist->internalAreaCondition)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ match(strtolower($checklist->internalAreaCondition->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        Internal: {{ ucfirst($checklist->internalAreaCondition->status ?? 'N/A') }}
                                    </span>
                                @endif

                                @if($checklist->propertyDevelopment)
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full
                                        {{ match(strtolower($checklist->propertyDevelopment->status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        Development: {{ ucfirst($checklist->propertyDevelopment->status ?? 'N/A') }}
                                    </span>
                                @endif

                                @php
                                    // Count all disposal installation items
                                    $totalItems = $checklist->disposalInstallation->count();
                                    
                                    // If no items, show as draft
                                    if ($totalItems == 0) {
                                        $statusText = 'draft';
                                    } else {
                                        // Count items by status
                                        $activeItems = $checklist->disposalInstallation->where('status', 'active')->count();
                                        $pendingItems = $checklist->disposalInstallation->where('status', 'pending')->count();
                                        
                                        // Determine overall status
                                        if ($activeItems == $totalItems) {
                                            $statusText = 'active';
                                        } elseif ($pendingItems == $totalItems) {
                                            $statusText = 'pending';
                                        } else {
                                            $statusText = 'pending'; // Mixed statuses default to pending
                                        }
                                    }
                                    
                                    // Set appropriate color classes based on status
                                    $bgColorClass = match($statusText) {
                                        'active' => 'bg-green-100',
                                        'pending' => 'bg-yellow-100',
                                        'rejected' => 'bg-red-100',
                                        'draft' => 'bg-gray-100',
                                        default => 'bg-gray-100'
                                    };
                                    $textColorClass = match($statusText) {
                                        'active' => 'text-green-800',
                                        'pending' => 'text-yellow-800',
                                        'rejected' => 'text-red-800',
                                        'draft' => 'text-gray-800',
                                        default => 'text-gray-800'
                                    };
                                @endphp

                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $bgColorClass }} {{ $textColorClass }}">
                                    Installations: {{ ucfirst($statusText) }}
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="mb-6 bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex" aria-label="Tabs">
                        <button type="button" onclick="switchTab('main')" class="tab-button bg-white py-4 px-6 border-b-2 border-indigo-500 font-medium text-sm text-indigo-600" id="tab-main">
                            Main Details
                        </button>
                        <button type="button" onclick="switchTab('legal')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-legal">
                            Legal
                        </button>
                        <button type="button" onclick="switchTab('tenants')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-tenants">
                            Tenants
                        </button>
                        <button type="button" onclick="switchTab('external')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-external">
                            External Areas
                        </button>
                        <button type="button" onclick="switchTab('internal')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-internal">
                            Internal Areas
                        </button>
                        <button type="button" onclick="switchTab('development')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-development">
                            Development
                        </button>
                        <button type="button" onclick="switchTab('installations')" class="tab-button bg-white py-4 px-6 border-b-2 border-transparent font-medium text-sm text-gray-500 hover:text-gray-700 hover:border-gray-300" id="tab-installations">
                            Disposal/Installations/Replacement
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Main Details Tab Content -->
            <div id="content-main" class="tab-content bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Main Checklist Information</h3>
                </div>
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2 flex items-center justify-between">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->status)) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->status) }}
                                </span>
                                
                                <!-- Submit for Approval Button - Only shown for draft or rejected status -->
                                @if(strtolower($checklist->status) === 'draft' || strtolower($checklist->status) === 'rejected')
                                    <button type="button" 
                                        onclick="openApprovalModal('checklist', {{ $checklist->id }}, '{{ $checklist->siteVisit->property->name ?? "Main Checklist" }}', '{{ route('checklist-m.approval', $checklist) }}')"
                                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                        <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        Submit for Approval
                                    </button>
                                @endif
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->approval_datetime ? $checklist->approval_datetime->format('d/m/Y h:i A') : 'N/A' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->remarks ?? 'No remarks available' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->created_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->updated_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    <a href="{{ route('checklist-m.edit', $checklist) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Checklist
                    </a>
                </div>
            </div>

            <!-- Legal Documentation Tab Content -->
            <div id="content-legal" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Legal Documentation Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">1.0 Legal Documentation</h3>
                    
                    <div class="flex items-center space-x-4">
                        @if($checklist->legalDocumentation)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ match(strtolower($checklist->legalDocumentation->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst($checklist->legalDocumentation->status ?? 'Not Started') }}
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Not Started
                            </span>
                        @endif

                        <!-- Submit for Approval Button - Only shown for draft or rejected status -->
                        @if($checklist->legalDocumentation && (strtolower($checklist->legalDocumentation->status) === 'draft' || strtolower($checklist->legalDocumentation->status) === 'rejected'))
                            <button type="button" 
                                onclick="openApprovalModal('legal', {{ $checklist->legalDocumentation->id }}, 'Legal Documentation for {{ $checklist->siteVisit->property->name ?? "Property" }}', '{{ route('checklist-legal-documentation-m.approval', $checklist->legalDocumentation) }}')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit for Approval
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Legal Documentation Details -->
                <div class="border-t border-gray-200">
                    <dl>
                        @if($checklist->legalDocumentation)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Title Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->title_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Title Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->title_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Trust Deed Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->trust_deed_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Trust Deed Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->trust_deed_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Sale & Purchase Agreement Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->sale_purchase_agreement_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Sale & Purchase Agreement Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->sale_purchase_agreement_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Lease Agreement Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->lease_agreement_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Lease Agreement Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->lease_agreement_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Agreement to Lease Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->agreement_to_lease_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Agreement to Lease Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->agreement_to_lease_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Maintenance Agreement Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->maintenance_agreement_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Maintenance Agreement Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->maintenance_agreement_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Development Agreement Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->development_agreement_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Development Agreement Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->development_agreement_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Others Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->others_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Others Location</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->others_location ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Approval Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div>Prepared by: {{ $checklist->legalDocumentation->prepared_by ?? 'N/A' }}</div>
                                    <div>Verified by: {{ $checklist->legalDocumentation->verified_by ?? 'N/A' }}</div>
                                    <div>Approved on: {{ $checklist->legalDocumentation->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->legalDocumentation->approval_datetime)) : 'N/A' }}</div>
                                </dd>
                            </div>
                            @if($checklist->legalDocumentation->remarks)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->remarks ?? 'N/A' }}
                                </dd>
                            </div>
                            @endif
                        @else
                            <div class="bg-white px-4 py-5 sm:px-6">
                                <p class="text-sm text-gray-500 text-center">No legal documentation information available for this checklist.</p>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    <a href="{{ route('checklist-legal-documentation-m.edit', $checklist->legalDocumentation) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Legal Documentation
                    </a>
                </div>
            </div>

            <!-- Tenants Tab Content -->
            <div id="content-tenants" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Tenants Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">2.0 Tenants</h3>
                    <a href="{{ route('checklist-tenant-m.create', $checklist) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Tenant
                    </a>
                </div>

                <!-- Tenants Details -->
                <div class="border-t border-gray-200">
                    @if($checklist->tenants && $checklist->tenants->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Information</th>
                                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($checklist->tenants as $tenant)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $tenant->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $tenant->property->name ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                    {{ $tenant->pivot->status === 'completed' ? 'bg-green-100 text-green-800' : 
                                                    ($tenant->pivot->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 
                                                    ($tenant->pivot->status === 'verified' ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800')) }}">
                                                    {{ ucfirst($tenant->pivot->status ?? 'N/A') }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $tenant->pivot->notes ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $tenant->pivot->remarks ?? 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>Prepared by: {{ $tenant->pivot->prepared_by ?? 'N/A' }}</div>
                                                <div>Verified by: {{ $tenant->pivot->verified_by ?? 'N/A' }}</div>
                                                <div>Approval date: {{ $tenant->pivot->approval_datetime ? date('d/m/Y h:i A', strtotime($tenant->pivot->approval_datetime)) : 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    <!-- Submit for Approval -->
                                                    @if($tenant->pivot->status === 'draft' || $tenant->pivot->status === 'rejected')
                                                        <form action="{{ route('checklist-tenant-m.approval', $tenant->pivot->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to submit for approval?')">
                                                            @csrf
                                                            <button type="submit" class="text-green-600 hover:text-green-900">
                                                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <a href="{{ route('checklist-tenant-m.show', $tenant->pivot->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('checklist-tenant-m.edit', $tenant->pivot->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500 text-center">No tenants associated with this checklist.</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>

            <!-- External Areas Tab Content -->
            <div id="content-external" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- External Area Conditions Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">3.0 External Area Conditions</h3>
                    
                    <div class="flex items-center space-x-4">
                        @if($checklist->externalAreaCondition)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ match(strtolower($checklist->externalAreaCondition->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst(str_replace('_', ' ', $checklist->externalAreaCondition->status) ?? 'Not Started') }}
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Not Started
                            </span>
                        @endif

                        <!-- For External Area Condition -->
                        @if($checklist->externalAreaCondition && (strtolower($checklist->externalAreaCondition->status) === 'draft' || strtolower($checklist->externalAreaCondition->status) === 'rejected'))
                            <button type="button" 
                                onclick="openApprovalModal('external', {{ $checklist->externalAreaCondition->id }}, 'External Area Condition for {{ $checklist->siteVisit->property->name ?? "Property" }}', '{{ route('checklist-external-area-condition-m.approval', $checklist->externalAreaCondition) }}')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit for Approval
                            </button>
                        @endif
                    </div>
                </div>

                <!-- External Area Conditions Details -->
                <div class="border-t border-gray-200">
                    <dl>
                        @if($checklist->externalAreaCondition)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.1 General Cleanliness</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_general_cleanliness_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_general_cleanliness_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_general_cleanliness_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_general_cleanliness_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->general_cleanliness_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->general_cleanliness_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.2 Fencing & Main Gate</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_fencing_gate_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_fencing_gate_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_fencing_gate_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_fencing_gate_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->fencing_gate_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->fencing_gate_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.3 External Facade</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_external_facade_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_external_facade_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_external_facade_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_external_facade_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->external_facade_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->external_facade_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.4 Car Park</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_car_park_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_car_park_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->car_park_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->car_park_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.5 Land Settlement</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_land_settlement_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_land_settlement_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_land_settlement_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_land_settlement_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->land_settlement_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->land_settlement_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.6 Rooftop</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_rooftop_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_rooftop_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_rooftop_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_rooftop_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->rooftop_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->rooftop_remarks }}</p>
                                    @endif
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">3.7 Drainage</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ isset($checklist->externalAreaCondition->is_drainage_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_drainage_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800') : 
                                            'bg-gray-100 text-gray-800' }}">
                                        {{ isset($checklist->externalAreaCondition->is_drainage_satisfied) ? 
                                            ($checklist->externalAreaCondition->is_drainage_satisfied ? 'Satisfactory' : 'Unsatisfactory') : 
                                            'N/A' }}
                                    </span>
                                    @if($checklist->externalAreaCondition->drainage_remarks)
                                    <p class="mt-2 text-sm text-gray-700">{{ $checklist->externalAreaCondition->drainage_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- External Remarks -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">External Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->externalAreaCondition->external_remarks ?? 'N/A' }}</dd>
                            </div>

                            <!-- Approval Information -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Approval Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div>Prepared by: {{ $checklist->externalAreaCondition->prepared_by ?? 'N/A' }}</div>
                                    <div>Verified by: {{ $checklist->externalAreaCondition->verified_by ?? 'N/A' }}</div>
                                    <div>Approved on: {{ $checklist->externalAreaCondition->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->externalAreaCondition->approval_datetime)) : 'N/A' }}</div>
                                </dd>
                            </div>

                            <!-- Remarks -->
                            @if($checklist->externalAreaCondition->remarks)
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->externalAreaCondition->remarks ?? 'N/A' }}</dd>
                            </div>
                            @endif
                        @else
                            <div class="bg-white px-4 py-5 sm:px-6">
                                <p class="text-sm text-gray-500 text-center">No external area condition information available for this checklist.</p>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    <a href="{{ route('checklist-external-area-condition-m.edit', $checklist->externalAreaCondition) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit External Area Conditions
                    </a>
                </div>
            </div>

            <!-- Internal Areas Tab Content -->
            <div id="content-internal" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Internal Area Conditions Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">4.0 Internal Area Conditions</h3>
                    
                    <div class="flex items-center space-x-4">
                        @if($checklist->internalAreaCondition)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ match(strtolower($checklist->internalAreaCondition->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst($checklist->internalAreaCondition->status ?? 'Not Started') }}
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Not Started
                            </span>
                        @endif

                        <!-- For Internal Area Condition -->
                        @if($checklist->internalAreaCondition && (strtolower($checklist->internalAreaCondition->status) === 'draft' || strtolower($checklist->internalAreaCondition->status) === 'rejected'))
                            <button type="button" 
                                onclick="openApprovalModal('internal', {{ $checklist->internalAreaCondition->id }}, 'Internal Area Condition for {{ $checklist->siteVisit->property->name ?? "Property" }}', '{{ route('checklist-internal-area-condition-m.approval', $checklist->internalAreaCondition) }}')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit for Approval
                            </button>
                        @endif
                    </div>
                </div>

                <!-- Internal Area Conditions Details -->
                <div class="border-t border-gray-200">
                    <dl>
                        @if($checklist->internalAreaCondition)
                            <!-- Door & Window -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.1 Door & Window</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_door_window_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_door_window_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_door_window_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->door_window_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->door_window_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Staircase -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.2 Staircase</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_staircase_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_staircase_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_staircase_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->staircase_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->staircase_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Toilet -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.3 Toilet</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_toilet_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_toilet_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_toilet_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->toilet_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->toilet_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Ceiling -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.4 Ceiling</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_ceiling_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_ceiling_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_ceiling_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->ceiling_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->ceiling_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Wall -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.5 Wall</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_wall_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_wall_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_wall_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->wall_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->wall_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Water Seeping/Leaking -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.6 Water Seeping/Leaking</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_water_seeping_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->water_seeping_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->water_seeping_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Loading Bay -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.7 Loading Bay</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_loading_bay_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->loading_bay_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->loading_bay_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Basement Car Park -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">4.8 Basement Car Park</dt>
                                <dd class="mt-1 text-sm sm:mt-0 sm:col-span-2">
                                    @if($checklist->internalAreaCondition->is_basement_car_park_satisfied !== null)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                        </span>
                                    @else
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                            N/A
                                        </span>
                                    @endif
                                    @if($checklist->internalAreaCondition->basement_car_park_remarks)
                                        <p class="mt-2 text-sm text-gray-700">{{ $checklist->internalAreaCondition->basement_car_park_remarks }}</p>
                                    @endif
                                </dd>
                            </div>

                            <!-- Internal Remarks -->
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Internal Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->internalAreaCondition->internal_remarks ?? 'N/A' }}</dd>
                            </div>

                            <!-- Approval Information -->
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Approval Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    <div>Prepared by: {{ $checklist->internalAreaCondition->prepared_by ?? 'N/A' }}</div>
                                    <div>Verified by: {{ $checklist->internalAreaCondition->verified_by ?? 'N/A' }}</div>
                                    <div>Approval date: {{ $checklist->internalAreaCondition->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->internalAreaCondition->approval_datetime)) : 'N/A' }}</div>
                                </dd>
                            </div>

                            <!-- Remarks -->
                            @if($checklist->internalAreaCondition->remarks)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->internalAreaCondition->remarks ?? 'N/A' }}</dd>
                            </div>
                            @endif
                        @else
                            <div class="bg-white px-4 py-5 sm:px-6">
                                <p class="text-sm text-gray-500 text-center">No internal area condition information available for this checklist.</p>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    @if($checklist->internalAreaCondition)
                    <a href="{{ route('checklist-internal-area-condition-m.edit', $checklist->internalAreaCondition) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Internal Area Conditions
                    </a>
                    @endif
                </div>
            </div>

            <!-- Property Development Tab Content -->
            <div id="content-development" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Property Development Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">5.0 Property Development</h3>
                    
                    <div class="flex items-center space-x-4">
                        @if($checklist->propertyDevelopment)
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                {{ match(strtolower($checklist->propertyDevelopment->status)) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'active' => 'bg-green-100 text-green-800',
                                    'inactive' => 'bg-gray-100 text-gray-800',
                                    'rejected' => 'bg-red-100 text-red-800',
                                    'draft' => 'bg-gray-100 text-gray-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst($checklist->propertyDevelopment->status ?? 'Not Started') }}
                            </span>
                        @else
                            <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                Not Started
                            </span>
                        @endif

                        <!-- For Property Development -->
                        @if($checklist->propertyDevelopment && (strtolower($checklist->propertyDevelopment->status) === 'draft' || strtolower($checklist->propertyDevelopment->status) === 'rejected'))
                            <button type="button" 
                                onclick="openApprovalModal('development', {{ $checklist->propertyDevelopment->id }}, 'Property Development for {{ $checklist->siteVisit->property->name ?? "Property" }}', '{{ route('checklist-property-development-m.approval', $checklist->propertyDevelopment) }}')"
                                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition ease-in-out duration-150">
                                <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Submit for Approval
                            </button>
                        @endif
                    </div>
                </div>
                
                <!-- Property Development Details -->
                <div class="border-t border-gray-200">
                    <dl>
                        <!-- Development/Expansion Section -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.1 Development/Expansion</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if(optional($checklist->propertyDevelopment)->development_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->propertyDevelopment->development_date)) }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->development_scope_of_work)
                                <div class="mt-1">Scope: {{ $checklist->propertyDevelopment->development_scope_of_work }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->development_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($checklist->propertyDevelopment->development_status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->propertyDevelopment->development_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!optional($checklist->propertyDevelopment)->development_date && 
                                    !optional($checklist->propertyDevelopment)->development_scope_of_work && 
                                    !optional($checklist->propertyDevelopment)->development_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        
                        <!-- Renovation Section -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.2 Renovation</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if(optional($checklist->propertyDevelopment)->renovation_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->propertyDevelopment->renovation_date)) }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->renovation_scope_of_work)
                                <div class="mt-1">Scope: {{ $checklist->propertyDevelopment->renovation_scope_of_work }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->renovation_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($checklist->propertyDevelopment->renovation_status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->propertyDevelopment->renovation_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!optional($checklist->propertyDevelopment)->renovation_date && 
                                    !optional($checklist->propertyDevelopment)->renovation_scope_of_work && 
                                    !optional($checklist->propertyDevelopment)->renovation_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        
                        <!-- External Repainting Section -->
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.3 External Repainting</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if(optional($checklist->propertyDevelopment)->external_repainting_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->propertyDevelopment->external_repainting_date)) }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->external_repainting_scope_of_work)
                                <div class="mt-1">Scope: {{ $checklist->propertyDevelopment->external_repainting_scope_of_work }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->external_repainting_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($checklist->propertyDevelopment->external_repainting_status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->propertyDevelopment->external_repainting_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!optional($checklist->propertyDevelopment)->external_repainting_date && 
                                    !optional($checklist->propertyDevelopment)->external_repainting_scope_of_work && 
                                    !optional($checklist->propertyDevelopment)->external_repainting_status)
                                N/A
                                @endif
                            </dd>
                        </div>

                        <!-- Others/Proposals/Approvals Section -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">5.5 Others/Proposals/Approvals</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                @if(optional($checklist->propertyDevelopment)->others_proposals_approvals_date)
                                <div>Date: {{ date('d/m/Y', strtotime($checklist->propertyDevelopment->others_proposals_approvals_date)) }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->others_proposals_approvals_scope_of_work)
                                <div class="mt-1">Scope: {{ $checklist->propertyDevelopment->others_proposals_approvals_scope_of_work }}</div>
                                @endif
                                @if(optional($checklist->propertyDevelopment)->others_proposals_approvals_status)
                                <div class="mt-1">Status: 
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ match(strtolower($checklist->propertyDevelopment->others_proposals_approvals_status)) {
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'active' => 'bg-green-100 text-green-800',
                                            'inactive' => 'bg-gray-100 text-gray-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            default => 'bg-gray-100 text-gray-800'
                                        } }}">
                                        {{ ucfirst(str_replace('_', ' ', $checklist->propertyDevelopment->others_proposals_approvals_status)) }}
                                    </span>
                                </div>
                                @endif
                                @if(!optional($checklist->propertyDevelopment)->others_proposals_approvals_date && 
                                    !optional($checklist->propertyDevelopment)->others_proposals_approvals_scope_of_work && 
                                    !optional($checklist->propertyDevelopment)->others_proposals_approvals_status)
                                N/A
                                @endif
                            </dd>
                        </div>
                        
                        <!-- Approval Information Section -->
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Information</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <div>Prepared by: {{ optional($checklist->propertyDevelopment)->prepared_by ?? 'N/A' }}</div>
                                <div>Verified by: {{ optional($checklist->propertyDevelopment)->verified_by ?? 'N/A' }}</div>
                                <div>Approved on: {{ optional($checklist->propertyDevelopment)->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->propertyDevelopment->approval_datetime)) : 'N/A' }}</div>
                            </dd>
                        </div>

                        <!-- Remarks -->
                        @if(optional($checklist->propertyDevelopment)->remarks)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ optional($checklist->propertyDevelopment)->remarks ?? 'N/A' }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                    @if($checklist->propertyDevelopment)
                    <a href="{{ route('checklist-property-development-m.edit', $checklist->propertyDevelopment) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Property Development
                    </a>
                    @else
                    <a href="{{ route('checklist-property-development-m.create', ['checklist' => $checklist->id]) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Create Property Development
                    </a>
                    @endif
                </div>
            </div>

            <!-- Disposal/Installation Tab Content -->
            <div id="content-installations" class="tab-content hidden bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Disposal/Installation Header -->
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">5.4 Disposal/Installation/Replacement</h3>
                    <!-- Button Add -->
                    <a href="{{ route('checklist-disposal-installation-m.create', $checklist) }}"
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add Disposal/Installation/Replacement
                    </a>
                </div>

                <!-- Disposal/Installation Details -->
                <div class="border-t border-gray-200">
                    @if($checklist->disposalInstallation && $checklist->disposalInstallation->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Name</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Details</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Information</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($checklist->disposalInstallation as $disposalInstallation)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                {{ $disposalInstallation->component_name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                <div>{{ $disposalInstallation->component_date ? $disposalInstallation->component_date->format('d/m/Y h:i A') : 'N/A' }}</div>
                                                <div>{{ ucfirst($disposalInstallation->component_status) }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($disposalInstallation->status)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($disposalInstallation->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst(str_replace('_', ' ', $disposalInstallation->status)) }}
                                                    </span>
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $disposalInstallation->remarks ?? 'N/A' }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                <div>Prepared by: {{ $disposalInstallation->prepared_by ?? 'N/A' }}</div>
                                                <div>Verified by: {{ $disposalInstallation->verified_by ?? 'N/A' }}</div>
                                                <div>Approval date: {{ $disposalInstallation->approval_datetime ? date('d/m/Y h:i A', strtotime($disposalInstallation->approval_datetime)) : 'N/A' }}</div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex justify-end space-x-2">
                                                    @if(strtolower($disposalInstallation->status) === 'draft' || strtolower($disposalInstallation->status) === 'rejected')
                                                        <button type="button" 
                                                            onclick="openApprovalModal('installation', {{ $disposalInstallation->id }}, '{{ $disposalInstallation->component_name }}', '{{ route('checklist-disposal-installation-m.approval', $disposalInstallation) }}')"
                                                            class="text-green-600 hover:text-green-900">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                            </svg>
                                                        </button>
                                                    @endif
                                                    <a href="{{ route('checklist-disposal-installation-m.show', $disposalInstallation) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                        </svg>
                                                    </a>
                                                    <a href="{{ route('checklist-disposal-installation-m.edit', $disposalInstallation) }}" class="text-indigo-600 hover:text-indigo-900">
                                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                                        </svg>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="bg-white px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500 text-center">No disposal/installation information available for this checklist.</p>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="p-4 flex justify-end space-x-2 border-t border-gray-50">
                    <a href="{{ route('checklist-m.index', $checklist->siteVisit->property) }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                        </svg>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Universal Submit for Approval Modal -->
    <div id="approvalModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-medium text-gray-900">Confirm Submission</h3>
                <button type="button" onclick="closeApprovalModal()" class="text-gray-400 hover:text-gray-500">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <p class="mb-2 text-sm text-gray-500">You are about to submit for approval: <span id="approvalItemType" class="font-medium text-gray-700"></span></p>
            <p class="mb-4 text-sm font-medium text-gray-900" id="approvalItemName"></p>
            
            <form id="approvalForm" action="" method="POST">
                @csrf
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeApprovalModal()" class="px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </button>
                    <button type="submit" class="px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        Confirm Submission
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- JavaScript for Universal Approval Modal -->
    <script>
        // Function to open the approval modal for any item type
        function openApprovalModal(itemType, itemId, itemName, formAction) {
            // Set the modal content based on item type
            let typeDisplay = '';
            switch(itemType) {
                case 'tenant':
                    typeDisplay = 'Tenant Record';
                    break;
                case 'checklist':
                    typeDisplay = 'Checklist';
                    break;
                case 'legal':
                    typeDisplay = 'Legal Documentation';
                    break;
                case 'external':
                    typeDisplay = 'External Area Condition';
                    break;
                case 'internal':
                    typeDisplay = 'Internal Area Condition';
                    break;
                case 'development':
                    typeDisplay = 'Property Development';
                    break;
                case 'installation':
                    typeDisplay = 'Installation/Disposal Item';
                    break;
                default:
                    typeDisplay = 'Item';
            }
            
            // Update the modal content
            document.getElementById('approvalItemType').textContent = typeDisplay;
            document.getElementById('approvalItemName').textContent = itemName;
            document.getElementById('approvalForm').action = formAction;
            
            // Show the modal
            document.getElementById('approvalModal').classList.remove('hidden');
        }
        
        // Function to close the modal
        function closeApprovalModal() {
            document.getElementById('approvalModal').classList.add('hidden');
            document.getElementById('submission_notes').value = '';
        }
        
        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('approvalModal');
            const modalContent = document.querySelector('#approvalModal > div');
            
            if (modal && !modal.classList.contains('hidden') && event.target === modal) {
                closeApprovalModal();
            }
        });
        
        // Close modal on Escape key press
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeApprovalModal();
            }
        });
    </script>

    <!-- Tab Switching JavaScript -->
    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Show the selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Update tab styles
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-indigo-500', 'text-indigo-600');
                button.classList.add('border-transparent', 'text-gray-500');
            });
            
            document.getElementById('tab-' + tabName).classList.remove('border-transparent', 'text-gray-500');
            document.getElementById('tab-' + tabName).classList.add('border-indigo-500', 'text-indigo-600');
        }
    </script>
</x-app-layout>
