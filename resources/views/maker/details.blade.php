<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Issuer Information') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('maker.dashboard', ['section' => 'dcmtrd']) }}"
                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 active:bg-gray-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">
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

            <h1 class="text-xl font-bold">{{ $issuer->issuer_name }}</h1>
            <p class="text-grey-800 leading-light">Issuer Short Name: {{ $issuer->issuer_short_name }}</p>
            <p class="text-grey-800 leading-light">Registration Number: {{ $issuer->registration_number }}</p>
        </div>
    </div>

    <div x-data="{ openSection: null }">
        <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

            <div class="flex justify-end space-x-2">
                <x-custom-dropdown>
                    <x-slot name="trigger">
                        Create
                    </x-slot>

                    <x-slot name="content">
                        <a href="{{ route('bond-m.create', $issuer) }}"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                            Bond
                        </a>
                        <a href="{{ route('announcement-m.create', $issuer) }}"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                            Announcement
                        </a>
                        <a href="{{ route('facility-info-m.create', $issuer) }}"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                            Facility Information
                        </a>
                        <a href="{{ route('document-m.create', $issuer) }}"
                            class="block px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100">
                            Document
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
                            Bond
                        </a>
                    </x-slot>
                </x-custom-dropdown>
            </div>
            <!-- Facility Information Accordion -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <button @click="openSection = openSection === 'facilities' ? null : 'facilities'"
                    class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Facility Information</h3>
                        <svg class="w-6 h-6 transition-transform transform"
                            :class="{ 'rotate-180': openSection === 'facilities' }" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="openSection === 'facilities'" x-collapse class="overflow-x-auto border-t border-gray-200">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Facility
                                    Code</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Facility
                                    Name</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Facility
                                    Number</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Type</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Maturity
                                    Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                    Redeem Status
                                </th>

                                <th
                                    class="flex justify-end px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($facilities as $facility)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('facility-info-m.show', $facility) }}">
                                            {{ $facility->facility_code }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $facility->facility_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $facility->facility_number }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs text-purple-800 bg-purple-100 rounded-full">
                                            {{ $facility->instrument_type }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        {{ $facility->maturity_date?->format('d M Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-sm whitespace-nowrap">
                                        @if ($facility->is_redeemed)
                                            <span
                                                class="px-2 py-1 text-xs text-green-800 bg-green-100 rounded-full">Redeemed</span>
                                        @else
                                            <span class="px-2 py-1 text-xs text-red-800 bg-red-100 rounded-full">Not
                                                Redeemed</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex justify-end space-x-2">
                                            <!-- View -->
                                            <a href="{{ route('facility-info-m.show', $facility) }}"
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

                                            <!-- Edit -->
                                            <a href="{{ route('facility-info-m.edit', $facility) }}"
                                                class="text-yellow-600 hover:text-yellow-900" title="Edit">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </a>

                                            <!-- Toggle Redeem -->
                                            <form method="POST" action="{{ route('facility.toggle-redeem', $facility->id) }}">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" title="Toggle Redeem"
                                                    class="{{ $facility->is_redeemed ? 'text-green-600 hover:text-green-800' : 'text-red-600 hover:text-red-800' }}">
                                                    @if ($facility->is_redeemed)
                                                        <!-- Icon for Redeemed -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M5 13l4 4L19 7" />
                                                        </svg>
                                                    @else
                                                        <!-- Icon for Not Redeemed -->
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5"
                                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                        </svg>
                                                    @endif
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        No facilities found
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($facilities->hasPages())
                        <div class="p-6 border-t">
                            {{ $facilities->links() }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Bonds Accordion -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <button @click="openSection = openSection === 'bonds' ? null : 'bonds'"
                    class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Active Bond + Sukuk</h3>
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
                                <th
                                    class="flex justify-end px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                    {{ __('Action') }}</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bonds as $bond)
                                <tr class="hover:bg-gray-50">
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
                                            {{ number_format($bond->residual_tenure_years) }} yrs
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
                                    <td colspan="10" class="px-6 py-4 text-center text-gray-500">
                                        {{ __('No bond issues found') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                    @if ($bonds->hasPages())
                        <div class="p-6 border-t">
                            {{ $bonds->links() }}
                        </div>
                    @endif
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
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Announce
                                    Date</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Category
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
                                            <div class="font-medium text-gray-500">{{ $announcement->title }}</div>
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




            <!-- Documents Accordion -->
            <div class="bg-white shadow-sm sm:rounded-lg">
                <button @click="openSection = openSection === 'documents' ? null : 'documents'"
                    class="w-full px-6 py-4 text-left hover:bg-gray-50 focus:outline-none">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xl font-semibold">Related Documents</h3>
                        <svg class="w-6 h-6 transition-transform transform"
                            :class="{ 'rotate-180': openSection === 'documents' }" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>
                </button>
                <div x-show="openSection === 'documents'" x-collapse class="border-t border-gray-200overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Facility Code</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Document
                                    Type</th>
                                <th class="px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">Document
                                    Name</th>
                                <th
                                    class="flex justify-end px-6 py-3 text-xs font-medium text-left text-gray-500 uppercase">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($documents as $document)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('facility-info-m.show', $document->facility) }}">
                                            {{ $document->facility->facility_code }}
                                        </a>
                                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                                        <span class="px-2 py-1 text-xs bg-gray-100 rounded-full">
                                            {{ $document->document_type }}
                                        </span>
                                    </td>
                                    <td class="max-w-xs px-6 py-4 text-sm text-gray-900">
                                        <a href="{{ asset($document->file_path) }}"
                                            class="text-indigo-600 hover:text-indigo-900" target="_blank" download>
                                            {{ $document->document_name }}
                                        </a>
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
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
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
        </div>
    </div>
</x-main-layout>
