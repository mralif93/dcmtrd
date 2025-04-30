<x-app-layout>
    <x-slot name="header">
        <h4 class="text-xl font-semibold text-gray-800">{{ __('Corporate Bond Reports') }}</h4>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto space-y-6 max-w-7xl sm:px-6 lg:px-8">

            <!-- Success Message -->
            @if (session('success'))
                <div
                    class="flex items-start p-4 space-x-2 text-green-800 border-l-4 border-green-600 rounded-md shadow-sm bg-green-50">
                    <svg class="w-6 h-6 mt-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            @endif
            <!-- Search Bar -->
            <div class="flex items-center justify-between py-4">
                <form method="GET" action="{{ route('dcmt-reports.cb-reports') }}"
                    class="flex items-center space-x-4">
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search by Bond Name, Facility Code, etc."
                        class="px-4 py-2 border border-gray-300 rounded-md">
                    <button type="submit" class="px-4 py-2 text-white bg-gray-800 rounded-md">Search</button>
                </form>
            </div>

            <!-- Export Buttons -->
            <div class="flex justify-end">
                <a href="{{ route('dcmt-reports.cb-export', ['type' => 'xls']) }}"
                    class="inline-block px-6 py-2 text-sm font-semibold text-white transition bg-gray-800 rounded-md shadow hover:bg-gray-900">
                    Export XLS
                </a>
            </div>

            <!-- Main Table Card -->
            <div class="overflow-hidden bg-white shadow-xl rounded-xl">
                <!-- Scrollable Table -->
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-sm text-left text-gray-700 table-auto">
                        <thead class="sticky top-0 z-10 bg-gray-100">
                            <tr class="text-xs tracking-wider text-gray-600 uppercase">
                                <th class="px-6 py-3">No</th>
                                <th class="px-6 py-3">Bond</th>
                                <th class="px-6 py-3">Facility Code</th>
                                <th class="px-6 py-3">Issuer Short Name</th>
                                <th class="px-6 py-3">Name</th>
                                <th class="px-6 py-3">Facility Name</th>
                                <th class="px-6 py-3">Debenture/Loan</th>
                                <th class="px-6 py-3">Trustee Role 1</th>
                                <th class="px-6 py-3">Trustee Role 2</th>
                                <th class="px-6 py-3">Nominal Value</th>
                                <th class="px-6 py-3">Outstanding Size</th>
                                <th class="px-6 py-3">Trustee Fee 1</th>
                                <th class="px-6 py-3">Trustee Fee 2</th>
                                <th class="px-6 py-3">Trust Deed Date</th>
                                <th class="px-6 py-3">Issue Date</th>
                                <th class="px-6 py-3">Maturity Date</th>
                                <th class="px-6 py-3">Date Created</th>
                                <th class="px-6 py-3">Last Modified</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $index = ($reports->currentPage() - 1) * $reports->perPage() + 1; @endphp
                            @foreach ($reports as $bond)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $index++ }}</td>
                                    <td class="px-6 py-4">{{ $bond->issuer->issuer_short_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->facility_code ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->bonk_sukuk_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->issuer_short_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->facility?->facility_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->debenture ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->trustee_role_1 ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->trustee_role_2 ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ number_format($bond->facility?->facility_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ number_format($bond->facility?->amount_outstanding, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $bond->facility?->trusteeFees->first()?->trustee_fee_amount_1 }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $bond->facility?->trusteeFees->first()?->trustee_fee_amount_2 }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $bond->issuer->trust_deed_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issue_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ $bond->facility?->maturity_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->created_at?->format('d/m/Y H:i') }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->updated_at?->format('d/m/Y H:i') }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Summary Bar -->
                <div class="sticky bottom-0 z-20 px-6 py-4 bg-gray-100 border-t">
                    <div
                        class="grid gap-6 text-sm font-semibold text-center text-gray-700 md:grid-cols-4 sm:grid-cols-2">
                        <div>
                            <div>Total Nominal Value</div>
                            <div class="text-lg font-bold text-gray-900">RM {{ number_format($totalNominalValue, 2) }}
                            </div>
                        </div>
                        <div>
                            <div>Total Outstanding Size</div>
                            <div class="text-lg font-bold text-gray-900">{{ number_format($totalOutstandingSize, 2) }}
                            </div>
                        </div>
                        <div>
                            <div>Trustee Fee Amount 1</div>
                            <div class="text-lg font-bold text-gray-900">
                                {{ number_format($totalTrusteeFeeAmount1, 2) }}</div>
                        </div>
                        <div>
                            <div>Trustee Fee Amount 2</div>
                            <div class="text-lg font-bold text-gray-900">
                                {{ number_format($totalTrusteeFeeAmount2, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Bond vs Loan Summary -->
                <div class="px-6 py-4 bg-white border-t">
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-700">
                            <thead class="bg-gray-50">
                                <tr class="text-xs text-gray-600 uppercase">
                                    <th class="px-4 py-2">Type</th>
                                    <th class="px-4 py-2">Nominal Value (RM)</th>
                                    <th class="px-4 py-2">Outstanding Size (RM)</th>
                                    <th class="px-4 py-2">Trustee Fee (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="bg-gray-100">
                                    <td class="px-4 py-2 font-semibold">Bond Total</td>
                                    <td class="px-4 py-2">{{ number_format($bondNominal, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($bondOutstanding, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($bondTrusteeFee, 2) }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-semibold">Loan Total</td>
                                    <td class="px-4 py-2">{{ number_format($loanNominal, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($loanOutstanding, 2) }}</td>
                                    <td class="px-4 py-2">{{ number_format($loanTrusteeFee, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 bg-white border-t">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
