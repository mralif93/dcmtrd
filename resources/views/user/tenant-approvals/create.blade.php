<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Tenant Approval') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('tenant-approvals-info.store') }}">
                        @csrf

                        <!-- Tenant ID -->
                        <div class="mb-4">
                            <label for="tenant_id" class="block font-medium text-sm text-gray-700">{{ __('Tenant') }}</label>
                            <select id="tenant_id" name="tenant_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Tenant</option>
                                @foreach ($tenants as $tenant)
                                    <option value="{{ $tenant->id }}" {{ old('tenant_id') == $tenant->id ? 'selected' : '' }}>
                                        {{ $tenant->name }} ({{ $tenant->property->name ?? 'No Property' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('tenant_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Checklist ID -->
                        <div class="mb-4">
                            <label for="checklist_id" class="block font-medium text-sm text-gray-700">{{ __('Checklist') }}</label>
                            <select id="checklist_id" name="checklist_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="">Select Checklist</option>
                                @foreach ($checklists as $checklist)
                                    <option value="{{ $checklist->id }}" {{ old('checklist_id') == $checklist->id ? 'selected' : '' }}>
                                        ID: {{ $checklist->id }} - {{ $checklist->description ?? 'No description' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('checklist_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Lease ID -->
                        <div class="mb-4">
                            <label for="lease_id" class="block font-medium text-sm text-gray-700">{{ __('Lease (Optional)') }}</label>
                            <select id="lease_id" name="lease_id" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                <option value="">Select Lease (Optional)</option>
                                @foreach ($leases as $lease)
                                    <option value="{{ $lease->id }}" {{ old('lease_id') == $lease->id ? 'selected' : '' }}>
                                        {{ $lease->lease_name }} ({{ $lease->tenant->name ?? 'Unknown Tenant' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('lease_id')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Approval Type -->
                        <div class="mb-4">
                            <label for="approval_type" class="block font-medium text-sm text-gray-700">{{ __('Approval Type') }}</label>
                            <select id="approval_type" name="approval_type" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" required>
                                <option value="new" {{ old('approval_type') == 'new' ? 'selected' : '' }}>New Tenant</option>
                                <option value="renewal" {{ old('approval_type') == 'renewal' ? 'selected' : '' }}>Renewal</option>
                            </select>
                            @error('approval_type')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Approval Status -->
                        <div class="mb-4">
                            <fieldset class="border border-gray-300 rounded-md p-4">
                                <legend class="text-sm font-medium text-gray-700 px-2">Approval Status</legend>
                                
                                <!-- OD Approved -->
                                <div class="mb-3">
                                    <div class="flex items-center">
                                        <input id="od_approved" name="od_approved" type="checkbox" value="1" {{ old('od_approved') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="od_approved" class="ml-2 block text-sm text-gray-900">
                                            {{ __('Approved by Operations Department (OD)') }}
                                        </label>
                                    </div>
                                    @error('od_approved')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- OD Approval Date -->
                                <div class="mb-3">
                                    <label for="od_approval_date" class="block text-sm font-medium text-gray-700">{{ __('OD Approval Date') }}</label>
                                    <input id="od_approval_date" type="date" name="od_approval_date" value="{{ old('od_approval_date') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                    @error('od_approval_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- LD Verified -->
                                <div class="mb-3">
                                    <div class="flex items-center">
                                        <input id="ld_verified" name="ld_verified" type="checkbox" value="1" {{ old('ld_verified') ? 'checked' : '' }} class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        <label for="ld_verified" class="ml-2 block text-sm text-gray-900">
                                            {{ __('Verified by Legal Department (LD)') }}
                                        </label>
                                    </div>
                                    @error('ld_verified')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- LD Verification Date -->
                                <div class="mb-3">
                                    <label for="ld_verification_date" class="block text-sm font-medium text-gray-700">{{ __('LD Verification Date') }}</label>
                                    <input id="ld_verification_date" type="date" name="ld_verification_date" value="{{ old('ld_verification_date') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                    @error('ld_verification_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>

                        <!-- Response Time Tracking -->
                        <div class="mb-4">
                            <fieldset class="border border-gray-300 rounded-md p-4">
                                <legend class="text-sm font-medium text-gray-700 px-2">Response Time Tracking</legend>
                                
                                <!-- Submitted to LD Date -->
                                <div class="mb-3">
                                    <label for="submitted_to_ld_date" class="block text-sm font-medium text-gray-700">{{ __('Submitted to LD Date') }}</label>
                                    <input id="submitted_to_ld_date" type="date" name="submitted_to_ld_date" value="{{ old('submitted_to_ld_date') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                    @error('submitted_to_ld_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- LD Response Date -->
                                <div class="mb-3">
                                    <label for="ld_response_date" class="block text-sm font-medium text-gray-700">{{ __('LD Response Date') }}</label>
                                    <input id="ld_response_date" type="date" name="ld_response_date" value="{{ old('ld_response_date') }}" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                    @error('ld_response_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </fieldset>
                        </div>

                        <!-- Notes -->
                        <div class="mb-4">
                            <label for="notes" class="block font-medium text-sm text-gray-700">{{ __('Notes') }}</label>
                            <textarea id="notes" name="notes" rows="3" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">{{ old('notes') }}</textarea>
                            @error('notes')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('tenant-approvals-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150 mr-2">
                                {{ __('Cancel') }}
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Create') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>