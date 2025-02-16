<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Facility Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Details for the facility "{{ $facility->facility_name }}"</p>
            </div>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Core Information</h3>
                </div>

                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Code</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_code }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Name</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Issuer</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->issuer->issuer_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Principal Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->principal_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Instrument Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->instrument_type }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Maturity Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->maturity_date->format('d/m/Y') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->facility_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Available Limit</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->available_limit, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Outstanding Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->outstanding_amount, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Guaranteed</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->guaranteed ? 'Yes' : 'No' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Guaranteed</dt>
                            <dd class="mt-1 text-sm text-gray-900">${{ number_format($facility->total_guaranteed, 2) }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Trustee Security Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->trustee_security_agent }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lead Arranger</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->lead_arranger }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->facility_agent }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Availability Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">{{ $facility->availability_date->format('d/m/Y') }}</dd>
                        </div>
                    </dl>
                </div>

                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-4">
                        <a href="{{ route('facility-informations.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                        Back to List
                        </a>
                        <a href="{{ route('facility-informations.edit', $facility) }}" 
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