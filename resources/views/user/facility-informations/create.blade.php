<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('facility-informations-info.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <select name="issuer_id" id="issuer_id" required 
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Issuer --</option>
                                        @foreach($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" @selected(old('issuer_id') == $issuer->id)>
                                                {{ $issuer->issuer_short_name }} - {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="facility_name" class="block text-sm font-medium text-gray-700">Facility Name *</label>
                                    <input type="text" name="facility_name" id="facility_name" 
                                        value="{{ old('facility_name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                    <input type="text" name="facility_code" id="facility_code" 
                                        value="{{ old('facility_code') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="facility_number" class="block text-sm font-medium text-gray-700">Facility Number *</label>
                                    <input type="text" name="facility_number" id="facility_number" 
                                        value="{{ old('facility_number') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Instrument Details Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Instrument Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="principle_type" class="block text-sm font-medium text-gray-700">Principle Type *</label>
                                    <input type="text" name="principle_type" id="principle_type" 
                                        value="{{ old('principle_type') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic Concept</label>
                                    <input type="text" name="islamic_concept" id="islamic_concept" 
                                        value="{{ old('islamic_concept') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="instrument" class="block text-sm font-medium text-gray-700">Instrument</label>
                                    <input type="text" name="instrument" id="instrument" 
                                        value="{{ old('instrument') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="instrument_type" class="block text-sm font-medium text-gray-700">Instrument Type</label>
                                    <input type="text" name="instrument_type" id="instrument_type" 
                                        value="{{ old('instrument_type') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="facility_rating" class="block text-sm font-medium text-gray-700">Facility Rating</label>
                                    <input type="text" name="facility_rating" id="facility_rating" 
                                        value="{{ old('facility_rating') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="indicator" class="block text-sm font-medium text-gray-700">Indicator</label>
                                    <input type="text" name="indicator" id="indicator" 
                                        value="{{ old('indicator') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facility_amount" class="block text-sm font-medium text-gray-700">Facility Amount (RM)</label>
                                    <input type="number" name="facility_amount" id="facility_amount" step="0.01" min="0"
                                        value="{{ old('facility_amount') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="available_limit" class="block text-sm font-medium text-gray-700">Available Limit (RM)</label>
                                    <input type="number" name="available_limit" id="available_limit" step="0.01" min="0"
                                        value="{{ old('available_limit') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="outstanding_amount" class="block text-sm font-medium text-gray-700">Outstanding Amount (RM)</label>
                                    <input type="number" name="outstanding_amount" id="outstanding_amount" step="0.01" min="0"
                                        value="{{ old('outstanding_amount') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5 mt-6">
                                            <input type="checkbox" name="guaranteed" id="guaranteed" value="1" @checked(old('guaranteed'))
                                                class="h-4 w-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="guaranteed" class="font-medium text-gray-700">Guaranteed</label>
                                        </div>
                                    </div>
                                </div>
                                <div id="guaranteed_amount_div" class="{{ old('guaranteed') ? '' : 'hidden' }}">
                                    <label for="total_guaranteed" class="block text-sm font-medium text-gray-700">Total Guaranteed (RM)</label>
                                    <input type="number" name="total_guaranteed" id="total_guaranteed" step="0.01" min="0"
                                        value="{{ old('total_guaranteed') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Dates & Parties Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dates & Parties</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date *</label>
                                    <input type="date" name="maturity_date" id="maturity_date" 
                                        value="{{ old('maturity_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="availability_date" class="block text-sm font-medium text-gray-700">Availability Date</label>
                                    <input type="date" name="availability_date" id="availability_date" 
                                        value="{{ old('availability_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="trustee_security_agent" class="block text-sm font-medium text-gray-700">Trustee/Security Agent</label>
                                    <input type="text" name="trustee_security_agent" id="trustee_security_agent" 
                                        value="{{ old('trustee_security_agent') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger</label>
                                    <input type="text" name="lead_arranger" id="lead_arranger" 
                                        value="{{ old('lead_arranger') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent</label>
                                    <input type="text" name="facility_agent" id="facility_agent" 
                                        value="{{ old('facility_agent') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="prepared_by" class="block text-sm font-medium text-gray-700">Prepared By</label>
                                    <input type="text" name="prepared_by" id="prepared_by" 
                                        value="{{ old('prepared_by') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="verified_by" class="block text-sm font-medium text-gray-700">Verified By</label>
                                    <input type="text" name="verified_by" id="verified_by" 
                                        value="{{ old('verified_by') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div class="md:col-span-2">
                                    <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea name="remarks" id="remarks" rows="3"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('facility-informations-info.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Facility
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const guaranteedCheckbox = document.getElementById('guaranteed');
            const guaranteedAmountDiv = document.getElementById('guaranteed_amount_div');
            const totalGuaranteedInput = document.getElementById('total_guaranteed');

            // Function to toggle the total guaranteed field
            function toggleGuaranteedAmount() {
                if (guaranteedCheckbox.checked) {
                    guaranteedAmountDiv.classList.remove('hidden');
                    totalGuaranteedInput.setAttribute('required', 'required');
                } else {
                    guaranteedAmountDiv.classList.add('hidden');
                    totalGuaranteedInput.removeAttribute('required');
                    totalGuaranteedInput.value = '';
                }
            }

            // Set initial state
            toggleGuaranteedAmount();

            // Add event listener for changes
            guaranteedCheckbox.addEventListener('change', toggleGuaranteedAmount);
        });
    </script>
</x-app-layout>