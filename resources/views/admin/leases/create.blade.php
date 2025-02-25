<!-- resources/views/admin/leases/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Lease') }}
            </h2>
            <a href="{{ route('leases.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Leases
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
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

            <!-- Pre-selected Information (if any) -->
            @if($selectedTenant || $selectedUnit)
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Creating lease with pre-selected information</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                @if($selectedTenant)
                                    <div>Tenant: {{ $selectedTenant->first_name }} {{ $selectedTenant->last_name }}</div>
                                @endif
                                @if($selectedUnit)
                                    <div>Unit: {{ $selectedUnit->property->name }} - Unit {{ $selectedUnit->unit_number }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('leases.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Lease Parties -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Lease Parties</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="tenant_id" class="block text-sm font-medium text-gray-700">Tenant</label>
                                    <select id="tenant_id" name="tenant_id" class="mt-1 block w-full rounded-md border-gray-300" 
                                        {{ $selectedTenant ? 'disabled' : '' }}>
                                        <option value="">Select Tenant</option>
                                        @foreach($tenants as $id => $name)
                                            <option value="{{ $id }}" {{ old('tenant_id', $selectedTenant?->id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($selectedTenant)
                                        <input type="hidden" name="tenant_id" value="{{ $selectedTenant->id }}">
                                    @endif
                                    @error('tenant_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_id" class="block text-sm font-medium text-gray-700">Property Unit</label>
                                    <select id="unit_id" name="unit_id" class="mt-1 block w-full rounded-md border-gray-300"
                                        {{ $selectedUnit ? 'disabled' : '' }}>
                                        <option value="">Select Unit</option>
                                        @foreach($availableUnits as $id => $name)
                                            <option value="{{ $id }}" {{ old('unit_id', $selectedUnit?->id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($selectedUnit)
                                        <input type="hidden" name="unit_id" value="{{ $selectedUnit->id }}">
                                    @endif
                                    @error('unit_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Lease Terms -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Lease Terms</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                    <input type="date" id="start_date" name="start_date" value="{{ old('start_date') ?? now()->format('Y-m-d') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('start_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                    <input type="date" id="end_date" name="end_date" value="{{ old('end_date') ?? now()->addYear()->format('Y-m-d') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('end_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="upcoming" {{ old('status') == 'upcoming' ? 'selected' : '' }}>Upcoming</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="renewable" class="inline-flex items-center mt-5">
                                        <input type="checkbox" id="renewable" name="renewable" value="1" 
                                            {{ old('renewable', '1') == '1' ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Renewable</span>
                                    </label>
                                    @error('renewable')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Financial Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="monthly_rent" class="block text-sm font-medium text-gray-700">Monthly Rent</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="monthly_rent" name="monthly_rent" 
                                            value="{{ old('monthly_rent', $selectedUnit?->base_rent ?? '') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('monthly_rent')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="security_deposit" class="block text-sm font-medium text-gray-700">Security Deposit</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="security_deposit" name="security_deposit" 
                                            value="{{ old('security_deposit') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('security_deposit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pet_deposit" class="block text-sm font-medium text-gray-700">Pet Deposit</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="pet_deposit" name="pet_deposit" 
                                            value="{{ old('pet_deposit', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('pet_deposit')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="utilities_included" class="inline-flex items-center mt-5">
                                        <input type="checkbox" id="utilities_included" name="utilities_included" value="1" 
                                            {{ old('utilities_included') ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Utilities Included</span>
                                    </label>
                                    @error('utilities_included')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Additional Fees -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Fees</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="parking_fee" class="block text-sm font-medium text-gray-700">Parking Fee (Monthly)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="parking_fee" name="parking_fee" 
                                            value="{{ old('parking_fee', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('parking_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="storage_fee" class="block text-sm font-medium text-gray-700">Storage Fee (Monthly)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="storage_fee" name="storage_fee" 
                                            value="{{ old('storage_fee', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('storage_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="late_fee" class="block text-sm font-medium text-gray-700">Late Fee</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="late_fee" name="late_fee" 
                                            value="{{ old('late_fee', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('late_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Inspection Dates -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Inspection Dates</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="move_in_inspection" class="block text-sm font-medium text-gray-700">Move-in Inspection</label>
                                    <input type="date" id="move_in_inspection" name="move_in_inspection" 
                                        value="{{ old('move_in_inspection') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('move_in_inspection')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <p class="text-sm text-gray-500 mt-5">Move-out inspection date can be set when the lease ends</p>
                                </div>
                            </div>
                        </div>

                        <!-- Guarantor Information (JSON) -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Guarantor Information (Optional)</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="guarantor_name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="guarantor_name" name="guarantor_name" 
                                        value="{{ old('guarantor_name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="guarantor_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" id="guarantor_phone" name="guarantor_phone" 
                                        value="{{ old('guarantor_phone') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="guarantor_email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <input type="email" id="guarantor_email" name="guarantor_email" 
                                        value="{{ old('guarantor_email') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="guarantor_relationship" class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" id="guarantor_relationship" name="guarantor_relationship" 
                                        value="{{ old('guarantor_relationship') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Notes</h3>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea id="notes" name="notes" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('leases.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Lease
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>