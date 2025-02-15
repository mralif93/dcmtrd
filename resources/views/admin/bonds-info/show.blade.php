<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bond Detailed Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">ISIN: <code class="bg-gray-100 p-1 rounded">{{ $bondInfo->isin_code }}</code></p>
                <p class="text-sm text-gray-500">Associated Bond: {{ $bondInfo->bond->bond_sukuk_name ?? 'N/A' }}</p>
            </div>

            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-400">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <!-- Core Information -->
                <div class="px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-medium text-gray-900">Core Bond Details</h3>
                </div>
                
                <div class="border-t border-gray-200">
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6 px-4 py-5 sm:p-6">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Principal Amount</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    RM{{ number_format($bondInfo->principal, 2) }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Islamic Concept</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $bondInfo->islamic_concept }} <!-- Changed from boolean check to direct value -->
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stock Code</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">
                                    {{ $bondInfo->stock_code ?? 'N/A' }}
                                </dd>
                            </div>

                            <!-- Added Facility Information -->
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Facility Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $bondInfo->facility_code }}
                                </dd>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $bondInfo->category }} / {{ $bondInfo->sub_category }}
                                </dd>
                            </div>
                            
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Instrument Code</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-mono">
                                    {{ $bondInfo->instrument_code }}
                                </dd>
                            </div>

                            <!-- Added Day Count Convention -->
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Day Count Convention</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $bondInfo->day_count }}
                                </dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <!-- Coupon Details -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Coupon Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Type</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->coupon_type }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Rate</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ number_format($bondInfo->coupon_rate, 2) }}%
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Payment Frequency</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ ucfirst($bondInfo->coupon_frequency) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Coupon Accrual</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                RM{{ number_format($bondInfo->coupon_accrual, 2) }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Trading Information -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Trading Information</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Yield</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ number_format($bondInfo->last_traded_yield, 2) }}%
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Price</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ number_format($bondInfo->last_traded_price, 4) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                RM{{ number_format($bondInfo->last_traded_amount, 2) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Last Traded Date</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->last_traded_date?->format('d/m/Y') ?? 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Payment Schedule -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Schedule</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Previous Payment</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->prev_coupon_payment_date?->format('d/m/Y') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">First Payment</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->first_coupon_payment_date?->format('d/m/Y') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Next Payment</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->next_coupon_payment_date?->format('d/m/Y') ?? 'N/A' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Final Payment</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->last_coupon_payment_date?->format('d/m/Y') ?? 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- Issuance Details -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Issuance Details</h3>
                    <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Amount Issued</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                RM{{ number_format($bondInfo->amount_issued, 2) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Outstanding Amount</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                RM{{ number_format($bondInfo->amount_outstanding, 2) }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Lead Arranger</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->lead_arranger }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Facility Agent</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                {{ $bondInfo->facility_agent }}
                            </dd>
                        </div>
                    </dl>
                </div>

                <!-- System Information (Keep existing) -->

                <!-- Actions -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('bond-info.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <!-- Back button SVG -->
                            Back to List
                        </a>
                        <a href="{{ route('bond-info.edit', $bondInfo) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <!-- Edit button SVG -->
                            Edit Details
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>