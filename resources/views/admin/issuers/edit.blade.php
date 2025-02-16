<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Issuer Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="text-lg text-gray-600">Update {{ $issuer->issuer_short_name }}'s details</p>
            </div>

            @if(session('success'))
                <div class="mb-4">
                    <div class="bg-green-500 text-white p-4 rounded">
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white shadow rounded-lg p-6">
                <form action="{{ route('issuers.update', $issuer) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Issuer Information Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Issuer Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Left Column -->
                            <div class="space-y-4">
                                <div>
                                    <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short Name *</label>
                                    <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                        value="{{ old('issuer_short_name', $issuer->issuer_short_name) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('issuer_short_name')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="registration_number" class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                    <input type="text" name="registration_number" id="registration_number" 
                                        value="{{ old('registration_number', $issuer->registration_number) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('registration_number')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Right Column -->
                            <div class="space-y-4">
                                <div>
                                    <label for="issuer_name" class="block text-sm font-medium text-gray-700">Full Name *</label>
                                    <input type="text" name="issuer_name" id="issuer_name" 
                                        value="{{ old('issuer_name', $issuer->issuer_name) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('issuer_name')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>

                                <div>
                                    <label for="trust_deed_date" class="block text-sm font-medium text-gray-700">Trust Deed Date *</label>
                                    <input type="date" name="trust_deed_date" id="trust_deed_date" 
                                        value="{{ old('trust_deed_date', $issuer->trust_deed_date->format('Y-m-d')) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                        required>
                                    @error('trust_deed_date')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trustee Details Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Trustee Details</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Trustee 1 -->
                            <div class="space-y-4">
                                <div>
                                    <label for="trustee_role_1" class="block text-sm font-medium text-gray-700">Role 1</label>
                                    <input type="text" name="trustee_role_1" id="trustee_role_1" 
                                        value="{{ old('trustee_role_1', $issuer->trustee_role_1) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="trustee_fee_amount_1" class="block text-sm font-medium text-gray-700">Fee Amount 1 (RM)</label>
                                    <input type="number" name="trustee_fee_amount_1" id="trustee_fee_amount_1" 
                                        value="{{ old('trustee_fee_amount_1', $issuer->trustee_fee_amount_1) }}" 
                                        step="0.01" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_fee_amount_1')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Trustee 2 -->
                            <div class="space-y-4">
                                <div>
                                    <label for="trustee_role_2" class="block text-sm font-medium text-gray-700">Role 2</label>
                                    <input type="text" name="trustee_role_2" id="trustee_role_2" 
                                        value="{{ old('trustee_role_2', $issuer->trustee_role_2) }}" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="trustee_fee_amount_2" class="block text-sm font-medium text-gray-700">Fee Amount 2 (RM)</label>
                                    <input type="number" name="trustee_fee_amount_2" id="trustee_fee_amount_2" 
                                        value="{{ old('trustee_fee_amount_2', $issuer->trustee_fee_amount_2) }}" 
                                        step="0.01" 
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('trustee_fee_amount_2')
                                        <span class="text-red-600 text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Reminders Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Reminder Schedule</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="reminder_1" class="block text-sm font-medium text-gray-700">Reminder 1</label>
                                <input type="datetime-local" name="reminder_1" id="reminder_1" 
                                    value="{{ old('reminder_1', $issuer->reminder_1?->format('Y-m-d\TH:i')) }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="reminder_2" class="block text-sm font-medium text-gray-700">Reminder 2</label>
                                <input type="datetime-local" name="reminder_2" id="reminder_2" 
                                    value="{{ old('reminder_2', $issuer->reminder_2?->format('Y-m-d\TH:i')) }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="reminder_3" class="block text-sm font-medium text-gray-700">Reminder 3</label>
                                <input type="datetime-local" name="reminder_3" id="reminder_3" 
                                    value="{{ old('reminder_3', $issuer->reminder_3?->format('Y-m-d\TH:i')) }}" 
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Debenture Field -->
                    <div class="mb-6">
                        <label for="debenture" class="block text-sm font-medium text-gray-700">Debenture Number</label>
                        <input type="text" name="debenture" id="debenture"
                            value="{{ old('debenture', $issuer->debenture) }}" 
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('debenture')
                            <span class="text-red-600 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('issuers.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>