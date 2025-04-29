<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold text-gray-800">{{ __('Trustee Master Reports') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-500 rounded-md shadow-md bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-6 h-6 text-green-500" fill="currentColor" viewBox="0 0 20 20">
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

            <!-- Export Buttons -->
            <div class="flex justify-end mb-6 space-x-2">
                <a
                    class="px-6 py-2 text-sm font-medium text-white transition-all duration-200 ease-in-out bg-gray-700 rounded-lg hover:bg-gray-800">Export
                    CSV</a>
            </div>

            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <!-- Table with Scroll -->
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="min-w-full border-separate table-auto border-spacing-0">
                        <table class="min-w-full border-separate table-auto border-spacing-0">
                            <thead class="bg-gray-50">
                                <tr class="text-xs font-semibold text-gray-600 uppercase">
                                    <th class="px-6 py-3 text-left text-gray-500">Sl No.</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Trust</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Name</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Trust Type</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Trust Amount / Escrow Sum (RM)</th>
                                    <th class="px-6 py-3 text-left text-gray-500">No. Of Shares (unit)</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Outstanding Size</th>
                                    <th class="px-6 py-3 text-left text-gray-500">Trustee Fee Amount</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @php $index = 1; @endphp
                                @foreach ($reports as $item)
                                    <tr class="transition-all duration-150 hover:bg-gray-100">
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ $index++ }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer->issuer_short_name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer->issuer_name ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer->debenture ?? '-' }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ number_format($item->issuer->trust_amount_escrow_sum, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ number_format($item->issuer->no_of_share, 0) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ number_format($item->outstanding_size, 2) }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ number_format($item->trustee_fee_amount, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </table>
                </div>

                <!-- Summary Row (Sticky to Bottom) -->
                {{-- <div class="sticky bottom-0 z-10 px-6 py-4 bg-gray-100 border-t shadow-inner">
                    <div class="grid grid-cols-1 gap-4 text-sm font-semibold text-center text-gray-700 md:grid-cols-4">
                        <div>
                            <span>Total Nominal Value</span><br>
                            <span class="text-lg font-bold text-gray-900">RM
                                {{ number_format($totalNominalValue, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Outstanding Size</span><br>
                            <span
                                class="text-lg font-bold text-gray-900">{{ number_format($totalOutstandingSize, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Trustee Fee Amount 1</span><br>
                            <span
                                class="text-lg font-bold text-gray-900">{{ number_format($totalTrusteeFeeAmount1, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Trustee Fee Amount 2</span><br>
                            <span
                                class="text-lg font-bold text-gray-900">{{ number_format($totalTrusteeFeeAmount2, 2) }}</span>
                        </div>
                    </div>
                </div>

                @php
                    $bondTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Debenture');
                    $loanTotals = $reports->filter(fn($b) => $b->issuer->debenture === 'Loan');

                    $bondNominal = $bondTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
                    $bondOutstanding = $bondTotals->sum(fn($b) => (float) $b->amount_outstanding);
                    $bondTrusteeFee = $bondTotals->sum(
                        fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1,
                    );

                    $loanNominal = $loanTotals->sum(fn($b) => (float) $b->facility?->facility_amount);
                    $loanOutstanding = $loanTotals->sum(fn($b) => (float) $b->amount_outstanding);
                    $loanTrusteeFee = $loanTotals->sum(
                        fn($b) => (float) $b->facility?->trusteeFees->first()?->trustee_fee_amount_1,
                    );
                @endphp


                <div class="px-6 py-4 bg-white border-t shadow-inner">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm text-gray-700 table-auto">
                            <thead>
                                <tr class="text-xs text-left text-gray-600 uppercase">
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Nominal Value (RM)</th>
                                    <th class="px-4 py-2">Outstanding Size (RM)</th>
                                    <th class="px-4 py-2">Trustee Fee (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-50">
                                    <td class="px-4 py-2 font-semibold">BOND TOTAL</td>
                                    <td class="px-4 py-2">{{ number_format($bondNominal, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($bondOutstanding, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($bondTrusteeFee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold">LOAN TOTAL</td>
                                    <td class="px-4 py-2">{{ number_format($loanNominal, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($loanOutstanding, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($loanTrusteeFee, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div> --}}



                <!-- Pagination Links -->
                {{-- <div class="px-4 py-3 bg-white border-t border-gray-200">
                    {{ $reports->links() }}
                </div> --}}
            </div>
        </div>
    </div>
</x-app-layout>
