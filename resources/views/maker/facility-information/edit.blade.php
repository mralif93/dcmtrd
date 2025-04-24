<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Facility') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('facility-info-m.update', $facility) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section: General Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">General Information</h3>

                        <!-- Row 1: Issuer -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issuer_short_name" class="block text-sm font-medium text-gray-700">Issuer Short Name</label>
                                <input type="text" name="issuer_short_name" id="issuer_short_name" 
                                    value="{{ old('issuer_short_name', $facility->issuer_short_name) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('issuer_short_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                <select name="issuer_id" id="issuer_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Issuer</option>
                                    @foreach($issuers as $issuer)
                                        <option value="{{ $issuer->id }}" @selected(old('issuer_id', $facility->issuer_id) == $issuer->id)>
                                            {{ $issuer->issuer_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('issuer_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Facility Name -->
                        <div>
                            <label for="facility_name" class="block text-sm font-medium text-gray-700">Facility Name *</label>
                            <input type="text" name="facility_name" id="facility_name" 
                                value="{{ old('facility_name', $facility->facility_name) }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('facility_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 3: Facility Code & Facility Number -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                <input type="text" name="facility_code" id="facility_code" 
                                    value="{{ old('facility_code', $facility->facility_code) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_number" class="block text-sm font-medium text-gray-700">Facility Number *</label>
                                <input type="text" name="facility_number" id="facility_number" 
                                    value="{{ old('facility_number', $facility->facility_number) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Principle & Islamic Concept -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="principle_type" class="block text-sm font-medium text-gray-700">Principle</label>
                                <input type="text" name="principle_type" id="principle_type" 
                                    value="{{ old('principle_type', $facility->principle_type) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('principle_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic Concept</label>
                                <input type="text" name="islamic_concept" id="islamic_concept" 
                                    value="{{ old('islamic_concept', $facility->islamic_concept) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('islamic_concept')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 5: Maturity Date -->
                        <div>
                            <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date</label>
                            <input type="date" name="maturity_date" id="maturity_date" 
                                value="{{ old('maturity_date', $facility->maturity_date->format('Y-m-d')) }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('maturity_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 6: Instrument & Instrument Type -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="instrument" class="block text-sm font-medium text-gray-700">Instrument</label>
                                <input type="text" name="instrument" id="instrument" 
                                    value="{{ old('instrument', $facility->instrument) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('instrument')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="instrument_type" class="block text-sm font-medium text-gray-700">Instrument Type</label>
                                <input type="text" name="instrument_type" id="instrument_type" 
                                    value="{{ old('instrument_type', $facility->instrument_type) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('instrument_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div x-data="{ guaranteed: {{ old('guaranteed', $facility->guaranteed) ? 'true' : 'false' }} }" class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="guaranteed" class="block text-sm font-medium text-gray-700">Guaranteed</label>
                                <div class="mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="guaranteed" id="guaranteed"
                                            x-model="guaranteed"
                                            value="1"
                                            class="text-indigo-600 border-gray-300 rounded shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="ml-2">Yes</span>
                                    </label>
                                </div>
                                @error('guaranteed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="total_guaranteed" class="block text-sm font-medium text-gray-700">Total Guaranteed (RM)</label>
                                <input type="number" name="total_guaranteed" id="total_guaranteed"
                                    value="{{ old('total_guaranteed', $facility->total_guaranteed) }}"
                                    x-bind:disabled="!guaranteed"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('total_guaranteed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Row 8: Indicator & Facility Rating -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="indicator" class="block text-sm font-medium text-gray-700">Indicator</label>
                                <input type="text" name="indicator" id="indicator" 
                                    value="{{ old('indicator', $facility->indicator) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('indicator')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_rating" class="block text-sm font-medium text-gray-700">Facility Rating</label>
                                <input type="text" name="facility_rating" id="facility_rating" 
                                    value="{{ old('facility_rating', $facility->facility_rating) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Facility Information -->
                    <div class="pb-6 mt-8 space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">Facility Information</h3>

                        <!-- Row 1: Facility Amount & Available Limit -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="facility_amount" class="block text-sm font-medium text-gray-700">Facility Amount (RM)</label>
                                <input type="number" name="facility_amount" id="facility_amount" 
                                    value="{{ old('facility_amount', $facility->facility_amount) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="available_limit" class="block text-sm font-medium text-gray-700">Available Limit (RM)</label>
                                <input type="number" name="available_limit" id="available_limit" 
                                    value="{{ old('available_limit', $facility->available_limit) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('available_limit')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Trustee/Security Agent -->
                        <div>
                            <label for="trustee_security_agent" class="block text-sm font-medium text-gray-700">Trustee/Security Agent</label>
                            <input type="text" name="trustee_security_agent" id="trustee_security_agent" 
                                value="{{ old('trustee_security_agent', $facility->trustee_security_agent) }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('trustee_security_agent')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 3: Lead Arranger & Availability -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger (LA)</label>
                                <input type="text" name="lead_arranger" id="lead_arranger" 
                                    value="{{ old('lead_arranger', $facility->lead_arranger) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('lead_arranger')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="availability_date" class="block text-sm font-medium text-gray-700">Availability</label>
                                <input type="date" name="availability_date" id="availability_date" 
                                    value="{{ old('availability_date', $facility->availability_date->format('Y-m-d')) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('availability_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Outstanding & Facility Agent -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="outstanding_amount" class="block text-sm font-medium text-gray-700">Outstanding (RM)</label>
                                <input type="number" name="outstanding_amount" id="outstanding_amount" 
                                    value="{{ old('outstanding_amount', $facility->outstanding_amount) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('outstanding_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent (FA)</label>
                                <input type="text" name="facility_agent" id="facility_agent" 
                                    value="{{ old('facility_agent', $facility->facility_agent) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_agent')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('bond-m.details', $facility->issuer) }}" 
                        class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>