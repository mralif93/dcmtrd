<!-- resources/views/leases/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Lease') }}
            </h2>
            <a href="{{ route('lease-m.index', $lease->tenant->property) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
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

                    <form method="POST" action="{{ route('lease-m.update', $lease) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Tenant Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tenant -->
                                <div class="col-span-2">
                                    <label for="tenant_id" class="block text-sm font-medium text-gray-500">Tenant</label>
                                    <select id="tenant_id" name="tenant_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a tenant</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" {{ old('tenant_id', $lease->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                                {{ $tenant->name }} ({{ $tenant->property->name }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('tenant_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Lease Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Lease Name -->
                                <div>
                                    <label for="lease_name" class="block text-sm font-medium text-gray-500">Lease Name</label>
                                    <input id="lease_name" type="text" name="lease_name" value="{{ old('lease_name', $lease->lease_name) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('lease_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Demised Premises -->
                                <div>
                                    <label for="demised_premises" class="block text-sm font-medium text-gray-500">Demised Premises</label>
                                    <input id="demised_premises" type="text" name="demised_premises" value="{{ old('demised_premises', $lease->demised_premises) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('demised_premises')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Permitted Use -->
                                <div>
                                    <label for="permitted_use" class="block text-sm font-medium text-gray-500">Permitted Use</label>
                                    <input id="permitted_use" type="text" name="permitted_use" value="{{ old('permitted_use', $lease->permitted_use) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('permitted_use')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Term Years -->
                                <div>
                                    <label for="term_years" class="block text-sm font-medium text-gray-500">Term (Years)</label>
                                    <input id="term_years" type="text" name="term_years" value="{{ old('term_years', $lease->term_years) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('term_years')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Start Date -->
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-500">Start Date</label>
                                    <input id="start_date" type="date" name="start_date" value="{{ old('start_date', $lease->start_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- End Date -->
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-500">End Date</label>
                                    <input id="end_date" type="date" name="end_date" value="{{ old('end_date', $lease->end_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Option to Renew -->
                                <div>
                                    <label for="option_to_renew" class="block text-sm font-medium text-gray-500">Option to Renew (Year)</label>
                                    <input id="option_to_renew" type="text" name="option_to_renew" value="{{ old('option_to_renew', $lease->option_to_renew) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('option_to_renew')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Tenancy Type -->
                                <div>
                                    <label for="tenancy_type" class="block text-sm font-medium text-gray-500">Tenancy Type (New/Renewal)</label>
                                    <input id="tenancy_type" type="text" name="tenancy_type" value="{{ old('tenancy_type', $lease->tenancy_type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('tenancy_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Space -->
                                <div>
                                    <label for="space" class="block text-sm font-medium text-gray-500">Space (sq ft/m²)</label>
                                    <input id="space" type="number" step="0.01" min="0" name="space" value="{{ old('space', $lease->space) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('space')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Rental Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Year 1 -->
                                <div>
                                    <label for="base_rate_year_1" class="block text-sm font-medium text-gray-500">Base Rate Year 1 (RM)</label>
                                    <input id="base_rate_year_1" type="number" step="0.01" min="0" name="base_rate_year_1" value="{{ old('base_rate_year_1', $lease->base_rate_year_1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('base_rate_year_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="monthly_gsto_year_1" class="block text-sm font-medium text-gray-500">Monthly GSTO Year 1 (%)</label>
                                    <input id="monthly_gsto_year_1" type="number" step="0.01" min="0" name="monthly_gsto_year_1" value="{{ old('monthly_gsto_year_1', $lease->monthly_gsto_year_1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('monthly_gsto_year_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-2">
                                    <label for="remarks_year_1" class="block text-sm font-medium text-gray-500">Remarks Year 1</label>
                                    <textarea id="remarks_year_1" name="remarks_year_1" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks_year_1', $lease->remarks_year_1) }}</textarea>
                                    @error('remarks_year_1')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Year 2 -->
                                <div>
                                    <label for="base_rate_year_2" class="block text-sm font-medium text-gray-500">Base Rate Year 2 (RM)</label>
                                    <input id="base_rate_year_2" type="number" step="0.01" min="0" name="base_rate_year_2" value="{{ old('base_rate_year_2', $lease->base_rate_year_2) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('base_rate_year_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="monthly_gsto_year_2" class="block text-sm font-medium text-gray-500">Monthly GSTO Year 2 (%)</label>
                                    <input id="monthly_gsto_year_2" type="number" step="0.01" min="0" name="monthly_gsto_year_2" value="{{ old('monthly_gsto_year_2', $lease->monthly_gsto_year_2) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('monthly_gsto_year_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-2">
                                    <label for="remarks_year_2" class="block text-sm font-medium text-gray-500">Remarks Year 2</label>
                                    <textarea id="remarks_year_2" name="remarks_year_2" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks_year_2', $lease->remarks_year_2) }}</textarea>
                                    @error('remarks_year_2')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <!-- Year 3 -->
                                <div>
                                    <label for="base_rate_year_3" class="block text-sm font-medium text-gray-500">Base Rate Year 3 (RM)</label>
                                    <input id="base_rate_year_3" type="number" step="0.01" min="0" name="base_rate_year_3" value="{{ old('base_rate_year_3', $lease->base_rate_year_3) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('base_rate_year_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="monthly_gsto_year_3" class="block text-sm font-medium text-gray-500">Monthly GSTO Year 3 (%)</label>
                                    <input id="monthly_gsto_year_3" type="number" step="0.01" min="0" name="monthly_gsto_year_3" value="{{ old('monthly_gsto_year_3', $lease->monthly_gsto_year_3) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('monthly_gsto_year_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                
                                <div class="col-span-2">
                                    <label for="remarks_year_3" class="block text-sm font-medium text-gray-500">Remarks Year 3</label>
                                    <textarea id="remarks_year_3" name="remarks_year_3" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks_year_3', $lease->remarks_year_3) }}</textarea>
                                    @error('remarks_year_3')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Attachment</h3>
                            </div>

                            <div class="grid grid-cols-1 gap-6">
                                <!-- Current Attachment -->
                                @if($lease->attachment)
                                <div>
                                    <label class="block text-sm font-medium text-gray-500">Current Attachment</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="mr-2">{{ basename($lease->attachment) }}</span>
                                        <a href="{{ Storage::url($lease->attachment) }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">View</a>
                                    </div>
                                </div>
                                @endif

                                <!-- New Attachment -->
                                <div>
                                    <label for="attachment" class="block text-sm font-medium text-gray-500">Upload New Lease Document</label>
                                    <input id="attachment" type="file" name="attachment" class="mt-1 block w-full text-indigo-600 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <p class="mt-1 text-sm text-gray-500">Accepts PDF, Word documents, and images (maximum 10MB). Leave empty to keep current file.</p>
                                    @error('attachment')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('lease-m.index', $lease->tenant->property) }}" 
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
                                    Update Lease
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>