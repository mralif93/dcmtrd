<!-- resources/views/trustee_fees/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trustee Fee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('trustee-fees.update', $trusteeFee->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="month" class="block font-medium text-sm text-gray-700">Month</label>
                                <select id="month" name="month" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="">-- Select Month --</option>
                                    <option value="Jan" {{ $trusteeFee->month == 'Jan' ? 'selected' : '' }}>January</option>
                                    <option value="Feb" {{ $trusteeFee->month == 'Feb' ? 'selected' : '' }}>February</option>
                                    <option value="Mar" {{ $trusteeFee->month == 'Mar' ? 'selected' : '' }}>March</option>
                                    <option value="Apr" {{ $trusteeFee->month == 'Apr' ? 'selected' : '' }}>April</option>
                                    <option value="May" {{ $trusteeFee->month == 'May' ? 'selected' : '' }}>May</option>
                                    <option value="Jun" {{ $trusteeFee->month == 'Jun' ? 'selected' : '' }}>June</option>
                                    <option value="Jul" {{ $trusteeFee->month == 'Jul' ? 'selected' : '' }}>July</option>
                                    <option value="Aug" {{ $trusteeFee->month == 'Aug' ? 'selected' : '' }}>August</option>
                                    <option value="Sep" {{ $trusteeFee->month == 'Sep' ? 'selected' : '' }}>September</option>
                                    <option value="Oct" {{ $trusteeFee->month == 'Oct' ? 'selected' : '' }}>October</option>
                                    <option value="Nov" {{ $trusteeFee->month == 'Nov' ? 'selected' : '' }}>November</option>
                                    <option value="Dec" {{ $trusteeFee->month == 'Dec' ? 'selected' : '' }}>December</option>
                                </select>
                                @error('month')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date" class="block font-medium text-sm text-gray-700">Date</label>
                                <input id="date" type="number" name="date" min="1" max="31" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('date', $trusteeFee->date) }}">
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="issuer" class="block font-medium text-sm text-gray-700">Issuer</label>
                                <input id="issuer" type="text" name="issuer" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('issuer', $trusteeFee->issuer) }}" required>
                                @error('issuer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="invoice_no" class="block font-medium text-sm text-gray-700">Invoice Number</label>
                                <input id="invoice_no" type="text" name="invoice_no" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('invoice_no', $trusteeFee->invoice_no) }}" required>
                                @error('invoice_no')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="fees_rm" class="block font-medium text-sm text-gray-700">Fees (RM)</label>
                                <input id="fees_rm" type="number" step="0.01" name="fees_rm" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('fees_rm', $trusteeFee->fees_rm) }}" required>
                                @error('fees_rm')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="start_anniversary_date" class="block font-medium text-sm text-gray-700">Start Anniversary Date</label>
                                <input id="start_anniversary_date" type="date" name="start_anniversary_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('start_anniversary_date', $trusteeFee->start_anniversary_date ? $trusteeFee->start_anniversary_date->format('Y-m-d') : '') }}" required>
                                @error('start_anniversary_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="end_anniversary_date" class="block font-medium text-sm text-gray-700">End Anniversary Date</label>
                                <input id="end_anniversary_date" type="date" name="end_anniversary_date" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('end_anniversary_date', $trusteeFee->end_anniversary_date ? $trusteeFee->end_anniversary_date->format('Y-m-d') : '') }}" required>
                                @error('end_anniversary_date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-6">
                            <label for="description" class="block font-medium text-sm text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>{{ old('description', $trusteeFee->description) }}</textarea>
                            @error('description')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label for="memo_to_fad" class="block font-medium text-sm text-gray-700">Memo To FAD Date</label>
                                <input id="memo_to_fad" type="date" name="memo_to_fad" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('memo_to_fad', $trusteeFee->memo_to_fad ? $trusteeFee->memo_to_fad->format('Y-m-d\TH:i') : '') }}">
                                @error('memo_to_fad')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="date_letter_to_issuer" class="block font-medium text-sm text-gray-700">Date Letter to Issuer</label>
                                <input id="date_letter_to_issuer" type="date" name="date_letter_to_issuer" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('date_letter_to_issuer', $trusteeFee->date_letter_to_issuer ? $trusteeFee->date_letter_to_issuer->format('Y-m-d\TH:i') : '') }}">
                                @error('date_letter_to_issuer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="first_reminder" class="block font-medium text-sm text-gray-700">First Reminder Date</label>
                                <input id="first_reminder" type="date" name="first_reminder" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('first_reminder', $trusteeFee->first_reminder ? $trusteeFee->first_reminder->format('Y-m-d\TH:i') : '') }}">
                                @error('first_reminder')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="second_reminder" class="block font-medium text-sm text-gray-700">Second Reminder Date</label>
                                <input id="second_reminder" type="date" name="second_reminder" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('second_reminder', $trusteeFee->second_reminder ? $trusteeFee->second_reminder->format('Y-m-d\TH:i') : '') }}">
                                @error('second_reminder')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="third_reminder" class="block font-medium text-sm text-gray-700">Third Reminder Date</label>
                                <input id="third_reminder" type="date" name="third_reminder" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('third_reminder', $trusteeFee->third_reminder ? $trusteeFee->third_reminder->format('Y-m-d\TH:i') : '') }}">
                                @error('third_reminder')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="payment_received" class="block font-medium text-sm text-gray-700">Payment Received Date</label>
                                <input id="payment_received" type="date" name="payment_received" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('payment_received', $trusteeFee->payment_received ? $trusteeFee->payment_received->format('Y-m-d\TH:i') : '') }}">
                                @error('payment_received')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="tt_cheque_no" class="block font-medium text-sm text-gray-700">TT/Cheque Number</label>
                                <input id="tt_cheque_no" type="text" name="tt_cheque_no" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('tt_cheque_no', $trusteeFee->tt_cheque_no) }}">
                                @error('tt_cheque_no')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="memo_receipt_to_fad" class="block font-medium text-sm text-gray-700">Memo Receipt to FAD Date</label>
                                <input id="memo_receipt_to_fad" type="date" name="memo_receipt_to_fad" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('memo_receipt_to_fad', $trusteeFee->memo_receipt_to_fad ? $trusteeFee->memo_receipt_to_fad->format('Y-m-d\TH:i') : '') }}">
                                @error('memo_receipt_to_fad')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="receipt_to_issuer" class="block font-medium text-sm text-gray-700">Receipt to Issuer Date</label>
                                <input id="receipt_to_issuer" type="date" name="receipt_to_issuer" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('receipt_to_issuer', $trusteeFee->receipt_to_issuer ? $trusteeFee->receipt_to_issuer->format('Y-m-d\TH:i') : '') }}">
                                @error('receipt_to_issuer')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="receipt_no" class="block font-medium text-sm text-gray-700">Receipt Number</label>
                                <input id="receipt_no" type="text" name="receipt_no" class="block mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" value="{{ old('receipt_no', $trusteeFee->receipt_no) }}">
                                @error('receipt_no')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
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
                                Update Trustee Fee
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>