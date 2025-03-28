<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Checklist Details') }}
            </h2>
            <a href="{{ route('checklists.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- General Property Information -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">1</span>
                            General Property Information
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Property Title</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->property_title ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Property Location</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->property_location ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Legal Documentation -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">2</span>
                            Legal Documentation
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Title Reference</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->title_ref ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Title Location</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->title_location ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Trust Deed Reference</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->trust_deed_ref ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Trust Deed Location</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->trust_deed_location ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Sale Purchase Agreement</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->sale_purchase_agreement ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Lease Agreement Reference</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->lease_agreement_ref ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Lease Agreement Location</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->lease_agreement_location ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Agreement to Lease</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->agreement_to_lease ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Maintenance Agreement Ref</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->maintenance_agreement_ref ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Maintenance Agreement Location</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->maintenance_agreement_location ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Development Agreement</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->development_agreement ?? 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Other Legal Documents</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->other_legal_docs ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tenancy Agreement -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">3</span>
                            Tenancy Agreement
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenant Name</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->tenant_name ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenant Property</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->tenant_property ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenancy Approval Date</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->tenancy_approval_date ? $checklist->tenancy_approval_date->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenancy Commencement Date</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->tenancy_commencement_date ? $checklist->tenancy_commencement_date->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Tenancy Expiry Date</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->tenancy_expiry_date ? $checklist->tenancy_expiry_date->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- External Area Conditions -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">4</span>
                            External Area Conditions
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">General Cleanliness</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_general_cleanliness_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_general_cleanliness_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Fencing & Gate</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_fencing_gate_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_fencing_gate_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">External Facade</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_external_facade_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_external_facade_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Car Park</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_car_park_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Land Settlement</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_land_settlement_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_land_settlement_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Rooftop</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_rooftop_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_rooftop_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Drainage</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_drainage_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_drainage_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="md:col-span-3">
                                    <p class="text-xs font-medium text-gray-500">External Remarks</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->external_remarks ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Internal Area Conditions -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">5</span>
                            Internal Area Conditions
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Doors & Windows</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_door_window_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_door_window_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Staircase</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_staircase_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_staircase_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Toilets</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_toilet_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_toilet_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Ceiling</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_ceiling_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_ceiling_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Wall</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_wall_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_wall_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Water Seeping</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_water_seeping_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_water_seeping_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Loading Bay</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_loading_bay_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_loading_bay_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Basement Car Park</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $checklist->is_basement_car_park_satisfied ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ $checklist->is_basement_car_park_satisfied ? 'Satisfied' : 'Not Satisfied' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="md:col-span-3">
                                    <p class="text-xs font-medium text-gray-500">Internal Remarks</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->internal_remarks ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Property Development -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">6</span>
                            Property Development
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Development/Expansion Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->development_expansion_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Renovation Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->renovation_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">External Repainting Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->external_repainting_status ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Disposal/Installation/Replacement -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">7</span>
                            Disposal/Installation/Replacement
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Water Tank Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->water_tank_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Air Conditioning Approval Date</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->air_conditioning_approval_date ? $checklist->air_conditioning_approval_date->format('d/m/Y') : 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Air Conditioning Scope</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->air_conditioning_scope ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Air Conditioning Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->air_conditioning_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Lift/Escalator Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->lift_escalator_status ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Fire System Status</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->fire_system_status ?? 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Other Property</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->other_property ?? 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Other Proposals/Approvals</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->other_proposals_approvals ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Related Records -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">8</span>
                            Related Records
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Site Visit ID</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->site_visit_id ?? 'None' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- System Information -->
                    <div class="mb-8">
                        <h4 class="text-md font-medium text-gray-900 mb-2 flex items-center">
                            <span class="bg-gray-200 text-gray-700 w-7 h-7 rounded-full flex items-center justify-center mr-2">9</span>
                            System Information
                        </h4>
                        <div class="bg-gray-50 rounded-md overflow-hidden border">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Status</p>
                                    <p class="text-sm text-gray-900">
                                        <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                            {{ $checklist->status === 'approved' ? 'bg-green-100 text-green-800' : 
                                            ($checklist->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            {{ ucfirst($checklist->status ?? 'Pending') }}
                                        </span>
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Prepared By</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->prepared_by ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Verified By</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->verified_by ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Approval Date/Time</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->approval_datetime ? $checklist->approval_datetime->format('d/m/Y h:i A') : 'N/A' }}</p>
                                </div>
                                <div class="md:col-span-2">
                                    <p class="text-xs font-medium text-gray-500">Remarks</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->remarks ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Created at</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->created_at->format('d/m/Y h:i A') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500">Updated at</p>
                                    <p class="text-sm text-gray-900">{{ $checklist->updated_at->format('d/m/Y h:i A') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                        <div class="flex justify-end gap-x-4">
                            <a href="{{ route('checklists.index') }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                </svg>
                                Back to List
                            </a>
                            <a href="{{ route('checklists.edit', $checklist) }}" 
                            class="inline-flex items-center justify-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-300">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                </svg>
                                Edit Checklist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>