<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Facility Information') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('bond-a.details', $facility->issuer) }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Home
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div x-data="{ openSection: 'null' }">
            <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

                <h2 class="text-2xl font-bold">{{ $facility->issuer->issuer_name }}</h2>
                <p>Issuer Short Name: {{ $facility->issuer->issuer_short_name }}</p>

                <!-- General + Facility Information Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'general' ? null : 'general'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">General + Facility Information</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'general' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'general'" x-collapse class="p-6 border-t border-gray-200">
                        <h2 class="pb-2 text-xl font-semibold leading-tight text-gray-800 border-b">
                            {{ __('General Information') }}
                        </h2>
                        <div class="grid grid-cols-1 gap-4 pt-6 md:grid-cols-2">
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

                        <h2 class="pt-6 pb-2 text-xl font-semibold leading-tight text-gray-800 border-b">
                            {{ __('Facility Information') }}
                        </h2>
                        <div class="grid grid-cols-1 gap-4 pt-6 md:grid-cols-2">
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
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Rating Movements</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'ratings' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'ratings'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Date
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Agency
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Rating
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Action
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Outlook
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($ratingMovements as $movement)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $movement->effective_date->format('d M Y') }}</td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $movement->rating_agency }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                                {{ $movement->rating }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">{{ $movement->rating_action }}
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $movement->rating_outlook }}</td>
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
                        @if ($ratingMovements->hasPages())
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
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Related Documents & Financials</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'documents' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'documents'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Document Type</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Document Name</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($documents as $document)
                                    <tr>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs bg-gray-100 rounded-full">
                                                {{ $document->document_type }}
                                            </span>
                                        </td>
                                        <td class="max-w-xs px-6 py-4 text-sm text-gray-900">
                                            @if ($document->file_path)
                                                <a href="{{ asset('storage/' . $document->file_path) }}"
                                                    class="text-indigo-600 hover:text-indigo-900" target="_blank">
                                                    {{ $document->document_name }}
                                                </a>
                                            @else
                                                {{ $document->document_name }}
                                            @endif
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
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">List of Active Bond + Sukuk</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'bonds' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'bonds'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Bond/Sukuk Name') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Rating') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Category') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Last Traded Date') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Yield (%)') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Price (RM)') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Traded Amt (RM mil)') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('O/S Amt (RM mil)') }}</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Residual Tenure') }}</th>
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
                                            @if ($bond->sub_name)
                                                <div class="mt-1 text-sm text-gray-500">{{ $bond->sub_name }}</div>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                                {{ $bond->rating ?? __('N/A') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
                                                {{ $bond->category }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $bond->last_traded_date?->format('d M Y') ?? __('N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $bond->last_traded_yield ? number_format($bond->last_traded_yield, 2) : __('N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $bond->last_traded_price ? number_format($bond->last_traded_price, 2) : __('N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ $bond->last_traded_amount ? number_format($bond->last_traded_amount, 2) : __('N/A') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            {{ number_format($bond->o_s_amount, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="px-2 py-1 text-green-800 bg-green-100 rounded-full">
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
                        @if ($activeBonds->hasPages())
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
