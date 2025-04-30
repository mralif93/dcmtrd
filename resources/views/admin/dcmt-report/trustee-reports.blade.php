<x-app-layout>
    <x-slot name="header">
        <h2 class="text-3xl font-semibold text-gray-800">{{ __('Trustee Master Reports') }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            
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

            {{-- Export Button --}}
            <div class="flex justify-end mb-4">
                <a href="{{ route('dcmt-reports.cb-export', ['type' => 'xls']) }}"
                   class="px-6 py-2 text-sm font-semibold text-white bg-gray-800 rounded-md shadow hover:bg-gray-900">
                    Export XLS
                </a>
            </div>

            {{-- Data Table --}}
            <div class="overflow-hidden bg-white rounded-lg shadow">
                <div class="overflow-x-auto max-h-[500px]">
                    <table class="min-w-full border-separate table-auto border-spacing-0">
                        <thead class="sticky top-0 z-10 bg-gray-50">
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
                            @foreach ($reports as $index => $item)
                                <tr class="transition-all duration-150 hover:bg-gray-100">
                                    <td class="px-6 py-4 text-sm text-gray-900">{{ $reports->firstItem() + $index }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $item->issuer_short_name ?? '-' }}</td>
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
                            @endforeach
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
