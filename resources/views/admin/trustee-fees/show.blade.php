<!-- resources/views/trustee_fees/show.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('View Trustee Fee') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-medium text-gray-900">Trustee Fee Details</h3>
                        <div class="flex space-x-2">
                            <a href="{{ route('trustee_fees.edit', $trusteeFee->id) }}" class="inline-flex items-center px-4 py-2 bg-yellow-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-600 active:bg-yellow-700 focus:outline-none focus:border-yellow-700 focus:ring ring-yellow-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Edit
                            </a>
                            <form action="{{ route('trustee_fees.destroy', $trusteeFee->id) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this fee?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Basic Information</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">ID</p>
                                    <p class="mt-1">{{ $trusteeFee->id }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Month</p>
                                    <p class="mt-1">{{ $trusteeFee->month ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date</p>
                                    <p class="mt-1">{{ $trusteeFee->date ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Issuer</p>
                                    <p class="mt-1">{{ $trusteeFee->issuer }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Fees (RM)</p>
                                    <p class="mt-1">{{ number_format($trusteeFee->fees_rm, 2) }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Invoice Number</p>
                                    <p class="mt-1">{{ $trusteeFee->invoice_no }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Anniversary Date Range</p>
                                    <p class="mt-1">{{ $trusteeFee->start_anniversary_date->format('d/m/Y') }} - {{ $trusteeFee->end_anniversary_date->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Payment Status</p>
                                    <p class="mt-1">
                                        @if($trusteeFee->payment_received)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                Paid on {{ $trusteeFee->payment_received->format('d M Y') }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                                Pending
                                            </span>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Payment Details</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Payment Received</p>
                                    <p class="mt-1">{{ $trusteeFee->payment_received ? $trusteeFee->payment_received->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">TT/Cheque Number</p>
                                    <p class="mt-1">{{ $trusteeFee->tt_cheque_no ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Memo Receipt to FAD</p>
                                    <p class="mt-1">{{ $trusteeFee->memo_receipt_to_fad ? $trusteeFee->memo_receipt_to_fad->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Receipt to Issuer</p>
                                    <p class="mt-1">{{ $trusteeFee->receipt_to_issuer ? $trusteeFee->receipt_to_issuer->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Receipt Number</p>
                                    <p class="mt-1">{{ $trusteeFee->receipt_no ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Timestamps</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Created At</p>
                                    <p class="mt-1">{{ $trusteeFee->created_at->format('d M Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Last Updated</p>
                                    <p class="mt-1">{{ $trusteeFee->updated_at->format('d M Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Description</h4>
                            <p class="text-sm">{{ $trusteeFee->description }}</p>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Processing Dates</h4>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Memo To FAD</p>
                                    <p class="mt-1">{{ $trusteeFee->memo_to_fad ? $trusteeFee->memo_to_fad->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Date Letter to Issuer</p>
                                    <p class="mt-1">{{ $trusteeFee->date_letter_to_issuer ? $trusteeFee->date_letter_to_issuer->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="font-semibold text-md mb-2 text-gray-700">Reminders</h4>
                            <div class="grid grid-cols-1 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">First Reminder</p>
                                    <p class="mt-1">{{ $trusteeFee->first_reminder ? $trusteeFee->first_reminder->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Second Reminder</p>
                                    <p class="mt-1">{{ $trusteeFee->second_reminder ? $trusteeFee->second_reminder->format('d M Y H:i') : 'N/A' }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Third Reminder</p>
                                    <p class="mt-1">{{ $trusteeFee->third_reminder ? $trusteeFee->third_reminder->format('d M Y H:i') : 'N/A' }}</p>
                                </div>