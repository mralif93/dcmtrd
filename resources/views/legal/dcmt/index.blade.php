<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ url()->previous() }}"
                class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                ← Back
            </a>
        </div>
    </x-slot>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
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

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <div class="flex items-center justify-between px-4 py-5 sm:px-6">
                    <h3 class="text-lg font-semibold text-gray-900">List of Security Documents Request</h3>
                </div>
                <!-- List of Securities Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    #</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Issuer</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Security Name</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Security Code</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Asset Name Type</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Withdrawal Date</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                    Return Date</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                    Actions/Status</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse ($securities as $security)
                                <tr>
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900 whitespace-nowrap">
                                        {{ $loop->iteration + ($securities->currentPage() - 1) * $securities->perPage() }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->issuer->issuer_short_name ?? '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_name }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->security_code }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        {{ $security->asset_name_type }}
                                    </td>
                                    @php
                                        $latest = $security->latestDocRequest;
                                    @endphp

                                    <!-- Withdrawal Date with Highlight -->
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                        @if ($latest?->withdrawal_date) bg-yellow-100 text-yellow-800 @else bg-gray-200 text-gray-500 @endif"
                                            data-tooltip="{{ $latest?->withdrawal_date ? \Carbon\Carbon::parse($latest->withdrawal_date)->format('Y-m-d') : 'N/A' }}">
                                            {{ $latest?->withdrawal_date ? \Carbon\Carbon::parse($latest->withdrawal_date)->format('Y-m-d') : 'N/A' }}
                                        </span>
                                    </td>

                                    <!-- Withdrawal Date with Highlight -->
                                    <td class="px-6 py-4 text-sm text-gray-900 whitespace-nowrap">
                                        <span
                                            class="inline-block px-3 py-1 text-xs font-medium rounded-full 
                                    @if ($latest?->return_date) bg-green-100 text-green-800 @else bg-gray-200 text-gray-500 @endif"
                                            data-tooltip="{{ $latest?->return_date ? \Carbon\Carbon::parse($latest->return_date)->format('Y-m-d') : 'N/A' }}">
                                            {{ $latest?->return_date ? \Carbon\Carbon::parse($latest->return_date)->format('Y-m-d') : 'N/A' }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                        @if ($security->hasPendingRequest())
                                            <!-- Check if the request is pending -->
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-gray-500 bg-gray-200 rounded cursor-not-allowed">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2l4-4m1-6h-6a2 2 0 00-2 2v1H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-3V5a2 2 0 00-2-2z" />
                                                </svg>
                                                Request Are Pending
                                            </span>
                                        @elseif ($security->hasWithdrawnRequest())
                                            <!-- Check if the request has been withdrawn -->
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-yellow-800 bg-yellow-200 rounded cursor-not-allowed"
                                                data-toggle="tooltip"
                                                title="Request has been withdrawn. Contact support for more details.">
                                                <svg class="w-4 h-4 mr-1 animate-spin" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M4 4v5h.582M20 20v-5h-.581M4.93 19.07a10 10 0 0014.14-14.14" />
                                                </svg>
                                                Withdrawal Are On Going
                                            </span>
                                        @elseif ($security->hasExistingRequest())
                                            <!-- Check if there's any existing request -->
                                            <span
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-500 bg-blue-200 rounded cursor-not-allowed">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2l4-4m1-6h-6a2 2 0 00-2 2v1H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-3V5a2 2 0 00-2-2z" />
                                                </svg>
                                                Request Was Done
                                            </span>
                                        @else
                                            <!-- If there is no pending, withdrawn, or existing request, allow making a new request -->
                                            <a href="{{ route('legal.request-documents', $security->id) }}"
                                                class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-700 bg-green-100 rounded hover:bg-green-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2l4-4m1-6h-6a2 2 0 00-2 2v1H7a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-3V5a2 2 0 00-2-2z" />
                                                </svg>
                                                Make Request
                                            </a>
                                        @endif
                                    </td>


                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-4 text-sm text-center text-gray-500">
                                        No securities found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>


                <!-- Pagination Links -->
                <div class="px-4 py-3 bg-white border-t border-gray-200 sm:px-6">
                    {{ $getListReq->links() }}
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
