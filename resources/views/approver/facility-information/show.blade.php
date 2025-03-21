<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Facility Information') }}
            </h2>
            
            <!-- Back Button -->
            <a href="{{ route('bond-a.details', $facility->issuer) }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div x-data="{ openSection: 'general' }">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-4 pb-6">
                
                <h2 class="text-2xl font-bold">{{ $facility->issuer->issuer_name }}</h2>
                <p>Issuer Short Name: {{ $facility->issuer->issuer_short_name }}</p>

                <!-- General + Facility Information Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'general' ? null : 'general'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">General + Facility Information</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'general' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'general'" x-collapse class="border-t border-gray-200 p-6">
                        <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b pb-2">
                        {{ __('General Information') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
                        <div class="space-y-2">
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Facility Code:</strong>
                                <span class="text-right">{{ $facility->facility_code }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Principle:</strong>
                                <span class="text-right">{{ $facility->principle_type }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Maturity Date:</strong>
                                <span class="text-right">{{ $facility->maturity_date->format('d-M-Y') }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Instrument:</strong>
                                <span class="text-right">{{ $facility->instrument }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Guaranteed:</strong>
                                <span class="text-right">{{ $facility->guaranteed }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Indicator:</strong>
                                <span class="text-right">{{ $facility->indicator }}</span>
                            </p>
                        </div>
                        <div class="space-y-2">
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Facility Number:</strong>
                                <span class="text-right">{{ $facility->facility_number }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Islamic Concept:</strong>
                                <span class="text-right">RM {{ $facility->islamic_concept }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">...</strong>
                                <span class="text-right"></span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Instrument Type:</strong>
                                <span class="text-right">RM {{ $facility->instrument_type }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Total Guaranteed (RM):</strong>
                                <span class="text-right">{{ number_format($facility->total_guaranteed, 2) }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Facility Rating:</strong>
                                <span class="text-right">{{ $facility->facility_rating }}</span>
                            </p>
                        </div>
                        </div>

                        <h2 class="font-semibold text-xl text-gray-800 leading-tight border-b pb-2 pt-6">
                        {{ __('Facility Information') }}
                        </h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pt-6">
                        <div class="space-y-2">
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Facility Amount:</strong>
                                <span class="text-right">{{ $facility->facility_amount }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Available Limit:</strong>
                                <span class="text-right">{{ $facility->available_limit }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Trustee/Security Agent:</strong>
                                <span class="text-right">{{ $facility->trustee_security_agent }}</span>
                            </p>
                        </div>
                        <div class="space-y-2">
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Lead Arranger (LA):</strong>
                                <span class="text-right">{{ $facility->lead_arranger }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Availability:</strong>
                                <span class="text-right">{{ $facility->availability_date->format('d-M-Y') }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Outstanding (RM):</strong>
                                <span class="text-right">{{ $facility->outstanding_amount }}</span>
                            </p>
                            <p class="flex justify-between">
                                <strong class="text-gray-700">Facility Agent (FA):</strong>
                                <span class="text-right">{{ $facility->facility_agent }}</span>
                            </p>
                        </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Movements Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'ratings' ? null : 'ratings'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Rating Movements</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'ratings' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'ratings'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Agency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Rating</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Action</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Outlook</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($ratingMovements as $movement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $movement->effective_date->format('d M Y') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $movement->rating_agency }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                            {{ $movement->rating }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $movement->rating_action }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $movement->rating_outlook }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No rating movements found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($ratingMovements->hasPages())
                        <div class="p-4 border-t">
                            {{ $ratingMovements->links() }}
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Related Documents & Financials Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'documents' ? null : 'documents'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">Related Documents & Financials</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'documents' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'documents'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Document Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Document Name</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-gray-100 rounded-full text-xs">
                                            {{ $document->document_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 max-w-xs">
                                        <a href="{{ asset($document->file_path) }}"
                                            class="text-indigo-600 hover:text-indigo-900"
                                            target="_blank" download>
                                            {{ $document->document_name }}
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                                        No documents found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($documents->hasPages())
                            <div class="p-6 border-t">
                                {{ $documents->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Active Bonds + Sukuk Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'bonds' ? null : 'bonds'" 
                            class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex justify-between items-center">
                            <h3 class="text-xl font-semibold">List of Active Bond + Sukuk</h3>
                            <svg class="w-6 h-6 transform transition-transform" 
                                :class="{ 'rotate-180': openSection === 'bonds' }" 
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'bonds'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Bond/Sukuk Name') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Rating') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Category') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Last Traded Date') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Yield (%)') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Price (RM)') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Traded Amt (RM mil)') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('O/S Amt (RM mil)') }}</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">{{ __('Residual Tenure') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($activeBonds as $bond)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">
                                            <a href="{{ route('security-info.show', $bond) }}">
                                                {{ $bond->bond_sukuk_name }}
                                            </a>
                                        </div>
                                        @if($bond->sub_name)
                                            <div class="text-sm text-gray-500 mt-1">{{ $bond->sub_name }}</div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs">
                                            {{ $bond->rating ?? __('N/A') }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="px-2 py-1 bg-indigo-100 text-indigo-800 rounded-full text-xs">
                                            {{ $bond->category }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bond->last_traded_date?->format('d M Y') ?? __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bond->last_traded_yield ? number_format($bond->last_traded_yield, 2) : __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bond->last_traded_price ? number_format($bond->last_traded_price, 2) : __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $bond->last_traded_amount ? number_format($bond->last_traded_amount, 2) : __('N/A') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($bond->o_s_amount, 2) }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full">
                                            {{ number_format($bond->residual_tenure, 2) }} yrs
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No active bonds found
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                        @if($activeBonds->hasPages())
                        <div class="p-4 border-t">
                            {{ $activeBonds->links() }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>