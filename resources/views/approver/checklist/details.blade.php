<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checklist Details') }}
        </h2>
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Header Section -->
                <div class="px-4 py-5 sm:px-6">
                    <div class="flex justify-between items-center">
                        <h3 class="text-lg font-medium text-gray-900">
                            Checklist for Site Visit: {{ $checklist->siteVisit->property->name }}
                        </h3>
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
                    </div>
                </div>

                <!-- Site Visit Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Site Visit Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{ route('property-m.show', $checklist->siteVisit->property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $checklist->siteVisit->property->name }}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Visit Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ date('d/m/Y', strtotime($checklist->siteVisit->date_visit)) }}
                            </dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Visit Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ date('h:i A', strtotime($checklist->siteVisit->time_visit)) }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Legal Documentation Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">1.0 Legal Documentation</h3>

                        <div class="flex items-center space-x-4">
                            <!-- Status badge -->
                            @if($checklist->legalDocumentation)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->legalDocumentation->status ?? 'pending')) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->legalDocumentation->status ?? 'Pending') }}
                                </span>
                            @endif

                            <!-- Action Buttons for Legal Documentation Section -->
                            @if($checklist->legalDocumentation && strtolower($checklist->legalDocumentation->status) === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('checklist-legal-a.approve', $checklist->legalDocumentation) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" 
                                        onclick="openRejectModal('legal', '{{ $checklist->legalDocumentation->id }}', 'Legal Documentation - {{ $checklist->siteVisit->property->name ?? 'N/A' }}', '{{ route('checklist-legal-a.reject', $checklist->legalDocumentation) }}')" 
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($checklist->legalDocumentation)
                        <dl>
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
                                <dt class="text-sm font-medium text-gray-500">Sale Purchase Agreement Reference</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $checklist->legalDocumentation->sale_purchase_agreement_ref ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Sale Purchase Agreement Location</dt>
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
                        </dl>

                        <!-- Legal Documentation Administrative Details -->
                        <div class="mt-4 px-6 py-4 bg-white">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Prepared By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->legalDocumentation->prepared_by ?? 'N/A' }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Verified By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->legalDocumentation->verified_by ?? 'N/A' }}</div>
                                </div>
                                
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Approval Date</div>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $checklist->legalDocumentation && $checklist->legalDocumentation->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->legalDocumentation->approval_datetime)) : 'N/A' }}
                                    </div>
                                </div>
                                
                                @if($checklist->legalDocumentation->remarks)
                                <div class="md:col-span-2">
                                    <div class="text-sm font-medium text-gray-500">Remarks</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->legalDocumentation->remarks }}</div>
                                </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No legal documentation information available.</p>
                        </div>
                    @endif
                </div>

                <!-- Tenants Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">2.0 Tenants</h3>
                    </div>

                    @if($checklist->tenants->count() > 0)
                        <div class="px-4 py-5 sm:px-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tenant Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Notes</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Information</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($checklist->tenants as $tenant)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $tenant->name }}
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $tenant->pivot->notes ?? 'No notes available' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div>Prepared By: {{ $tenant->pivot->prepared_by ?? 'N/A' }}</div>
                                                    <div>Verified By: {{ $tenant->pivot->verified_by ?? 'N/A' }}</div>
                                                    <div>Approval Date: {{ $tenant->pivot->approval_datetime ? date('d/m/Y h:i A', strtotime($tenant->pivot->approval_datetime)) : 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($tenant->pivot->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            'draft' => 'bg-gray-100 text-gray-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($tenant->pivot->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if(strtolower($tenant->pivot->status) === 'pending')
                                                        <div class="flex space-x-2">
                                                            <form action="{{ route('checklist-tenant-a.approve', $tenant->pivot->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    Approve
                                                                </button>
                                                            </form>
                                                            <button type="button" 
                                                                onclick="openRejectModal('tenant', '{{ $tenant->pivot->id }}', 'Tenant - {{ $tenant->name }}', '{{ route('checklist-tenant-a.reject', $tenant->pivot->id) }}')" 
                                                                class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Reject
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($tenant->remarks)
                                                <tr>
                                                    <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="text-sm font-medium text-gray-500">Remarks: {{ $tenant->pivot->remarks }}</div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No tenants associated with this checklist.</p>
                        </div>
                    @endif
                </div>

                <!-- External Area Conditions Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">3.0 External Area Conditions</h3>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Status badge -->
                            @if($checklist->externalAreaCondition)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->externalAreaCondition->status ?? 'pending')) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->externalAreaCondition->status ?? 'Pending') }}
                                </span>
                            @endif

                            <!-- Action Buttons for External Area Condition Section -->
                            @if($checklist->externalAreaCondition && strtolower($checklist->externalAreaCondition->status) === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('checklist-external-area-condition-a.approve', $checklist->externalAreaCondition->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" 
                                        onclick="openRejectModal('external', '{{ $checklist->externalAreaCondition->id }}', 'External Area Condition - {{ $checklist->siteVisit->property->name ?? 'N/A' }}', '{{ route('checklist-external-area-condition-a.reject', $checklist->externalAreaCondition->id) }}')" 
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($checklist->externalAreaCondition)
                        <div class="px-4 py-5 sm:px-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y border border-gray-200 divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inspection Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- General Cleanliness -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.1 General Cleanliness
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_general_cleanliness_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_general_cleanliness_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_general_cleanliness_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->general_cleanliness_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Fencing & Gate -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.2 Fencing & Gates
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_fencing_gate_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_fencing_gate_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_fencing_gate_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->fencing_gate_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- External Facade -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.3 External Facade
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_external_facade_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_external_facade_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_external_facade_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->external_facade_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Car Park -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.4 Car Park
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_car_park_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->car_park_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Land Settlement -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.5 Land Settlement
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_land_settlement_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_land_settlement_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_land_settlement_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->land_settlement_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Rooftop -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.6 Rooftop
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_rooftop_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_rooftop_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_rooftop_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->rooftop_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Drainage -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                3.7 Drainage
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->externalAreaCondition->is_drainage_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->externalAreaCondition->is_drainage_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->externalAreaCondition->is_drainage_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->drainage_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>

                                        <!-- External Remarks -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                External Remarks
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $checklist->externalAreaCondition->external_remarks ?? 'N/A' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Additional remarks -->
                        @if($checklist->externalAreaCondition->external_remarks)
                            <div class="mt-4 px-6 py-4 bg-gray-50">
                                <div class="text-sm font-medium text-gray-500">Additional Remarks</div>
                                <div class="mt-2 text-sm text-gray-900">
                                    {{ $checklist->externalAreaCondition->external_remarks }}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Administrative details -->
                        <div class="mt-4 px-6 py-4 bg-white">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Prepared By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->externalAreaCondition->prepared_by ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Verified By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->externalAreaCondition->verified_by ?? 'N/A' }}</div>
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Approval Date</div>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $checklist->externalAreaCondition->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->externalAreaCondition->approval_datetime)) : 'N/A' }}
                                    </div>
                                </div>
                                <div class="md:col-span-2">
                                    <div class="text-sm font-medium text-gray-500">Remarks</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->externalAreaCondition->remarks ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No external area condition information available.</p>
                        </div>
                    @endif
                </div>

                <!-- Internal Area Conditions Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">4.0 Internal Area Conditions</h3>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Status badge -->
                            @if($checklist->internalAreaCondition)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->internalAreaCondition->status ?? 'N/A')) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->internalAreaCondition->status ?? 'N/A') }}
                                </span>
                            @endif

                            <!-- Action Buttons for Internal Area Condition Section -->
                            @if($checklist->internalAreaCondition && strtolower($checklist->internalAreaCondition->status) === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('checklist-internal-area-condition-a.approve', $checklist->internalAreaCondition->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" 
                                        onclick="openRejectModal('internal', '{{ $checklist->internalAreaCondition->id }}', 'Internal Area Condition - {{ $checklist->siteVisit->property->name ?? 'N/A' }}', '{{ route('checklist-internal-area-condition-a.reject', $checklist->internalAreaCondition->id) }}')" 
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($checklist->internalAreaCondition)
                        <div class="px-4 py-5 sm:px-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full border border-gray-200 divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Inspection Item</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <!-- Doors & Windows -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.1 Doors & Windows
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_door_window_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_door_window_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_door_window_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->door_window_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Staircase -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.2 Staircase
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_staircase_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_staircase_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_staircase_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->staircase_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Toilet -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.3 Toilet
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_toilet_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_toilet_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_toilet_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->toilet_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Ceiling -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.4 Ceiling
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_ceiling_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_ceiling_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_ceiling_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->ceiling_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Wall -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.5 Wall
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_wall_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_wall_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_wall_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->wall_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Water Seeping -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.6 Water Seeping
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_water_seeping_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_water_seeping_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->water_seeping_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Loading Bay -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.7 Loading Bay
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_loading_bay_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_loading_bay_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->loading_bay_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>
                                        
                                        <!-- Basement Car Park -->
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                4.8 Basement Car Park
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($checklist->internalAreaCondition->is_basement_car_park_satisfied !== null)
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                        {{ $checklist->internalAreaCondition->is_basement_car_park_satisfied ? 'Satisfactory' : 'Unsatisfactory' }}
                                                    </span>
                                                @else
                                                    <span class="text-gray-400">Not checked</span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                {{ $checklist->internalAreaCondition->basement_car_park_remarks ?? 'No remarks' }}
                                            </td>
                                        </tr>

                                        <!-- Internal Remarks -->
                                        <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            Internal Remarks
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->internalAreaCondition->internal_remarks ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                        <!-- Additional remarks -->
                        @if($checklist->internalAreaCondition->internal_remarks)
                            <div class="mt-4 px-6 py-4 bg-gray-50">
                                <div class="text-sm font-medium text-gray-500">Additional Remarks</div>
                                <div class="mt-2 text-sm text-gray-900">
                                    {{ $checklist->internalAreaCondition->internal_remarks }}
                                </div>
                            </div>
                        @endif
                        
                        <!-- Administrative details -->
                        <div class="mt-4 px-6 py-4 bg-white">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Prepared By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->internalAreaCondition->prepared_by ?? 'N/A' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-500">Verified By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->internalAreaCondition->verified_by ?? 'N/A' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-500">Approval Date</div>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $checklist->internalAreaCondition->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->internalAreaCondition->approval_datetime)) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="text-sm font-medium text-gray-500">Remarks</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->internalAreaCondition->remarks ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No internal area condition information available.</p>
                        </div>
                    @endif
                </div>

                <!-- Property Development Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">5.0 Property Development</h3>
                        
                        <div class="flex items-center space-x-4">
                            <!-- Status badge -->
                            @if($checklist->propertyDevelopment)
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($checklist->propertyDevelopment->status ?? 'N/A')) {
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'active' => 'bg-green-100 text-green-800',
                                        'inactive' => 'bg-gray-100 text-gray-800',
                                        'rejected' => 'bg-red-100 text-red-800',
                                        'draft' => 'bg-gray-100 text-gray-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst($checklist->propertyDevelopment->status ?? 'N/A') }}
                                </span>
                            @endif

                            <!-- Action Buttons for Property Development Section -->
                            @if($checklist->propertyDevelopment && strtolower($checklist->propertyDevelopment->status) === 'pending')
                                <div class="flex space-x-2">
                                    <form action="{{ route('checklist-property-development-a.approve', $checklist->propertyDevelopment->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-500 border border-transparent rounded-md font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                            </svg>
                                            Approve
                                        </button>
                                    </form>
                                    <button type="button" 
                                        onclick="openRejectModal('property-development', '{{ $checklist->propertyDevelopment->id }}', 'Property Development - {{ $checklist->siteVisit->property->name ?? 'N/A' }}', '{{ route('checklist-property-development-a.reject', $checklist->propertyDevelopment->id) }}')" 
                                        class="inline-flex items-center px-4 py-2 bg-red-500 border border-transparent rounded-md font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                        Reject
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($checklist->propertyDevelopment)
                        <!-- Property Development Table -->
                        <div class="overflow-x-auto p-6">
                            <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scope of Work</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <!-- Development -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5.1 Development</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->development_date ? date('d/m/Y', strtotime($checklist->propertyDevelopment->development_date)) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->development_scope_of_work ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->development_status ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    
                                    <!-- Renovation -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5.2 Renovation</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->renovation_date ? date('d/m/Y', strtotime($checklist->propertyDevelopment->renovation_date)) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->renovation_scope_of_work ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->renovation_status ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    
                                    <!-- External Repainting -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5.3 External Repainting</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->external_repainting_date ? date('d/m/Y', strtotime($checklist->propertyDevelopment->external_repainting_date)) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->external_repainting_scope_of_work ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->external_repainting_status ?? 'N/A' }}
                                        </td>
                                    </tr>
                                    
                                    <!-- Others/Proposals/Approvals -->
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">5.4 Others/Proposals</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->others_proposals_approvals_date ? date('d/m/Y', strtotime($checklist->propertyDevelopment->others_proposals_approvals_date)) : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->others_proposals_approvals_scope_of_work ?? 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $checklist->propertyDevelopment->others_proposals_approvals_status ?? 'N/A' }}
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Administrative details -->
                        <div class="mt-4 px-6 py-4 bg-white">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm font-medium text-gray-500">Prepared By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->propertyDevelopment->prepared_by ?? 'N/A' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-500">Verified By</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->propertyDevelopment->verified_by ?? 'N/A' }}</div>
                                </div>

                                <div>
                                    <div class="text-sm font-medium text-gray-500">Approval Date</div>
                                    <div class="mt-1 text-sm text-gray-900">
                                        {{ $checklist->propertyDevelopment->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->propertyDevelopment->approval_datetime)) : 'N/A' }}
                                    </div>
                                </div>

                                <div class="md:col-span-2">
                                    <div class="text-sm font-medium text-gray-500">Remarks</div>
                                    <div class="mt-1 text-sm text-gray-900">{{ $checklist->propertyDevelopment->remarks ?? 'N/A' }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No property development information available.</p>
                        </div>
                    @endif
                </div>

                <!-- Disposal/Installation Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">5.4 Disposal/Installation/Replacement Items</h3>
                    </div>
                    
                    @if($checklist->disposalInstallation->count() > 0)
                        <div class="px-4 py-5 sm:px-6">
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 border border-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Component Details</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scope of Work</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Approval Information</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($checklist->disposalInstallation as $item)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $item->component_name ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div>Date: {{ $item->component_date ? date('d/m/Y', strtotime($item->component_date)) : 'N/A' }}</div>
                                                    <div>Status: {{ ucfirst($item->component_status ?? 'N/A') }}</div>
                                                </td>
                                                <td class="px-6 py-4 text-sm text-gray-500">
                                                    {{ $item->component_scope_of_work ?? 'N/A' }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <div>Prepared By: {{ $item->prepared_by ?? 'N/A' }}</div>
                                                    <div>Verified By: {{ $item->verified_by ?? 'N/A' }}</div>
                                                    <div>Approval Date: {{ $item->approval_datetime ? date('d/m/Y h:i A', strtotime($item->approval_datetime)) : 'N/A' }}</div>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                        {{ match(strtolower($item->status)) {
                                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                                            'active' => 'bg-green-100 text-green-800',
                                                            'inactive' => 'bg-gray-100 text-gray-800',
                                                            'rejected' => 'bg-red-100 text-red-800',
                                                            'draft' => 'bg-gray-100 text-gray-800',
                                                            default => 'bg-gray-100 text-gray-800'
                                                        } }}">
                                                        {{ ucfirst($item->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    @if(strtolower($item->status) === 'pending')
                                                        <div class="flex space-x-2">
                                                            <form action="{{ route('checklist-disposal-installation-a.approve', $item->id) }}" method="POST" class="inline">
                                                                @csrf
                                                                <button type="submit" class="inline-flex items-center px-3 py-1 bg-green-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    Approve
                                                                </button>
                                                            </form>
                                                            <button type="button" 
                                                                onclick="openRejectModal('disposal-installation', '{{ $item->id }}', 'Disposal/Installation - {{ $item->component_name }}', '{{ route('checklist-disposal-installation-a.reject', $item->id) }}')" 
                                                                class="inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md text-xs font-medium text-white hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                                </svg>
                                                                Reject
                                                            </button>
                                                        </div>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($item->remarks)
                                                <tr>
                                                    <td colspan="6" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                        <div class="text-sm font-medium text-gray-500">Remarks: {{ $item->remarks }}</div>
                                                    </td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="px-4 py-5 sm:px-6">
                            <p class="text-sm text-gray-500">No disposal/installation items available.</p>
                        </div>
                    @endif
                </div>

                <!-- Administrative Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Administrative Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->prepared_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->verified_by ?? 'N/A' }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                {{ $checklist->approval_datetime ? date('d/m/Y h:i A', strtotime($checklist->approval_datetime)) : 'Not yet approved' }}
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">General Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $checklist->remarks ?? 'No remarks available' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">System Information</h3>
                    </div>
                    <dl>
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
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <div>
                            <a href="{{ route('checklist-a.main', ['status' => $checklist->status]) }}" 
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
        </div>
    </div>
</x-app-layout>

<!-- Rejection Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center hidden z-50">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
            <div class="sm:flex sm:items-start">
                <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                    <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                    <h3 class="text-lg leading-6 font-medium text-gray-900" id="rejectModalTitle">Reject Item</h3>
                    <div class="mt-2">
                        <p class="text-sm text-gray-500">Please provide a reason for rejecting this item.</p>
                    </div>
                </div>
            </div>
            
            <form id="rejectForm" method="POST" action="">
                @csrf
                <div class="mt-4">
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700">Rejection Reason</label>
                    <textarea id="rejection_reason" name="rejection_reason" rows="3" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required></textarea>
                    
                    <input type="hidden" id="rejectItemId" name="id" value="">
                    <input type="hidden" id="rejectItemType" name="type" value="">
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse mt-4">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Reject
                    </button>
                    <button type="button" onclick="closeRejectModal()" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript for Modal Functionality -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Close modal if ESC key is pressed
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' && !document.getElementById('rejectModal').classList.contains('hidden')) {
                closeRejectModal();
            }
        });
        
        // Close modal if clicked outside
        document.getElementById('rejectModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRejectModal();
            }
        });
    });
    
    function openRejectModal(section, id, title, formAction = null) {
        // Set modal title
        document.getElementById('rejectModalTitle').textContent = 'Reject ' + title;
        
        // Set form action URL - either use provided URL or construct one
        if (formAction) {
            document.getElementById('rejectForm').action = formAction;
        } else {
            // Construct URL based on section and ID
            let baseUrl = '/approver/';
            switch(section) {
                case 'legal':
                    document.getElementById('rejectForm').action = `${baseUrl}checklist-legal-documentation/${id}/reject`;
                    break;
                case 'external':
                    document.getElementById('rejectForm').action = `${baseUrl}checklist-external-area/${id}/reject`;
                    break;
                case 'internal':
                    document.getElementById('rejectForm').action = `${baseUrl}checklist-internal-area/${id}/reject`;
                    break;
                case 'development':
                    document.getElementById('rejectForm').action = `${baseUrl}checklist-property-development/${id}/reject`;
                    break;
                case 'installation':
                    document.getElementById('rejectForm').action = `${baseUrl}checklist-installation/${id}/reject`;
                    break;
                default:
                    document.getElementById('rejectForm').action = `${baseUrl}checklist/${id}/reject`;
            }
        }
        
        // Store section and ID in hidden fields
        document.getElementById('rejectItemType').value = section;
        document.getElementById('rejectItemId').value = id;
        
        // Clear previous remarks
        document.getElementById('rejection_reason').value = '';
        
        // Show modal
        document.getElementById('rejectModal').classList.remove('hidden');
        
        // Focus on the remarks textarea
        document.getElementById('rejection_reason').focus();
    }
    
    function closeRejectModal() {
        document.getElementById('rejectModal').classList.add('hidden');
    }
</script>
