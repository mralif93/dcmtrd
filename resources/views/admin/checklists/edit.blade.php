<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Checklist') }}
            </h2>
            <a href="{{ route('checklists.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('checklists.update', $checklist) }}" method="POST" class="space-y-8">
                        @csrf
                        @method('PUT')

                        <!-- General Property Info -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">1. General Property Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="property_title" class="block text-sm font-medium text-gray-700">{{ __('Property Title') }}</label>
                                    <input type="text" name="property_title" id="property_title" value="{{ old('property_title', $checklist->property_title) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('property_title')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="property_location" class="block text-sm font-medium text-gray-700">{{ __('Property Location') }}</label>
                                    <input type="text" name="property_location" id="property_location" value="{{ old('property_location', $checklist->property_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('property_location')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Legal Documentation section (1.0) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">2. Legal Documentation</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="title_ref" class="block text-sm font-medium text-gray-700">{{ __('Title Reference') }}</label>
                                    <input type="text" name="title_ref" id="title_ref" value="{{ old('title_ref', $checklist->title_ref) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="title_location" class="block text-sm font-medium text-gray-700">{{ __('Title Location') }}</label>
                                    <input type="text" name="title_location" id="title_location" value="{{ old('title_location', $checklist->title_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="trust_deed_ref" class="block text-sm font-medium text-gray-700">{{ __('Trust Deed Reference') }}</label>
                                    <input type="text" name="trust_deed_ref" id="trust_deed_ref" value="{{ old('trust_deed_ref', $checklist->trust_deed_ref) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="trust_deed_location" class="block text-sm font-medium text-gray-700">{{ __('Trust Deed Location') }}</label>
                                    <input type="text" name="trust_deed_location" id="trust_deed_location" value="{{ old('trust_deed_location', $checklist->trust_deed_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="sale_purchase_agreement" class="block text-sm font-medium text-gray-700">{{ __('Sale Purchase Agreement') }}</label>
                                    <input type="text" name="sale_purchase_agreement" id="sale_purchase_agreement" value="{{ old('sale_purchase_agreement', $checklist->sale_purchase_agreement) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="lease_agreement_ref" class="block text-sm font-medium text-gray-700">{{ __('Lease Agreement Reference') }}</label>
                                    <input type="text" name="lease_agreement_ref" id="lease_agreement_ref" value="{{ old('lease_agreement_ref', $checklist->lease_agreement_ref) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="lease_agreement_location" class="block text-sm font-medium text-gray-700">{{ __('Lease Agreement Location') }}</label>
                                    <input type="text" name="lease_agreement_location" id="lease_agreement_location" value="{{ old('lease_agreement_location', $checklist->lease_agreement_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="agreement_to_lease" class="block text-sm font-medium text-gray-700">{{ __('Agreement to Lease') }}</label>
                                    <input type="text" name="agreement_to_lease" id="agreement_to_lease" value="{{ old('agreement_to_lease', $checklist->agreement_to_lease) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="maintenance_agreement_ref" class="block text-sm font-medium text-gray-700">{{ __('Maintenance Agreement Reference') }}</label>
                                    <input type="text" name="maintenance_agreement_ref" id="maintenance_agreement_ref" value="{{ old('maintenance_agreement_ref', $checklist->maintenance_agreement_ref) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="maintenance_agreement_location" class="block text-sm font-medium text-gray-700">{{ __('Maintenance Agreement Location') }}</label>
                                    <input type="text" name="maintenance_agreement_location" id="maintenance_agreement_location" value="{{ old('maintenance_agreement_location', $checklist->maintenance_agreement_location) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="development_agreement" class="block text-sm font-medium text-gray-700">{{ __('Development Agreement') }}</label>
                                    <input type="text" name="development_agreement" id="development_agreement" value="{{ old('development_agreement', $checklist->development_agreement) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="other_legal_docs" class="block text-sm font-medium text-gray-700">{{ __('Other Legal Documents') }}</label>
                                    <textarea name="other_legal_docs" id="other_legal_docs" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('other_legal_docs', $checklist->other_legal_docs) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Tenancy Agreement section (2.0) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">3. Tenancy Agreement</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="tenant_name" class="block text-sm font-medium text-gray-700">{{ __('Tenant Name') }}</label>
                                    <input type="text" name="tenant_name" id="tenant_name" value="{{ old('tenant_name', $checklist->tenant_name) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('tenant_name')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tenant_property" class="block text-sm font-medium text-gray-700">{{ __('Tenant Property') }}</label>
                                    <input type="text" name="tenant_property" id="tenant_property" value="{{ old('tenant_property', $checklist->tenant_property) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    @error('tenant_property')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="tenancy_approval_date" class="block text-sm font-medium text-gray-700">{{ __('Tenancy Approval Date') }}</label>
                                    <input type="date" name="tenancy_approval_date" id="tenancy_approval_date" value="{{ old('tenancy_approval_date', $checklist->tenancy_approval_date ? $checklist->tenancy_approval_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="tenancy_commencement_date" class="block text-sm font-medium text-gray-700">{{ __('Tenancy Commencement Date') }}</label>
                                    <input type="date" name="tenancy_commencement_date" id="tenancy_commencement_date" value="{{ old('tenancy_commencement_date', $checklist->tenancy_commencement_date ? $checklist->tenancy_commencement_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="tenancy_expiry_date" class="block text-sm font-medium text-gray-700">{{ __('Tenancy Expiry Date') }}</label>
                                    <input type="date" name="tenancy_expiry_date" id="tenancy_expiry_date" value="{{ old('tenancy_expiry_date', $checklist->tenancy_expiry_date ? $checklist->tenancy_expiry_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- External Area Conditions (3.0) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">4. External Area Conditions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_general_cleanliness_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_general_cleanliness_satisfied', $checklist->is_general_cleanliness_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">General Cleanliness Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_fencing_gate_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_fencing_gate_satisfied', $checklist->is_fencing_gate_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Fencing and Gate Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_external_facade_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_external_facade_satisfied', $checklist->is_external_facade_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">External Facade Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_car_park_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_car_park_satisfied', $checklist->is_car_park_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Car Park Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_land_settlement_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_land_settlement_satisfied', $checklist->is_land_settlement_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Land Settlement Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_rooftop_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_rooftop_satisfied', $checklist->is_rooftop_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Rooftop Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_drainage_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_drainage_satisfied', $checklist->is_drainage_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Drainage Satisfied</span>
                                    </label>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="external_remarks" class="block text-sm font-medium text-gray-700">{{ __('External Remarks') }}</label>
                                    <textarea name="external_remarks" id="external_remarks" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('external_remarks', $checklist->external_remarks) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Internal Area Conditions (4.0) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">5. Internal Area Conditions</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_door_window_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_door_window_satisfied', $checklist->is_door_window_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Doors and Windows Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_staircase_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_staircase_satisfied', $checklist->is_staircase_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Staircase Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_toilet_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_toilet_satisfied', $checklist->is_toilet_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Toilet Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_ceiling_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_ceiling_satisfied', $checklist->is_ceiling_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Ceiling Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_wall_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_wall_satisfied', $checklist->is_wall_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Wall Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_water_seeping_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_water_seeping_satisfied', $checklist->is_water_seeping_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Water Seeping Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_loading_bay_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_loading_bay_satisfied', $checklist->is_loading_bay_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Loading Bay Satisfied</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="flex items-center">
                                        <input type="checkbox" name="is_basement_car_park_satisfied" class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50" {{ old('is_basement_car_park_satisfied', $checklist->is_basement_car_park_satisfied) ? 'checked' : '' }}>
                                        <span class="ml-2 text-sm text-gray-700">Basement Car Park Satisfied</span>
                                    </label>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="internal_remarks" class="block text-sm font-medium text-gray-700">{{ __('Internal Remarks') }}</label>
                                    <textarea name="internal_remarks" id="internal_remarks" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('internal_remarks', $checklist->internal_remarks) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Property Development section (5.0) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">6. Property Development</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="development_expansion_status" class="block text-sm font-medium text-gray-700">{{ __('Development/Expansion Status') }}</label>
                                    <input type="text" name="development_expansion_status" id="development_expansion_status" value="{{ old('development_expansion_status', $checklist->development_expansion_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="renovation_status" class="block text-sm font-medium text-gray-700">{{ __('Renovation Status') }}</label>
                                    <input type="text" name="renovation_status" id="renovation_status" value="{{ old('renovation_status', $checklist->renovation_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="external_repainting_status" class="block text-sm font-medium text-gray-700">{{ __('External Repainting Status') }}</label>
                                    <input type="text" name="external_repainting_status" id="external_repainting_status" value="{{ old('external_repainting_status', $checklist->external_repainting_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>

                        <!-- Disposal/Installation/Replacement section (5.4) -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">7. Disposal/Installation/Replacement</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="water_tank_status" class="block text-sm font-medium text-gray-700">{{ __('Water Tank Status') }}</label>
                                    <input type="text" name="water_tank_status" id="water_tank_status" value="{{ old('water_tank_status', $checklist->water_tank_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="air_conditioning_approval_date" class="block text-sm font-medium text-gray-700">{{ __('Air Conditioning Approval Date') }}</label>
                                    <input type="date" name="air_conditioning_approval_date" id="air_conditioning_approval_date" value="{{ old('air_conditioning_approval_date', $checklist->air_conditioning_approval_date ? $checklist->air_conditioning_approval_date->format('Y-m-d') : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="air_conditioning_scope" class="block text-sm font-medium text-gray-700">{{ __('Air Conditioning Scope') }}</label>
                                    <textarea name="air_conditioning_scope" id="air_conditioning_scope" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('air_conditioning_scope', $checklist->air_conditioning_scope) }}</textarea>
                                </div>
                                <div>
                                    <label for="air_conditioning_status" class="block text-sm font-medium text-gray-700">{{ __('Air Conditioning Status') }}</label>
                                    <input type="text" name="air_conditioning_status" id="air_conditioning_status" value="{{ old('air_conditioning_status', $checklist->air_conditioning_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="lift_escalator_status" class="block text-sm font-medium text-gray-700">{{ __('Lift/Escalator Status') }}</label>
                                    <input type="text" name="lift_escalator_status" id="lift_escalator_status" value="{{ old('lift_escalator_status', $checklist->lift_escalator_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="fire_system_status" class="block text-sm font-medium text-gray-700">{{ __('Fire System Status') }}</label>
                                    <input type="text" name="fire_system_status" id="fire_system_status" value="{{ old('fire_system_status', $checklist->fire_system_status) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="other_property" class="block text-sm font-medium text-gray-700">{{ __('Other Property') }}</label>
                                    <textarea name="other_property" id="other_property" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('other_property', $checklist->other_property) }}</textarea>
                                </div>
                                <div class="md:col-span-2">
                                    <label for="other_proposals_approvals" class="block text-sm font-medium text-gray-700">{{ __('Other Proposals/Approvals') }}</label>
                                    <textarea name="other_proposals_approvals" id="other_proposals_approvals" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('other_proposals_approvals', $checklist->other_proposals_approvals) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Related Record -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">8. Related Record</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="site_visit_id" class="block text-sm font-medium text-gray-700">{{ __('Site Visit ID') }}</label>
                                    <select name="site_visit_id" id="site_visit_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">None</option>
                                        @foreach($siteVisits ?? [] as $siteVisit)
                                            <option value="{{ $siteVisit->id }}" {{ old('site_visit_id', $checklist->site_visit_id) == $siteVisit->id ? 'selected' : '' }}>
                                                {{ $siteVisit->id }} - {{ $siteVisit->visit_date ?? 'No date' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">9. System Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                    <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                        <option value="">Select Status</option>
                                        <option value="pending" {{ old('status', $checklist->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ old('status', $checklist->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                        <option value="rejected" {{ old('status', $checklist->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    </select>
                                    @error('status')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="prepared_by" class="block text-sm font-medium text-gray-700">{{ __('Prepared By') }}</label>
                                    <input type="text" name="prepared_by" id="prepared_by" value="{{ old('prepared_by', $checklist->prepared_by) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="verified_by" class="block text-sm font-medium text-gray-700">{{ __('Verified By') }}</label>
                                    <input type="text" name="verified_by" id="verified_by" value="{{ old('verified_by', $checklist->verified_by) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div>
                                    <label for="approval_datetime" class="block text-sm font-medium text-gray-700">{{ __('Approval Date/Time') }}</label>
                                    <input type="datetime-local" name="approval_datetime" id="approval_datetime" value="{{ old('approval_datetime', $checklist->approval_datetime ? date('Y-m-d\TH:i', strtotime($checklist->approval_datetime)) : '') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-700">{{ __('Remarks') }}</label>
                                    <textarea name="remarks" id="remarks" rows="3" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('remarks', $checklist->remarks) }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('checklists.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Checklist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>