<x-main-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Issuer Information') }}
            </h2>

            <!-- Back Button -->
            <a href="{{ route('approver.dashboard', ['section' => 'dcmtrd']) }}"
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

    <div x-data="{ openSection: 'facilities' }">
        <div class="pb-6 mx-auto space-y-4 max-w-7xl sm:px-6 lg:px-8">

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
                                <th class="px-6 py-3 text-xs font-medium text-right text-gray-500 uppercase">Action
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($facilities as $facility)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        <a href="{{ route('facility-info-a.show', $facility) }}">
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
                                        {{ $facility->maturity_date->format('d M Y') }}
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
                                        <div class="flex justify-end">
                                            <a href="{{ route('facility-info-a.show', $facility) }}"
                                                class="text-yellow-600 hover:text-yellow-900">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
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
        </div>
    </div>
</x-main-layout>
