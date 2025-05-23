<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Trust Master Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">

            {{-- Success Message --}}
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-md shadow bg-green-50">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-green-800">{{ session('success') }}</p>
                    </div>
                </div>
            @endif

            {{-- Error Message --}}
            @if (session('error'))
                <div class="p-4 mb-6 border-l-4 border-red-500 rounded-md shadow bg-red-50">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd" />
                        </svg>
                        <p class="ml-3 text-sm font-medium text-red-800">{{ session('error') }}</p>
                    </div>
                </div>
            @endif

            <div class="flex flex-col items-center justify-between gap-4 md:flex-row md:gap-0">
                <form method="GET" action="{{ route('dcmt-reports.cb-reports') }}"
                    class="flex w-full max-w-md space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300"
                        placeholder="Search by Bond Name, Facility Code, etc.">
                    <button type="submit"
                        class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">Search</button>
                </form>

                <div class="flex flex-wrap justify-end gap-2">
                    {{-- <a href="{{ route('a.dcmt-reports.cb-export.a', ['type' => 'xls']) }}"
                        class="px-6 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700">
                        Export XLS
                    </a> --}}
                    <a href="{{ route('dcmt-reports.trustee-reports.batches') }}"
                        class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        View Batches
                    </a>
                    <form method="POST" action="{{ route('dcmt-reports.trustee-reports.cutoff') }}">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to cut off and save this report to a batch?')"
                            class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Cut Off (Save to Batch)
                        </button>
                    </form>

                </div>
            </div>

            {{-- Data Table --}}
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-sm text-left text-gray-700 table-auto">
                        <thead class="sticky top-0 z-10 bg-indigo-50">
                            <tr class="text-xs font-semibold text-gray-600 uppercase">
                                <th class="px-6 py-3 text-left">Sl No.</th>
                                <th class="px-6 py-3 text-left">Trust</th>
                                <th class="px-6 py-3 text-left">Name</th>
                                <th class="px-6 py-3 text-left">Trust Type</th>
                                <th class="px-6 py-3 text-left">Trust Amount / Escrow Sum (RM)</th>
                                <th class="px-6 py-3 text-left">No. Of Shares (unit)</th>
                                <th class="px-6 py-3 text-left">Outstanding Size</th>
                                <th class="px-6 py-3 text-left">Trustee Fee Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $totalTrustAmount = 0;
                                $totalShares = 0;
                                $totalOutstanding = 0;
                                $totalTrusteeFee = 0;

                                foreach ($reports as $item) {
                                    $totalTrustAmount += is_numeric($item->trust_amount_escrow_sum)
                                        ? (float) $item->trust_amount_escrow_sum
                                        : 0;
                                    $totalShares += is_numeric($item->no_of_share) ? (int) $item->no_of_share : 0;
                                    $totalOutstanding += is_numeric($item->outstanding_size)
                                        ? (float) $item->outstanding_size
                                        : 0;
                                    $totalTrusteeFee += is_numeric($item->total_trustee_fee)
                                        ? (float) $item->total_trustee_fee
                                        : 0;
                                }
                            @endphp

                            @forelse ($reports as $index => $item)
                                <tr class="transition-all duration-150 hover:bg-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $reports->firstItem() + $index }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer_short_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->debenture ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ is_numeric($item->trust_amount_escrow_sum) ? number_format((float) $item->trust_amount_escrow_sum, 2) : '0.00' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ is_numeric($item->no_of_share) ? number_format((float) $item->no_of_share, 0) : '0' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ is_numeric($item->outstanding_size) ? number_format((float) $item->outstanding_size, 2) : '0.00' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-500">
                                        {{ number_format($item->total_trustee_fee, 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-sm text-center text-gray-500">
                                        No records found.
                                    </td>
                                </tr>
                            @endforelse

                            {{-- Grand total row --}}
                            @if ($reports->count())
                                <tr class="font-semibold bg-indigo-100">
                                    <td colspan="4" class="px-6 py-4 text-right">Grand Total</td>
                                    <td class="px-6 py-4">{{ number_format($totalTrustAmount, 2) }}</td>
                                    <td class="px-6 py-4">{{ number_format($totalShares, 0) }}</td>
                                    <td class="px-6 py-4">{{ number_format($totalOutstanding, 2) }}</td>
                                    <td class="px-6 py-4">{{ number_format($totalTrusteeFee, 2) }}</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-3 bg-white border-t border-gray-200">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
