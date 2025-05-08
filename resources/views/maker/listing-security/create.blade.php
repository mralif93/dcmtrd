<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Security') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your
                        submission</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('list-security-m.store') }}" method="POST" class="p-6 space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                        <!-- Issuer Dropdown -->
                        <div>
                            <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                            <select name="issuer_id" id="issuer_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Issuer --</option>
                                @forelse ($issuers as $issuer)
                                    <option value="{{ $issuer->id }}" @selected(old('issuer_id') == $issuer->id)>
                                        {{ $issuer->issuer_short_name }} - {{ $issuer->issuer_name }}
                                    </option>
                                @empty
                                    <option disabled>No issuers available</option>
                                @endforelse
                            </select>
                        </div>
                    
                        <!-- Security Name -->
                        <div>
                            <label for="security_name" class="block text-sm font-medium text-gray-700">Security Name
                                *</label>
                            <input type="text" name="security_name" id="security_name" required
                                value="{{ old('security_name') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Security Code -->
                        <div>
                            <label for="security_code" class="block text-sm font-medium text-gray-700">Security Code
                                *</label>
                            <input type="text" name="security_code" id="security_code" required
                                value="{{ old('security_code') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Asset Name Type -->
                        <div>
                            <label for="asset_name_type" class="block text-sm font-medium text-gray-700">Asset Name Type
                                *</label>
                            <select name="asset_name_type" id="asset_name_type" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">-- Select Asset Type --</option>
                                <option value="Land Property" @selected(old('asset_name_type') == 'Land Property')>Land Property</option>
                                <option value="Charge" @selected(old('asset_name_type') == 'Charge')>Charge</option>
                                <option value="Policy Insurance" @selected(old('asset_name_type') == 'Policy Insurance')>Policy Insurance</option>
                            </select>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('list-security-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 rounded-md hover:bg-indigo-700">
                            Save Security
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
