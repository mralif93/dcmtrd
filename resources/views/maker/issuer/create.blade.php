<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Issuer') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with
                                your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form x-data="{ debenture: '{{ old('debenture') }}' }" action="{{ route('issuer-m.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="issuer_name" class="block text-sm font-medium text-gray-700">Issuer Name
                                        *</label>
                                    <input type="text" name="issuer_name" id="issuer_name"
                                        value="{{ old('issuer_name') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Short
                                        Name *</label>
                                    <input type="text" name="issuer_short_name" id="issuer_short_name"
                                        value="{{ old('issuer_short_name') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="registration_number"
                                        class="block text-sm font-medium text-gray-700">Registration Number *</label>
                                    <input type="text" name="registration_number" id="registration_number"
                                        value="{{ old('registration_number') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="debenture"
                                        class="block text-sm font-medium text-gray-700">Debenture</label>
                                    <select name="debenture" id="debenture" x-model="debenture"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="" disabled>Select an option</option>
                                        <option value="Corporate Bond">Corporate Bond</option>
                                        <option value="Corporate Trust">Corporate Trust</option>
                                        <option value="Loan">Loan</option>
                                    </select>
                                </div>
                                <div>
                                    <label for="trust_deed_date" class="block text-sm font-medium text-gray-700">Trust
                                        Deed Date</label>
                                    <input type="date" name="trust_deed_date" id="trust_deed_date"
                                        value="{{ old('trust_deed_date') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="trust_amount_escrow_sum"
                                        class="block text-sm font-medium text-gray-700">Trust Amount/Escrow Sum</label>
                                    <input type="text" name="trust_amount_escrow_sum" id="trust_amount_escrow_sum"
                                        x-bind:readonly="debenture === 'Corporate Bond' || debenture === 'Loan'"
                                        x-bind:value="debenture === 'Corporate Bond' || debenture === 'Loan' ? 'N/A' :
                                            '{{ old('trust_amount_escrow_sum') }}'"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Share Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Share Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="no_of_share" class="block text-sm font-medium text-gray-700">Number of
                                        Shares</label>
                                    <input type="text" name="no_of_share" id="no_of_share"
                                        x-bind:readonly="debenture === 'Corporate Bond' || debenture === 'Loan'"
                                        x-bind:value="debenture === 'Corporate Bond' || debenture === 'Loan' ? 'N/A' :
                                            '{{ old('no_of_share') }}'"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="outstanding_size"
                                        class="block text-sm font-medium text-gray-700">Outstanding Size</label>
                                    <input type="text" name="outstanding_size" id="outstanding_size"
                                        x-bind:readonly="debenture === 'Corporate Trust'"
                                        x-bind:value="debenture === 'Corporate Trust' ? 'N/A' : '{{ old('outstanding_size') }}'"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Trustee Information Section -->
                        <div>
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Trustee Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="trustee_role_1" class="block text-sm font-medium text-gray-700">Role
                                        1</label>
                                    <input type="text" name="trustee_role_1" id="trustee_role_1"
                                        value="{{ old('trustee_role_1') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="trustee_role_2" class="block text-sm font-medium text-gray-700">Role
                                        2</label>
                                    <input type="text" name="trustee_role_2" id="trustee_role_2"
                                        value="{{ old('trustee_role_2') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Additional Issuer Details Section -->
                    <div class="pb-6 border-b border-gray-200">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Issuer Details</h3>
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="pic_name" class="block text-sm font-medium text-gray-700">PIC Name</label>
                                <input type="text" name="pic_name" id="pic_name" value="{{ old('pic_name') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="phone_no" class="block text-sm font-medium text-gray-700">Phone
                                    Number</label>
                                <input type="text" name="phone_no" id="phone_no" value="{{ old('phone_no') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div class="md:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" id="address" rows="3"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Issuer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
