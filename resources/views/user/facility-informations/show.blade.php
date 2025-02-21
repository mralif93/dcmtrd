<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facility Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">General Information</h3>
                </div>

                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <!-- Row 1: Issuer -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issuer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->issuer->issuer_name }}</dd>
                        </div>

                        <!-- Row 2: Facility Name -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_name }}</dd>
                        </div>

                        <!-- Row 3: Facility Code & Facility Number -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Number</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_number }}</dd>
                        </div>

                        <!-- Row 4: Principal Type & Islamic Concept -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Principal Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->principal_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Islamic Concept</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->islamic_concept }}</dd>
                        </div>

                        <!-- Row 5: Maturity Date -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Maturity Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->maturity_date->format('d/m/Y') }}</dd>
                        </div>

                        <!-- Row 6: Instrument & Instrument Type -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Instrument</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->instrument }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Instrument Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->instrument_type }}</dd>
                        </div>

                        <!-- Row 7: Guaranteed & Total Guaranteed -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Guaranteed</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->guaranteed ? 'Yes' : 'No' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Guaranteed</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->total_guaranteed, 2) }}</dd>
                        </div>

                        <!-- Row 8: Indicator & Facility Rating -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Indicator</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->indicator }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Rating</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_rating }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Facility Information</h3>
                </div>

                <div class="px-4 py-5 sm:px-6">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <!-- Row 1: Facility Amount & Available Limit -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Amount (RM)</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->facility_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Available Limit (RM)</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->available_limit, 2) }}</dd>
                        </div>

                        <!-- Row 2: Trustee/Security Agent -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Trustee/Security Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->trustee_security_agent }}</dd>
                        </div>

                        <!-- Row 3: Lead Arranger & Availability -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lead Arranger (LA)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->lead_arranger }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Availability</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->availability_date->format('d/m/Y') }}</dd>
                        </div>

                        <!-- Row 4: Outstanding & Facility Agent -->
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Outstanding (RM)</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->outstanding_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Agent (FA)</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_agent }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('facility-informations-info.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('facility-informations-info.edit', $facility) }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Facility
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>