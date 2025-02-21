<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Facility') }}
        </h2>
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('facility-informations-info.update', $facility) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section: General Information -->
                    <div class="space-y-6">
                        <h3 class="text-lg font-medium text-gray-900">General Information</h3>

                        <!-- Row 1: Issuer -->
                        <div>
                            <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                            <select name="issuer_id" id="issuer_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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

                        <!-- Row 2: Facility Name -->
                        <div>
                            <label for="facility_name" class="block text-sm font-medium text-gray-700">Facility Name *</label>
                            <input type="text" name="facility_name" id="facility_name" 
                                value="{{ old('facility_name', $facility->facility_name) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('facility_name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 3: Facility Code & Facility Number -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                <input type="text" name="facility_code" id="facility_code" 
                                    value="{{ old('facility_code', $facility->facility_code) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_code')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_number" class="block text-sm font-medium text-gray-700">Facility Number *</label>
                                <input type="text" name="facility_number" id="facility_number" 
                                    value="{{ old('facility_number', $facility->facility_number) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Principle & Islamic Concept -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="principle_type" class="block text-sm font-medium text-gray-700">Principle *</label>
                                <input type="text" name="principle_type" id="principle_type" 
                                    value="{{ old('principle_type', $facility->principle_type) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('principle_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic Concept *</label>
                                <input type="text" name="islamic_concept" id="islamic_concept" 
                                    value="{{ old('islamic_concept', $facility->islamic_concept) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('islamic_concept')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 5: Maturity Date -->
                        <div>
                            <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date *</label>
                            <input type="date" name="maturity_date" id="maturity_date" 
                                value="{{ old('maturity_date', $facility->maturity_date->format('Y-m-d')) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('maturity_date')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 6: Instrument & Instrument Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="instrument" class="block text-sm font-medium text-gray-700">Instrument *</label>
                                <input type="text" name="instrument" id="instrument" 
                                    value="{{ old('instrument', $facility->instrument) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('instrument')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="instrument_type" class="block text-sm font-medium text-gray-700">Instrument Type *</label>
                                <input type="text" name="instrument_type" id="instrument_type" 
                                    value="{{ old('instrument_type', $facility->instrument_type) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('instrument_type')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 7: Guaranteed & Total Guaranteed -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                            <label for="guaranteed" class="block text-sm font-medium text-gray-700">Guaranteed</label>
                                <div class="mt-1">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="guaranteed" id="guaranteed" value="0"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                            @checked(old('guaranteed', $facility->guaranteed))>
                                        <span class="ml-2">Yes</span>
                                    </label>
                                </div>
                                @error('guaranteed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="total_guaranteed" class="block text-sm font-medium text-gray-700">Total Guaranteed (RM) *</label>
                                <input type="number" name="total_guaranteed" id="total_guaranteed" 
                                    value="{{ old('total_guaranteed', $facility->total_guaranteed) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                    @disabled(!old('guaranteed', $facility->guaranteed))>
                                @error('total_guaranteed')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 8: Indicator & Facility Rating -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="indicator" class="block text-sm font-medium text-gray-700">Indicator *</label>
                                <input type="text" name="indicator" id="indicator" 
                                    value="{{ old('indicator', $facility->indicator) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('indicator')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_rating" class="block text-sm font-medium text-gray-700">Facility Rating *</label>
                                <input type="text" name="facility_rating" id="facility_rating" 
                                    value="{{ old('facility_rating', $facility->facility_rating) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_rating')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Section: Facility Information -->
                    <div class="space-y-6 mt-8 pb-6">
                        <h3 class="text-lg font-medium text-gray-900">Facility Information</h3>

                        <!-- Row 1: Facility Amount & Available Limit -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="facility_amount" class="block text-sm font-medium text-gray-700">Facility Amount (RM) *</label>
                                <input type="number" name="facility_amount" id="facility_amount" 
                                    value="{{ old('facility_amount', $facility->facility_amount) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="available_limit" class="block text-sm font-medium text-gray-700">Available Limit (RM) *</label>
                                <input type="number" name="available_limit" id="available_limit" 
                                    value="{{ old('available_limit', $facility->available_limit) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('available_limit')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Trustee/Security Agent -->
                        <div>
                            <label for="trustee_security_agent" class="block text-sm font-medium text-gray-700">Trustee/Security Agent *</label>
                            <input type="text" name="trustee_security_agent" id="trustee_security_agent" 
                                value="{{ old('trustee_security_agent', $facility->trustee_security_agent) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            @error('trustee_security_agent')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Row 3: Lead Arranger & Availability -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger (LA) *</label>
                                <input type="text" name="lead_arranger" id="lead_arranger" 
                                    value="{{ old('lead_arranger', $facility->lead_arranger) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('lead_arranger')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="availability_date" class="block text-sm font-medium text-gray-700">Availability *</label>
                                <input type="date" name="availability_date" id="availability_date" 
                                    value="{{ old('availability_date', $facility->availability_date->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('availability_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 4: Outstanding & Facility Agent -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="outstanding_amount" class="block text-sm font-medium text-gray-700">Outstanding (RM) *</label>
                                <input type="number" name="outstanding_amount" id="outstanding_amount" 
                                    value="{{ old('outstanding_amount', $facility->outstanding_amount) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('outstanding_amount')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent (FA) *</label>
                                <input type="text" name="facility_agent" id="facility_agent" 
                                    value="{{ old('facility_agent', $facility->facility_agent) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                @error('facility_agent')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
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
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>