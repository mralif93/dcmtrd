<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Checklist') }}
            </h2>
            <a href="{{ route('checklist-m.index', $property) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                                    <div class="mt-2 text-sm text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('checklist-m.store') }}" enctype="multipart/form-data">
                        @csrf

                        <!-- Property Basic Information -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Property Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="site_visit_id" class="block text-sm font-medium text-gray-700">Site Visit</label>
                                    <select id="site_visit_id" name="site_visit_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Choose Site Visit --</option>
                                        @foreach($siteVisits ?? [] as $siteVisit)
                                            <option value="{{ $siteVisit->id }}" {{ old('site_visit_id') == $siteVisit->id ? 'selected' : '' }}>
                                                {{ $siteVisit->property->name }} - {{ $siteVisit->date_visit->format('d/m/Y') }} by {{ $siteVisit->inspector_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- 1.0 Legal Documentation -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">1.0 Legal Documentation</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Items</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Validity/Expiry Date</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/3">Location</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.1 Title</td>
                                            <td class="px-4 py-3">
                                                <input id="title_ref" type="text" name="title_ref" value="{{ old('title_ref') }}" placeholder="Title Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="title_location" type="text" name="title_location" value="{{ old('title_location') }}" placeholder="Title Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.2 Trust Deed</td>
                                            <td class="px-4 py-3">
                                                <input id="trust_deed_ref" type="text" name="trust_deed_ref" value="{{ old('trust_deed_ref') }}" placeholder="Trust Deed Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="trust_deed_location" type="text" name="trust_deed_location" value="{{ old('trust_deed_location') }}" placeholder="Trust Deed Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.3 Sale and Purchase Agreement</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="sale_purchase_agreement" type="text" name="sale_purchase_agreement" value="{{ old('sale_purchase_agreement') }}" placeholder="Reference and Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.4 Lease Agreement</td>
                                            <td class="px-4 py-3">
                                                <input id="lease_agreement_ref" type="text" name="lease_agreement_ref" value="{{ old('lease_agreement_ref') }}" placeholder="Lease Agreement Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="lease_agreement_location" type="text" name="lease_agreement_location" value="{{ old('lease_agreement_location') }}" placeholder="Lease Agreement Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.5 Agreement to Lease</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="agreement_to_lease" type="text" name="agreement_to_lease" value="{{ old('agreement_to_lease') }}" placeholder="Agreement to Lease Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.6 Maintenance Agreement</td>
                                            <td class="px-4 py-3">
                                                <input id="maintenance_agreement_ref" type="text" name="maintenance_agreement_ref" value="{{ old('maintenance_agreement_ref') }}" placeholder="Maintenance Agreement Reference" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="maintenance_agreement_location" type="text" name="maintenance_agreement_location" value="{{ old('maintenance_agreement_location') }}" placeholder="Maintenance Agreement Location" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.7 Development Agreement</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="development_agreement" type="text" name="development_agreement" value="{{ old('development_agreement') }}" placeholder="Development Agreement Details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">1.8 Others</td>
                                            <td class="px-4 py-3" colspan="2">
                                                <input id="other_legal_docs" type="text" name="other_legal_docs" value="{{ old('other_legal_docs') }}" placeholder="Other Legal Documents" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 2.0 Tenancy Agreement -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Tenants</h3>
                            
                            <div class="mb-2">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Tenant</label>
                            </div>
                            
                            <div id="tenants-container">
                                <div class="tenant-item mb-2 border-b border-gray-200 pb-2">
                                    <div class="flex items-center">
                                        <div class="flex-grow mr-2">
                                            <select name="tenant_ids[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                <option value="">Select Tenant</option>
                                                @foreach($property->tenants as $tenant)
                                                    <option value="{{ $tenant->id }}">
                                                        {{ $tenant->name }} ({{ $tenant->contact_person }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <button type="button" class="remove-tenant inline-flex items-center justify-center w-8 h-8 bg-red-500 border border-transparent rounded-md hover:bg-red-400 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-200 focus:ring-opacity-50 disabled:opacity-25 transition ease-in-out duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-2">
                                <button type="button" id="add-tenant" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                                    Add Another Tenant
                                </button>
                            </div>
                        </div>

                        <!-- 3.0 External Area Conditions -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">3.0 External Area Conditions</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Items</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">Satisfied</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">Not Satisfied</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.1 General Cleanliness</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_general_cleanliness_satisfied_1" name="is_general_cleanliness_satisfied" value="1" {{ old('is_general_cleanliness_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_general_cleanliness_satisfied_0" name="is_general_cleanliness_satisfied" value="0" {{ old('is_general_cleanliness_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="general_cleanliness_remarks" value="{{ old('general_cleanliness_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.2 Fencing & Main Gate</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_fencing_gate_satisfied_1" name="is_fencing_gate_satisfied" value="1" {{ old('is_fencing_gate_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_fencing_gate_satisfied_0" name="is_fencing_gate_satisfied" value="0" {{ old('is_fencing_gate_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="fencing_gate_remarks" value="{{ old('fencing_gate_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.3 External Facade</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_external_facade_satisfied_1" name="is_external_facade_satisfied" value="1" {{ old('is_external_facade_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_external_facade_satisfied_0" name="is_external_facade_satisfied" value="0" {{ old('is_external_facade_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="external_facade_remarks" value="{{ old('external_facade_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.4 Car Park</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_car_park_satisfied_1" name="is_car_park_satisfied" value="1" {{ old('is_car_park_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_car_park_satisfied_0" name="is_car_park_satisfied" value="0" {{ old('is_car_park_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="car_park_remarks" value="{{ old('car_park_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.5 Land Settlement</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_land_settlement_satisfied_1" name="is_land_settlement_satisfied" value="1" {{ old('is_land_settlement_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_land_settlement_satisfied_0" name="is_land_settlement_satisfied" value="0" {{ old('is_land_settlement_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="land_settlement_remarks" value="{{ old('land_settlement_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.6 Rooftop</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_rooftop_satisfied_1" name="is_rooftop_satisfied" value="1" {{ old('is_rooftop_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_rooftop_satisfied_0" name="is_rooftop_satisfied" value="0" {{ old('is_rooftop_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="rooftop_remarks" value="{{ old('rooftop_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">3.7 Drainage</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_drainage_satisfied_1" name="is_drainage_satisfied" value="1" {{ old('is_drainage_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_drainage_satisfied_0" name="is_drainage_satisfied" value="0" {{ old('is_drainage_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="drainage_remarks" value="{{ old('drainage_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="mt-4">
                                    <label for="external_remarks" class="block text-sm font-medium text-gray-700">External Area Remarks</label>
                                    <textarea id="external_remarks" name="external_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('external_remarks') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- 4.0 Internal Area Conditions -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">4.0 Internal Area Conditions</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/4">Items</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">Satisfied</th>
                                            <th class="px-4 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider w-1/8">Not Satisfied</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider w-1/2">Remarks</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.1 Door & Window</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_door_window_satisfied_1" name="is_door_window_satisfied" value="1" {{ old('is_door_window_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_door_window_satisfied_0" name="is_door_window_satisfied" value="0" {{ old('is_door_window_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="door_window_remarks" value="{{ old('door_window_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.2 Staircase                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_staircase_satisfied_1" name="is_staircase_satisfied" value="1" {{ old('is_staircase_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_staircase_satisfied_0" name="is_staircase_satisfied" value="0" {{ old('is_staircase_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="staircase_remarks" value="{{ old('staircase_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.3 Toilet</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_toilet_satisfied_1" name="is_toilet_satisfied" value="1" {{ old('is_toilet_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_toilet_satisfied_0" name="is_toilet_satisfied" value="0" {{ old('is_toilet_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="toilet_remarks" value="{{ old('toilet_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.4 Ceiling</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_ceiling_satisfied_1" name="is_ceiling_satisfied" value="1" {{ old('is_ceiling_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_ceiling_satisfied_0" name="is_ceiling_satisfied" value="0" {{ old('is_ceiling_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="ceiling_remarks" value="{{ old('ceiling_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.5 Wall</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_wall_satisfied_1" name="is_wall_satisfied" value="1" {{ old('is_wall_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_wall_satisfied_0" name="is_wall_satisfied" value="0" {{ old('is_wall_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="wall_remarks" value="{{ old('wall_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.6 Water Seeping/Leaking</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_water_seeping_satisfied_1" name="is_water_seeping_satisfied" value="1" {{ old('is_water_seeping_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_water_seeping_satisfied_0" name="is_water_seeping_satisfied" value="0" {{ old('is_water_seeping_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="water_seeping_remarks" value="{{ old('water_seeping_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.7 Loading Bay</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_loading_bay_satisfied_1" name="is_loading_bay_satisfied" value="1" {{ old('is_loading_bay_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_loading_bay_satisfied_0" name="is_loading_bay_satisfied" value="0" {{ old('is_loading_bay_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="loading_bay_remarks" value="{{ old('loading_bay_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">4.8 Basement Car Park</td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_basement_car_park_satisfied_1" name="is_basement_car_park_satisfied" value="1" {{ old('is_basement_car_park_satisfied') === '1' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3 text-center">
                                                <input type="radio" id="is_basement_car_park_satisfied_0" name="is_basement_car_park_satisfied" value="0" {{ old('is_basement_car_park_satisfied') === '0' ? 'checked' : '' }} class="rounded text-indigo-600 focus:ring-indigo-500">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input type="text" name="basement_car_park_remarks" value="{{ old('basement_car_park_remarks') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-4">
                                <label for="internal_remarks" class="block text-sm font-medium text-gray-700">Internal Area Remarks</label>
                                <textarea id="internal_remarks" name="internal_remarks" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('internal_remarks') }}</textarea>
                            </div>
                        </div>

                        <!-- 5.0 Property Development -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">5.0 Property Development</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Approval</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scope of Work</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">5.1 Development/Expansion</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="development_date" value="{{ old('development_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="development_expansion_status" type="text" name="development_expansion_status" value="{{ old('development_expansion_status') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="development_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">5.2 Renovation</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="renovation_date" value="{{ old('renovation_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="renovation_status" type="text" name="renovation_status" value="{{ old('renovation_status') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="renovation_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">5.3 External Repainting</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="repainting_date" value="{{ old('repainting_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="external_repainting_status" type="text" name="external_repainting_status" value="{{ old('external_repainting_status') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="repainting_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 5.4 Disposal/Installation/Replacement -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">5.4 Disposal/Installation/Replacement</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date of Approval</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Scope of Work</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">a) Water tank/calorifier tank</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="water_tank_date" value="{{ old('water_tank_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="water_tank_status" type="text" name="water_tank_status" value="{{ old('water_tank_status') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="water_tank_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">b) Air condition/Chiller System/AHU</td>
                                            <td class="px-4 py-3">
                                                <input id="air_conditioning_approval_date" type="date" name="air_conditioning_approval_date" value="{{ old('air_conditioning_approval_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="air_conditioning_scope" type="text" name="air_conditioning_scope" value="{{ old('air_conditioning_scope') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="air_conditioning_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">c) Lift/Escalator system</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="lift_date" value="{{ old('lift_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="lift_escalator_scope" type="text" name="lift_escalator_scope" value="{{ old('lift_escalator_scope') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="lift_escalator_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">d) Fire Fighting/Alarm system</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="fire_system_date" value="{{ old('fire_system_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="fire_system_scope" type="text" name="fire_system_scope" value="{{ old('fire_system_scope') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="fire_system_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">e) Others</td>
                                            <td class="px-4 py-3">
                                                <input type="date" name="other_system_date" value="{{ old('other_system_date') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <input id="other_property" type="text" name="other_property" value="{{ old('other_property') }}" placeholder="Scope details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                            <td class="px-4 py-3">
                                                <select name="other_completion_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                                    <option value="n/a">N/A</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Completed</option>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- 5.5 Other Proposals/Approvals -->
                        <div class="p-4 mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">5.5 Other Proposals/Approvals</h3>
                            
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="border-b">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Items</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200">
                                        <tr>
                                            <td class="px-4 py-3 text-sm text-gray-700">Other Proposals/Approvals</td>
                                            <td class="px-4 py-3">
                                                <input type="text" id="other_proposals_approvals" name="other_proposals_approvals" value="{{ old('other_proposals_approvals') }}" placeholder="Additional details" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 text-sm">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('checklist-m.index', $property) }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                                    </svg>
                                    Cancel
                                </a>
                                <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Create Checklist
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to add remove button event listener
            function addRemoveButtonListener(button) {
                button.addEventListener('click', function() {
                    const container = document.getElementById('tenants-container');
                    if (container.querySelectorAll('.tenant-item').length > 1) {
                        this.closest('.tenant-item').remove();
                    }
                });
            }

            // Initialize remove buttons for existing items
            document.querySelectorAll('.remove-tenant').forEach(button => {
                addRemoveButtonListener(button);
            });

            // Add Tenant
            document.getElementById('add-tenant').addEventListener('click', function() {
                const container = document.getElementById('tenants-container');
                const tenantItems = container.querySelectorAll('.tenant-item');
                const newItem = tenantItems[0].cloneNode(true);
                
                // Reset select
                newItem.querySelector('select').selectedIndex = 0;
                
                // Add remove event listener to the new item's remove button
                const removeButton = newItem.querySelector('.remove-tenant');
                addRemoveButtonListener(removeButton);
                
                container.appendChild(newItem);
            });
        });
    </script>
</x-app-layout>