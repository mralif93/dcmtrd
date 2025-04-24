<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Property Development Details') }}
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
                    <h3 class="text-lg font-medium text-gray-900">Property Development for: {{ $propertyDevelopment->checklist->siteVisit->property->name }}</h3>
                </div>

                <!-- Status Section -->
                <div class="border-t border-gray-200">
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Status</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match(strtolower($propertyDevelopment->status ?? '')) {
                                        'completed' => 'bg-green-100 text-green-800',
                                        'in_progress' => 'bg-blue-100 text-blue-800',
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        default => 'bg-gray-100 text-gray-800'
                                    } }}">
                                    {{ ucfirst(str_replace('_', ' ', $propertyDevelopment->status ?? 'Not Started')) }}
                                </span>
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Property Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Property Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property Name</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                <a href="{{ route('property-m.show', $propertyDevelopment->checklist->siteVisit->property->id) }}" class="text-indigo-600 hover:text-indigo-900">
                                    {{ $propertyDevelopment->checklist->siteVisit->property->name }}
                                </a>
                            </dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property Address</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->checklist->siteVisit->property->address }}</dd>
                        </div>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Property Type</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->checklist->siteVisit->property->category ?? 'N/A' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Development/Expansion Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Development/Expansion</h3>
                    </div>
                    <dl>
                        @if($propertyDevelopment->development_date || $propertyDevelopment->development_scope_of_work || $propertyDevelopment->development_status)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->development_date ? date('d/m/Y', strtotime($propertyDevelopment->development_date)) : 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Scope of Work</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->development_scope_of_work ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($propertyDevelopment->development_status)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ match(strtolower($propertyDevelopment->development_status)) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst(str_replace('_', ' ', $propertyDevelopment->development_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                        @else
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">No development/expansion information available</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Renovation Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Renovation</h3>
                    </div>
                    <dl>
                        @if($propertyDevelopment->renovation_date || $propertyDevelopment->renovation_scope_of_work || $propertyDevelopment->renovation_status)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->renovation_date ? date('d/m/Y', strtotime($propertyDevelopment->renovation_date)) : 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Scope of Work</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->renovation_scope_of_work ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($propertyDevelopment->renovation_status)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ match(strtolower($propertyDevelopment->renovation_status)) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst(str_replace('_', ' ', $propertyDevelopment->renovation_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                        @else
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">No renovation information available</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- External Repainting Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">External Repainting</h3>
                    </div>
                    <dl>
                        @if($propertyDevelopment->external_repainting_date || $propertyDevelopment->external_repainting_scope_of_work || $propertyDevelopment->external_repainting_status)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->external_repainting_date ? date('d/m/Y', strtotime($propertyDevelopment->external_repainting_date)) : 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Scope of Work</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->external_repainting_scope_of_work ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($propertyDevelopment->external_repainting_status)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ match(strtolower($propertyDevelopment->external_repainting_status)) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst(str_replace('_', ' ', $propertyDevelopment->external_repainting_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                        @else
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">No external repainting information available</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Others/Proposals/Approvals Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Others/Proposals/Approvals</h3>
                    </div>
                    <dl>
                        @if($propertyDevelopment->others_proposals_approvals_date || $propertyDevelopment->others_proposals_approvals_scope_of_work || $propertyDevelopment->others_proposals_approvals_status)
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Date</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->others_proposals_approvals_date ? date('d/m/Y', strtotime($propertyDevelopment->others_proposals_approvals_date)) : 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Scope of Work</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    {{ $propertyDevelopment->others_proposals_approvals_scope_of_work ?? 'N/A' }}
                                </dd>
                            </div>
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                                    @if($propertyDevelopment->others_proposals_approvals_status)
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full
                                            {{ match(strtolower($propertyDevelopment->others_proposals_approvals_status)) {
                                                'completed' => 'bg-green-100 text-green-800',
                                                'in_progress' => 'bg-blue-100 text-blue-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                default => 'bg-gray-100 text-gray-800'
                                            } }}">
                                            {{ ucfirst(str_replace('_', ' ', $propertyDevelopment->others_proposals_approvals_status)) }}
                                        </span>
                                    @else
                                        N/A
                                    @endif
                                </dd>
                            </div>
                        @else
                            <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                <dt class="text-sm font-medium text-gray-500">Information</dt>
                                <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">No additional proposals or approvals information available</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Remarks Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Remarks</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Remarks</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->remarks ?? 'No remarks available' }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Verification & System Information Section -->
                <div class="border-t border-gray-200">
                    <div class="px-4 py-5 sm:px-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Verification & System Information</h3>
                    </div>
                    <dl>
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Prepared By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->prepared_by ?? 'Not specified' }}</dd>
                        </div>
                        <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Verified By</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->verified_by ?? 'Not verified yet' }}</dd>
                        </div>
                        @if($propertyDevelopment->approval_datetime)
                        <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Approval Date & Time</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ \Carbon\Carbon::parse($propertyDevelopment->approval_datetime)->format('d/m/Y h:i A') }}</dd>
                        </div>
                        @endif
                        <div class="{{ $propertyDevelopment->approval_datetime ? 'bg-white' : 'bg-gray-50' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Created At</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->created_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                        <div class="{{ $propertyDevelopment->approval_datetime ? 'bg-gray-50' : 'bg-white' }} px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                            <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                            <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $propertyDevelopment->updated_at->format('d/m/Y h:i A') }}</dd>
                        </div>
                    </dl>
                </div>

                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('checklist-m.show', $propertyDevelopment->checklist) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to Checklist
                        </a>
                        <a href="{{ route('checklist-property-development-m.edit', $propertyDevelopment) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                            Edit Property Development
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>