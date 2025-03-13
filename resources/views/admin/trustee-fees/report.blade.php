<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Trustee Fees Report') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Trustee Fees Report</h3>
                    <div class="flex space-x-2">
                        <a href="{{ route('trustee-fees.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back
                        </a>
                        <button onclick="window.print()" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                            </svg>
                            Print Report
                        </button>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="bg-gray-50 px-4 py-4 sm:px-6 border-t border-gray-200 print:hidden">
                    <form method="GET" action="{{ route('trustee-fees.report') }}">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <!-- Date Range Fields -->
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date</label>
                                <input type="date" name="start_date" id="start_date" 
                                       value="{{ request('start_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date</label>
                                <input type="date" name="end_date" id="end_date" 
                                       value="{{ request('end_date') }}" 
                                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <!-- Issuer Filter -->
                            <div>
                                <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer</label>
                                <select name="issuer_id" id="issuer_id" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Issuers</option>
                                    @foreach($issuers ?? [] as $issuer)
                                        <option value="{{ $issuer->id }}" @selected(request('issuer_id') == $issuer->id)>
                                            {{ $issuer->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Payment Status Filter -->
                            <div>
                                <label for="payment_status" class="block text-sm font-medium text-gray-700">Payment Status</label>
                                <select name="payment_status" id="payment_status" 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">All Status</option>
                                    <option value="paid" @selected(request('payment_status') === 'paid')>Paid</option>
                                    <option value="unpaid" @selected(request('payment_status') === 'unpaid')>Unpaid</option>
                                </select>
                            </div>

                            <!-- Generate Report Button -->
                            <div class="flex items-end">
                                <button type="submit" 
                                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Generate Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="px-4 py-5 sm:p-6">
                    <dl class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                        <!-- Total Fees Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Fees</dt>
                                <dd class="mt-1 text-3xl font-semibold text-gray-900">RM {{ number_format($total_fees, 2) }}</dd>
                            </div>
                        </div>

                        <!-- Total Paid Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Paid</dt>
                                <dd class="mt-1 text-3xl font-semibold text-green-600">RM {{ number_format($total_paid, 2) }}</dd>
                            </div>
                        </div>

                        <!-- Total Unpaid Card -->
                        <div class="bg-white overflow-hidden shadow rounded-lg">
                            <div class="px-4 py-5 sm:p-6">
                                <dt class="text-sm font-medium text-gray-500 truncate">Total Unpaid</dt>
                                <dd class="mt-1 text-3xl font-semibold text-red-600">RM {{ number_format($total_unpaid, 2) }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Report Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Issuer</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Invoice No</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fee Amount</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Anniversary Period</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Status</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider print:hidden">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($trustee_fees as $fee)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $fee->issuer->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">{{ $fee->invoice_no }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        RM {{ number_format($fee->trustee_fee_amount_1, 2) }}
                                        @if($fee->trustee_fee_amount_2 > 0)
                                            + RM {{ number_format($fee->trustee_fee_amount_2, 2) }}
                                            = RM {{ number_format($fee->getTotalAmount(), 2) }}
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900">
                                        {{ $fee->start_anniversary_date->format('d/m/Y') }} - 
                                        {{ $fee->end_anniversary_date->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ 
                                        $fee->payment_received ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'
                                    }}">
                                        {{ $fee->payment_received ? 'Paid (' . $fee->payment_received->format('d/m/Y') . ')' : 'Unpaid' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium print:hidden">
                                    <a href="{{ route('trustee-fees.show', $fee) }}" class="text-indigo-600 hover:text-indigo-900">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">
                                    <div class="text-sm text-gray-500">No trustee fees found for the selected criteria.</div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-gray-50">
                            <tr>
                                <td colspan="2" class="px-6 py-4 whitespace-nowrap text-right font-medium">Total:</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">RM {{ number_format($total_fees, 2) }}</div>
                                </td>
                                <td colspan="3" class="px-6 py-4"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <!-- Report Footer -->
                <div class="px-4 py-6 sm:px-6 print:mt-8">
                    <div class="text-sm text-gray-500 print:border-t print:pt-4">
                        <p>Report generated on: {{ now()->format('d/m/Y H:i') }}</p>
                        <p>Filters applied: 
                            @if(request('start_date') || request('end_date') || request('issuer_id') || request('payment_status'))
                                @if(request('start_date'))
                                    Start Date: {{ request('start_date') }}
                                @endif
                                @if(request('end_date'))
                                    End Date: {{ request('end_date') }}
                                @endif
                                @if(request('issuer_id'))
                                    Issuer: {{ optional($issuers->firstWhere('id', request('issuer_id')))->name ?? request('issuer_id') }}
                                @endif
                                @if(request('payment_status'))
                                    Payment Status: {{ ucfirst(request('payment_status')) }}
                                @endif
                            @else
                                None
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            body * {
                font-size: 12px;
            }
            .print\:hidden {
                display: none !important;
            }
            .print\:border-t {
                border-top-width: 1px;
            }
            .print\:pt-4 {
                padding-top: 1rem;
            }
            .print\:mt-8 {
                margin-top: 2rem;
            }
            h2, h3 {
                font-size: 16px;
                font-weight: bold;
            }
        }
    </style>
</x-app-layout>