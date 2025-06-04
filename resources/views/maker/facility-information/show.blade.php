<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Facility Information') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('bond-m.details', $facility->issuer) }}"
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
        <div x-data="{ openSection: 'none' }">
            <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

                <div class="flex flex-col justify-between gap-2 mb-6 sm:flex-row sm:items-center sm:gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Facility Code: {{ $facility->facility_code }}</h2>
                        <p class="text-gray-600">Facility Name: {{ $facility->facility_name }}</p>
                    </div>
                    <div>
                        @if ($facility->is_redeemed)
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-green-800 bg-green-100 rounded-full">
                                ✅ Redeemed
                            </span>
                        @else
                            <span
                                class="inline-flex items-center px-3 py-1 text-sm font-medium text-red-800 bg-red-100 rounded-full">
                                ❌ Not Redeemed
                            </span>
                        @endif
                    </div>
                </div>

                <div class="flex justify-end space-x-2">
                    <x-custom-dropdown>
                        <x-slot name="trigger">
                            Create
                        </x-slot>

                        <x-slot name="content">
                            <a href="{{ route('bond-m.create', $issuer) }}"
                                class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                Coupon Payment
                            </a>
                            <a href="{{ route('announcement-m.create', $issuer) }}"
                                class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                Announcement
                            </a>
                            <a href="{{ route('document-m.create', $issuer) }}"
                                class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                Transaction Documents
                            </a>
                            <a href="{{ route('adi-holder-m.create', $issuer) }}"
                                class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                ADI Holder
                            </a>
                        </x-slot>
                    </x-custom-dropdown>

                    <x-custom-dropdown>
                        <x-slot name="trigger">
                            Upload
                        </x-slot>

                        <x-slot name="content">
                            <a href="{{ route('bond-m.upload-form', $issuer) }}"
                                class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                                Upload Coupon Payment
                            </a>
                        </x-slot>
                    </x-custom-dropdown>
                </div>

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
                                    <span class="text-right">
                                        {{ optional($facility->maturity_date)->format('d-M-Y') ?? '-' }}
                                    </span>
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
                                    <span class="text-right">
                                        {{ optional($facility->availability_date)->format('d-M-Y') ?? '-' }}
                                    </span>
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

                <!-- Announcements Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'announcements' ? null : 'announcements'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Announcements</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'announcements' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'announcements'" x-collapse
                        class="overflow-x-auto border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Announce
                                        Date</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Category
                                    </th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Announcement Title</th>
                                    <th
                                        class="flex justify-end px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Action</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($announcements as $announcement)
                                    <tr>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            {{ $announcement->announcement_date->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs text-blue-800 bg-blue-100 rounded-full">
                                                {{ $announcement->category }}
                                            </span>
                                        </td>
                                        <td class="max-w-md px-6 py-4 text-sm">
                                            <a href="{{ route('announcement-m.show', $announcement) }}">
                                                <div class="font-medium text-gray-500">{{ $announcement->title }}
                                                </div>
                                            </a>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('announcement-m.show', $announcement) }}"
                                                    class="text-yellow-600 hover:text-yellow-900" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('announcement-m.edit', $announcement) }}"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                            No announcements found
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($announcements->hasPages())
                            <div class="p-6 border-t">
                                {{ $announcements->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                <!-- Related Documents & Financials Accordion -->
                <div class="bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'documents' ? null : 'documents'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">Transaction Documents</h3>
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
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        Action</th>
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
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('document-m.show', $document) }}"
                                                    class="text-yellow-600 hover:text-yellow-900" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('document-m.edit', $document) }}"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
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
                            <h3 class="text-xl font-semibold">Coupon Payment</h3>
                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'bonds' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>
                    <div x-show="openSection === 'bonds'" x-collapse class="overflow-x-auto border-t border-gray-200">
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
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                        {{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($activeBonds as $bond)
                                    <tr
                                        class="hover:bg-red-50 {{ optional($bond->last_traded_date)->lt(now()) ? 'bg-green-50' : '' }}">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">
                                                <a href="{{ route('bond-m.show', $bond) }}">
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
                                            {{ number_format($bond->amount_outstanding, 2) }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                            <span class="px-2 py-1 text-green-800 bg-green-100 rounded-full">
                                                {{ number_format($bond->residual_tenure_years, 2) }} yrs
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex justify-end space-x-2">
                                                <a href="{{ route('bond-m.show', $bond) }}"
                                                    class="text-yellow-600 hover:text-yellow-900" title="View">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                </a>
                                                <a href="{{ route('bond-m.edit', $bond) }}"
                                                    class="text-yellow-600 hover:text-yellow-900">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
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

                <!-- ADI Holder Accordion -->
                <div class="mt-6 bg-white shadow-sm sm:rounded-lg">
                    <button @click="openSection = openSection === 'ADI' ? null : 'ADI'"
                        class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                        <div class="flex items-center justify-between">
                            <h3 class="text-xl font-semibold">
                                Authorized Depository Institution (ADI) Holder
                                <span class="ml-2 text-sm font-normal text-gray-600">
                                    (Total Outstanding Amount: RM {{ number_format($totalNominal, 2) }})
                                </span>
                            </h3>

                            <svg class="w-6 h-6 transition-transform transform"
                                :class="{ 'rotate-180': openSection === 'ADI' }" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>
                    </button>

                    <div x-show="openSection === 'ADI'" x-collapse class="border-t border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">ADI
                                        Holder</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Stock
                                        Code</th>
                                    <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">(RM)
                                        Nominal
                                        Value</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($adiHolders as $holderName => $records)
                                    <tr class="bg-gray-100">
                                        <td colspan="2" class="px-6 py-3 font-semibold text-gray-700">
                                            {{ $holderName }}
                                        </td>
                                        <td class="px-6 py-3 text-right">
                                            <a href="{{ route('adi-holder-m.edit', ['adiHolderName' => $records->first()->adi_holder]) }}"
                                                class="text-sm text-blue-600 hover:underline">Edit</a>
                                        </td>

                                    </tr>
                                    @foreach ($records as $record)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap"></td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ $record->stock_code }}
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                                {{ number_format($record->nominal_value, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-sm font-semibold text-gray-900 bg-gray-50">
                                        <td class="px-6 py-3 text-right" colspan="2">Total Nominal Value: (RM)</td>
                                        <td class="px-6 py-3">
                                            {{ number_format($records->sum('nominal_value'), 2) }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                            No ADI Holder records found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        @if ($adiHoldersPaginated->hasPages())
                            <div class="p-6 border-t">
                                {{ $adiHoldersPaginated->links() }}
                            </div>
                        @endif
                    </div>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>
