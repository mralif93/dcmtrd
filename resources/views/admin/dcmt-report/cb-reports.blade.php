<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold leading-tight text-gray-800">
                {{ __('Corporate Bond Reports') }}
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

            {{-- Success/Error Messages --}}
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

            {{-- Summary Cards --}}
            <div class="grid gap-6 mb-10 sm:grid-cols-2 md:grid-cols-4">
                @php
                    $summaries = [
                        [
                            'label' => 'Total Nominal Value',
                            'value' => $totalNominalValue,
                            'bg' => 'from-blue-100 to-blue-50',
                            'text' => 'text-blue-800',
                        ],
                        [
                            'label' => 'Total Outstanding Size',
                            'value' => $totalOutstandingSize,
                            'bg' => 'from-purple-100 to-purple-50',
                            'text' => 'text-purple-800',
                        ],
                        [
                            'label' => 'Trustee Fee Amount 1',
                            'value' => $totalTrusteeFeeAmount1,
                            'bg' => 'from-green-100 to-green-50',
                            'text' => 'text-green-800',
                        ],
                        [
                            'label' => 'Trustee Fee Amount 2',
                            'value' => $totalTrusteeFeeAmount2,
                            'bg' => 'from-pink-100 to-pink-50',
                            'text' => 'text-pink-800',
                        ],
                    ];
                @endphp

                @foreach ($summaries as $item)
                    <div
                        class="p-5 transition-all duration-300 ease-in-out bg-gradient-to-br {{ $item['bg'] }} shadow-md rounded-2xl hover:shadow-lg">
                        <div class="mb-1 text-xs font-semibold tracking-wide text-gray-500 uppercase">
                            {{ $item['label'] }}
                        </div>
                        <div class="text-2xl font-bold {{ $item['text'] }}">RM {{ number_format($item['value'], 2) }}
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Bond vs Loan Summary Cards --}}
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                {{-- Bond Summary --}}
                <div
                    class="p-6 transition-all duration-300 ease-in-out shadow bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-between pb-2 mb-4 border-b">
                        <h3 class="text-lg font-semibold text-yellow-800">Bond Summary</h3>
                        <span
                            class="text-xs font-semibold text-yellow-600 bg-yellow-200 px-2 py-0.5 rounded-full">BOND</span>
                    </div>
                    <div class="space-y-3 text-yellow-900">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Nominal Value</span>
                            <span class="font-semibold">RM {{ number_format($bondNominal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Outstanding Size</span>
                            <span class="font-semibold">RM {{ number_format($bondOutstanding, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Trustee Fee</span>
                            <span class="font-semibold">RM {{ number_format($bondTrusteeFee, 2) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Loan Summary --}}
                <div
                    class="p-6 transition-all duration-300 ease-in-out shadow bg-gradient-to-br from-teal-100 to-teal-50 rounded-2xl hover:shadow-lg">
                    <div class="flex items-center justify-between pb-2 mb-4 border-b">
                        <h3 class="text-lg font-semibold text-teal-800">Loan Summary</h3>
                        <span class="text-xs font-semibold text-red-600 bg-red-200 px-2 py-0.5 rounded-full">LOAN</span>
                    </div>
                    <div class="space-y-3 text-teal-900">
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Nominal Value</span>
                            <span class="font-semibold">RM {{ number_format($loanNominal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Outstanding Size</span>
                            <span class="font-semibold">RM {{ number_format($loanOutstanding, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="font-medium">Trustee Fee</span>
                            <span class="font-semibold">RM {{ number_format($loanTrusteeFee, 2) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Search and Actions --}}
            <div class="flex flex-col items-center justify-between gap-4 md:flex-row md:gap-0">
                <form method="GET" action="{{ route('dcmt-reports.cb-reports') }}"
                    class="flex w-full max-w-md space-x-2">
                    <input type="text" name="search" value="{{ request('search') }}"
                        class="flex-1 px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-300"
                        placeholder="Search by Bond Name, Facility Code, etc.">
                    <button type="submit" class="px-4 py-2 text-white bg-indigo-600 rounded-lg hover:bg-indigo-700">
                        Search
                    </button>
                    @if (request('search'))
                        <a href="{{ route('dcmt-reports.cb-reports') }}"
                            class="px-4 py-2 text-gray-700 bg-gray-200 border border-gray-300 rounded-lg hover:bg-gray-300">
                            Clear
                        </a>
                    @endif
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

            {{-- Main Table --}}
            <div class="overflow-hidden bg-white rounded-lg shadow-md">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    No</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Bond</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Facility Code</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Issuer</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Facility Name</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Type</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Nominal Value</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Outstanding</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Trustee Fee 1</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Trustee Fee 2</th>
                                <th scope="col"
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Maturity Date</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php $index = ($facilities->currentPage() - 1) * $facilities->perPage() + 1; @endphp
                            @forelse ($facilities as $facility)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $index++ }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $facility->issuer_short_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $facility->facility_code ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $facility->issuer->issuer_short_name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $facility->facility_name ?? '-' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">{{ $facility->issuer->debenture ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        {{ number_format($facility->facility_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        {{ number_format($facility->outstanding_amount, 2) }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        {{ $facility->trusteeFees->first()?->trustee_fee_amount_1 ?? '0.00' }}</td>
                                    <td class="px-6 py-4 text-right whitespace-nowrap">
                                        {{ $facility->trusteeFees->first()?->trustee_fee_amount_2 ?? '0.00' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        {{ $facility->maturity_date?->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="11" class="px-6 py-4 text-center text-gray-500">No records found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-6 py-4 bg-white border-t">
                    {{ $facilities->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
