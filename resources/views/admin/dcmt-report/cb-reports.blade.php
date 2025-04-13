<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold text-gray-800">{{ __('Corporate Bond Reports') }}</h2>
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
                <a class="px-6 py-2 text-sm font-medium text-white transition-all duration-200 ease-in-out bg-gray-700 rounded-lg hover:bg-gray-800">Export CSV</a>
                <a class="px-6 py-2 text-sm font-medium text-white transition-all duration-200 ease-in-out bg-green-600 rounded-lg hover:bg-green-700">Export Excel</a>
                <a class="px-6 py-2 text-sm font-medium text-white transition-all duration-200 ease-in-out bg-blue-600 rounded-lg hover:bg-blue-700">Export PDF</a>
            </div>

            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <!-- Table with Scroll -->
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="min-w-full border-separate table-auto border-spacing-0">
                        <thead class="bg-gray-50">
                            <tr class="text-xs font-semibold text-gray-600 uppercase">
                                <th class="px-6 py-3 text-left text-gray-500">No</th>
                                <th class="px-6 py-3 text-left text-gray-500">Bond</th>
                                <th class="px-6 py-3 text-left text-gray-500">Facility Code</th>
                                <th class="px-6 py-3 text-left text-gray-500">Issuer Short Name</th>
                                <th class="px-6 py-3 text-left text-gray-500">Facility Name</th>
                                <th class="px-6 py-3 text-left text-gray-500">Debenture/Loan</th>
                                <th class="px-6 py-3 text-left text-gray-500">Trustee Role1</th>
                                <th class="px-6 py-3 text-left text-gray-500">Trustee Role2</th>
                                <th class="px-6 py-3 text-left text-gray-500">Nominal Value</th>
                                <th class="px-6 py-3 text-left text-gray-500">Outstanding Size</th>
                                <th class="px-6 py-3 text-left text-gray-500">Trustee Fee Amount</th>
                                <th class="px-6 py-3 text-left text-gray-500">Trustee Fee Amount2</th>
                                <th class="px-6 py-3 text-left text-gray-500">Trust Deed Date</th>
                                <th class="px-6 py-3 text-left text-gray-500">Issue Date</th>
                                <th class="px-6 py-3 text-left text-gray-500">Maturity Date</th>
                                <th class="px-6 py-3 text-left text-gray-500">Date Created</th>
                                <th class="px-6 py-3 text-left text-gray-500">Last Modified Date</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @php $index = ($reports->currentPage() - 1) * $reports->perPage() + 1; @endphp
                            @foreach ($reports as $bond)
                                <tr class="transition-all duration-150 hover:bg-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $index++ }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $bond->bond_sukuk_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->facility_code }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issuer->issuer_short_name ?? '-' }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->sub_name }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issuer->debenture }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issuer->trustee_role_1 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issuer->trustee_role_2 }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($bond->amount_issued, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ number_format($bond->amount_outstanding, 2) }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->coupon_rate }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->coupon_type }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issuer->trust_deed_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->issue_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->maturity_date?->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->created_at?->format('d/m/Y H:i') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $bond->updated_at?->format('d/m/Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            
                <!-- Summary Row (Sticky to Bottom) -->
                <div class="sticky bottom-0 z-10 px-6 py-4 bg-gray-100 border-t shadow-inner">
                    @php
                        $totalNominalValue = $reports->sum(fn($bond) => (float) $bond->amount_issued);
                        $totalOutstandingSize = $reports->sum(fn($bond) => (float) $bond->amount_outstanding);
                        $totalTrusteeFeeAmount = $reports->sum(fn($bond) => (float) $bond->coupon_rate);
                        $totalTrusteeFeeAmount2 = $reports->sum(fn($bond) => (float) $bond->coupon_type);
                    @endphp
                
                    <div class="grid grid-cols-1 gap-4 text-sm font-semibold text-center text-gray-700 md:grid-cols-4">
                        <div>
                            <span>Total Nominal Value</span><br>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($totalNominalValue, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Outstanding Size</span><br>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($totalOutstandingSize, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Trustee Fee Amount</span><br>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($totalTrusteeFeeAmount, 2) }}</span>
                        </div>
                        <div>
                            <span>Total Trustee Fee Amount2</span><br>
                            <span class="text-lg font-bold text-gray-900">{{ number_format($totalTrusteeFeeAmount2, 2) }}</span>
                        </div>
                    </div>
                </div>
                
                
            
                <!-- Pagination Links -->
                <div class="px-4 py-3 bg-white border-t border-gray-200">
                    {{ $reports->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
