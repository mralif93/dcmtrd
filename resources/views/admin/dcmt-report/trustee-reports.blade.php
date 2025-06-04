<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                {{ __('Trust Master Reports') }}
            </h2>

            {{-- Back Button --}}
            <a href="{{ route('dcmt-reports.index') }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 transition duration-150 ease-in-out bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-100 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Back
            </a>
        </div>
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
                <form method="GET" action="{{ route('dcmt-reports.trustee-reports') }}"
                    class="flex w-full max-w-md space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300"
                        placeholder="Search by Bond Name, Facility Code, etc.">
                    <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Search
                    </button>
                    @if (request('search'))
                        <a href="{{ route('dcmt-reports.trustee-reports') }}"
                            class="px-4 py-2 text-gray-700 bg-gray-200 border border-gray-300 rounded-lg hover:bg-gray-300">
                            Clear
                        </a>
                    @endif
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
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-sm text-left text-gray-800 table-auto">
                        <thead class="sticky top-0 z-10 shadow-sm bg-indigo-50">
                            <tr class="text-xs font-semibold tracking-wide text-gray-600 uppercase">
                                <th class="px-6 py-3">Sl No.</th>
                                <th class="px-6 py-3">Trust</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Trust Type</th>
                                <th class="px-6 py-3 text-right">Trust Amount / Escrow Sum (RM)</th>
                                <th class="px-6 py-3 text-right">No. Of Shares (unit)</th>
                                <th class="px-6 py-3 text-right">Outstanding Size</th>
                                <th class="px-6 py-3 text-right">Trustee Fee Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php
                                $totalTrustAmount = 0;
                                $totalShares = 0;
                                $totalOutstanding = 0;
                                $totalTrusteeFee = 0;
                            @endphp

                            @forelse ($reports as $index => $item)
                                @php
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
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $reports->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 truncate max-w-[180px]"
                                        title="{{ $item->issuer_short_name }}">
                                        {{ $item->issuer_short_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 truncate max-w-[220px]" title="{{ $item->issuer_name }}">
                                        {{ $item->issuer_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4">{{ $item->debenture ?? '-' }}</td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format((float) ($item->trust_amount_escrow_sum ?? 0), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format((float) ($item->no_of_share ?? 0), 0) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format((float) ($item->outstanding_size ?? 0), 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        {{ number_format((float) ($item->total_trustee_fee ?? 0), 2) }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-sm text-center text-gray-500">No records
                                        found.</td>
                                </tr>
                            @endforelse

                            {{-- Grand Total Row --}}
                            @if ($reports->count())
                                <tr class="font-semibold text-right text-indigo-900 bg-indigo-100">
                                    <td colspan="4" class="px-6 py-4 text-left">Grand Total</td>
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
                <div class="px-4 py-3 border-t bg-gray-50">
                    {{ $reports->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
