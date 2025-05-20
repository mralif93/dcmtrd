<x-app-layout>
    <x-slot name="header">
        <h2 class="text-2xl font-bold leading-tight text-left text-gray-800">
            {{ __('Corporate Bond Reports') }}
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
            <!-- Search, Export, View Batches, and Cut Off -->
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
                    <a href="{{ route('dcmt-reports.cb-export', ['type' => 'xls']) }}"
                        class="px-6 py-2 text-sm font-semibold text-white bg-green-600 rounded-lg hover:bg-green-700">
                        Export XLS
                    </a>
                    <a href="{{ route('dcmt-reports.cb-reports.batches') }}"
                        class="px-6 py-2 text-sm font-semibold text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        View Batches
                    </a>
                    <form method="POST" action="{{ route('dcmt-reports.cb-reports.cutoff') }}">
                        @csrf
                        <button type="submit"
                            onclick="return confirm('Are you sure you want to cut off and save this report to a batch?')"
                            class="px-6 py-2 text-sm font-semibold text-white bg-red-600 rounded-lg hover:bg-red-700">
                            Cut Off (Save to Batch)
                        </button>
                    </form>

                </div>
            </div>

            <!-- Main Table Card -->
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="w-full text-sm text-left text-gray-700 table-auto">
                        <thead class="sticky top-0 z-10 bg-indigo-50">
                            <tr class="text-xs font-semibold text-gray-600 uppercase">
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
                            @forelse ($reports as $bond)
                                <tr class="hover:bg-gray-50 even:bg-gray-50">
                                    <td class="px-6 py-4">{{ $index++ }}</td>
                                    <td class="px-6 py-4">{{ $bond->facility->issuer_short_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->facility_code ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->bonk_sukuk_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->issuer_short_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->facility?->facility_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->debenture ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->trustee_role_1 ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">{{ $bond->issuer->trustee_role_2 ?? '-' }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ number_format($bond->facility?->facility_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-gray-500">
                                        {{ number_format($bond->facility?->outstanding_amount, 2) }}</td>
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
                            @empty
                                <tr></tr>
                                <td colspan="17" class="px-6 py-4 text-center text-gray-500">No records found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Summary Bar -->
                <div class="sticky bottom-0 z-20 px-6 py-4 border-t bg-indigo-50">
                    <div
                        class="grid gap-6 text-sm font-semibold text-center text-gray-700 md:grid-cols-4 sm:grid-cols-2">
                        <div>
                            <div>Total Nominal Value</div>
                            <div class="text-lg font-bold text-gray-900">RM {{ number_format($totalNominalValue, 2) }}
                            </div>
                        </div>
                        <div>
                            <div>Total Outstanding Size</div>
                            <div class="text-lg font-bold text-gray-900">RM {{ number_format($totalOutstandingSize, 2) }}
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
