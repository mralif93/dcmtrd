<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Lease') }}
            </h2>
            <a href="{{ route('leases.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('leases.update', $lease) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="col-span-1">
                                <label for="tenant_id" class="block text-sm font-medium text-gray-700">{{ __('Tenant') }} <span class="text-red-500">*</span></label>
                                <select name="tenant_id" id="tenant_id" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="">Select a tenant</option>
                                    @foreach($tenants as $tenant)
                                        <option value="{{ $tenant->id }}" {{ old('tenant_id', $lease->tenant_id) == $tenant->id ? 'selected' : '' }}>
                                            {{ $tenant->name }} ({{ $tenant->property->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('tenant_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="lease_name" class="block text-sm font-medium text-gray-700">{{ __('Lease Name') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="lease_name" id="lease_name" value="{{ old('lease_name', $lease->lease_name) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('lease_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="demised_premises" class="block text-sm font-medium text-gray-700">{{ __('Demised Premises') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="demised_premises" id="demised_premises" value="{{ old('demised_premises', $lease->demised_premises) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('demised_premises')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="permitted_use" class="block text-sm font-medium text-gray-700">{{ __('Permitted Use') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="permitted_use" id="permitted_use" value="{{ old('permitted_use', $lease->permitted_use) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('permitted_use')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="rental_amount" class="block text-sm font-medium text-gray-700">{{ __('Rental Amount') }} <span class="text-red-500">*</span></label>
                                <input type="number" name="rental_amount" id="rental_amount" value="{{ old('rental_amount', $lease->rental_amount) }}" step="0.01" min="0" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('rental_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="rental_frequency" class="block text-sm font-medium text-gray-700">{{ __('Rental Frequency') }} <span class="text-red-500">*</span></label>
                                <select name="rental_frequency" id="rental_frequency" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" required>
                                    <option value="monthly" {{ old('rental_frequency', $lease->rental_frequency) == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('rental_frequency', $lease->rental_frequency) == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                    <option value="semi-annually" {{ old('rental_frequency', $lease->rental_frequency) == 'semi-annually' ? 'selected' : '' }}>Semi-Annually</option>
                                    <option value="annually" {{ old('rental_frequency', $lease->rental_frequency) == 'annually' ? 'selected' : '' }}>Annually</option>
                                </select>
                                @error('rental_frequency')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="term_years" class="block text-sm font-medium text-gray-700">{{ __('Term (Years)') }} <span class="text-red-500">*</span></label>
                                <input type="text" name="term_years" id="term_years" value="{{ old('term_years', $lease->term_years) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('term_years')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="option_to_renew" class="block text-sm font-medium text-gray-700">{{ __('Option to Renew') }}</label>
                                <div class="mt-2">
                                    <div class="flex items-center">
                                        <input type="checkbox" name="option_to_renew" id="option_to_renew" value="1" {{ old('option_to_renew', $lease->option_to_renew) ? 'checked' : '' }} class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300 rounded">
                                        <label for="option_to_renew" class="ml-2 block text-sm text-gray-900">
                                            Yes, tenant has option to renew
                                        </label>
                                    </div>
                                </div>
                                @error('option_to_renew')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="start_date" class="block text-sm font-medium text-gray-700">{{ __('Start Date') }} <span class="text-red-500">*</span></label>
                                <input type="date" name="start_date" id="start_date" value="{{ old('start_date', $lease->start_date->format('Y-m-d')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('start_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="end_date" class="block text-sm font-medium text-gray-700">{{ __('End Date') }} <span class="text-red-500">*</span></label>
                                <input type="date" name="end_date" id="end_date" value="{{ old('end_date', $lease->end_date->format('Y-m-d')) }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" required>
                                @error('end_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">{{ __('Status') }}</label>
                                <select name="status" id="status" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                    <option value="active" {{ old('status', $lease->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $lease->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex justify-end space-x-4 mt-6">
                            <a href="{{ route('leases.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update Lease
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>