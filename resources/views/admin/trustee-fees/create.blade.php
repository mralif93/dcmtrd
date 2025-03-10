<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Trustee Fee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc pl-5 space-y-1">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('trustee-fees.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="issuer" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <input type="text" name="issuer" id="issuer" 
                                        value="{{ old('issuer') }}" required 
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="invoice_no" class="block text-sm font-medium text-gray-700">Invoice Number *</label>
                                    <input type="text" name="invoice_no" id="invoice_no" 
                                        value="{{ old('invoice_no') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description *</label>
                                    <textarea name="description" id="description" rows="3" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                </div>
                                <div>
                                    <label for="fees_rm" class="block text-sm font-medium text-gray-700">Fee Amount (RM) *</label>
                                    <input type="number" name="fees_rm" id="fees_rm" step="0.01" min="0" 
                                        value="{{ old('fees_rm') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Anniversary Period Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Anniversary Period</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="start_anniversary_date" class="block text-sm font-medium text-gray-700">Start Anniversary Date *</label>
                                    <input type="date" name="start_anniversary_date" id="start_anniversary_date" 
                                        value="{{ old('start_anniversary_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="end_anniversary_date" class="block text-sm font-medium text-gray-700">End Anniversary Date *</label>
                                    <input type="date" name="end_anniversary_date" id="end_anniversary_date" 
                                        value="{{ old('end_anniversary_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="month" class="block text-sm font-medium text-gray-700">Month</label>
                                    <select name="month" id="month"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Month --</option>
                                        @foreach(['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                            <option value="{{ $month }}" @selected(old('month') == $month)>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="date" class="block text-sm font-medium text-gray-700">Date</label>
                                    <input type="number" name="date" id="date" min="1" max="31" 
                                        value="{{ old('date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Tracking Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Tracking Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="memo_to_fad" class="block text-sm font-medium text-gray-700">Memo to FAD Date</label>
                                    <input type="date" name="memo_to_fad" id="memo_to_fad" 
                                        value="{{ old('memo_to_fad') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="date_letter_to_issuer" class="block text-sm font-medium text-gray-700">Date Letter to Issuer</label>
                                    <input type="date" name="date_letter_to_issuer" id="date_letter_to_issuer" 
                                        value="{{ old('date_letter_to_issuer') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Reminder Dates Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Reminder Dates</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="first_reminder" class="block text-sm font-medium text-gray-700">First Reminder</label>
                                    <input type="date" name="first_reminder" id="first_reminder" 
                                        value="{{ old('first_reminder') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="second_reminder" class="block text-sm font-medium text-gray-700">Second Reminder</label>
                                    <input type="date" name="second_reminder" id="second_reminder" 
                                        value="{{ old('second_reminder') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="third_reminder" class="block text-sm font-medium text-gray-700">Third Reminder</label>
                                    <input type="date" name="third_reminder" id="third_reminder" 
                                        value="{{ old('third_reminder') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Information Section -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="payment_received" class="block text-sm font-medium text-gray-700">Payment Received Date</label>
                                    <input type="date" name="payment_received" id="payment_received" 
                                        value="{{ old('payment_received') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="tt_cheque_no" class="block text-sm font-medium text-gray-700">TT/Cheque Number</label>
                                    <input type="text" name="tt_cheque_no" id="tt_cheque_no" 
                                        value="{{ old('tt_cheque_no') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="memo_receipt_to_fad" class="block text-sm font-medium text-gray-700">Memo Receipt to FAD Date</label>
                                    <input type="date" name="memo_receipt_to_fad" id="memo_receipt_to_fad" 
                                        value="{{ old('memo_receipt_to_fad') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="receipt_to_issuer" class="block text-sm font-medium text-gray-700">Receipt to Issuer Date</label>
                                    <input type="date" name="receipt_to_issuer" id="receipt_to_issuer" 
                                        value="{{ old('receipt_to_issuer') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="receipt_no" class="block text-sm font-medium text-gray-700">Receipt Number</label>
                                    <input type="text" name="receipt_no" id="receipt_no" 
                                        value="{{ old('receipt_no') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('trustee-fees.index') }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Trustee Fee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>