<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Bond Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
                <!-- Core Information Section -->
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Core Information</h3>
                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Left Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Bond/Sukuk Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->bond_sukuk_name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Issuer Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    {{ $bond->issuer->issuer_short_name ?? 'N/A' }} - {{ $bond->issuer->issuer_name ?? 'N/A' }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">ISIN Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->isin_code ?? 'N/A' }}</dd>
                            </div>
                        </div>

                        <!-- Right Column -->
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Sub Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->sub_name ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Stock Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->stock_code ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Instrument Code</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->instrument_code ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tenure & Dates Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Tenure & Dates</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Issue Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->issue_date->format('d/m/Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Maturity Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->maturity_date->format('d/m/Y') }}</dd>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Issue Tenure</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->issue_tenure_years ?? 'N/A' }} years</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Residual Tenure</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->residual_tenure_years ?? 'N/A' }} years</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Coupon Details Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Coupon Details</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Coupon Rate</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_rate ?? 'N/A' }}%</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Coupon Type</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_type ?? 'N/A' }}</dd>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Frequency</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->coupon_frequency ?? 'N/A' }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Day Count</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->day_count ?? 'N/A' }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Financial Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Amount Issued (RM'mil)</dt>
                                <dd class="mt-1 text-sm text-gray-900"> {{ number_format($bond->amount_issued, 2) }}</dd>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Outstanding Amount (RM'mil)</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ number_format($bond->amount_outstanding, 2) }}</dd>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rating Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Rating Information</h3>
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Current Rating</dt>
                            <dd class="mt-1 text-sm text-gray-900">
                                <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                    {{ $bond->rating }}
                                </span>
                            </dd>
                        </div>
                        
                        <div>
                            <dt class="text-sm font-medium text-gray-500 mb-2">Rating History</dt>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Agency</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Effective Date</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rating</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Outlook</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @forelse($bond->ratingMovements as $movement)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->rating_agency }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">{{ $movement->effective_date->format('d/m/Y') }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                                    {{ $movement->rating }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->rating_action }}</td>
                                            <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-900">{{ $movement->rating_outlook }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">No rating history available</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Information Section -->
                <div class="border-t border-gray-200 px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-sm">
                                        {{ $bond->status ?? 'N/A' }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Approval Date/Time</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->approval_date_time->format('d/m/Y H:i A') }}</dd>
                            </div>
                        </div>
                        <div class="space-y-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->created_at->format('d/m/Y H:i A') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500">Updated At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $bond->updated_at->format('d/m/Y H:i A') }}</dd>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Action Buttons -->
                <div class="border-t border-gray-200 px-4 py-4 sm:px-6">
                    <div class="flex justify-end gap-x-4">
                        <a href="{{ route('bonds.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Back to List
                        </a>
                        <a href="{{ route('bonds.edit', $bond) }}" 
                        class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                            </svg>
                            Edit Bond
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>