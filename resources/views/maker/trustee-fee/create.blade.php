<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Trustee Fee') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with
                                your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('trustee-fee-m.store') }}" method="POST" class="p-6">
                    @csrf
                    <div class="pb-6 space-y-6">
                        <!-- Basic Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Basic Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <!-- Issuer Dropdown for filtering facilities -->
                                <div>
                                    <label for="issuer_filter" class="block text-sm font-medium text-gray-700">Issuer
                                        *</label>
                                    <select id="issuer_filter" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Issuer --</option>
                                        @foreach ($issuers as $issuer)
                                            <option value="{{ $issuer->id }}">
                                                {{ $issuer->issuer_short_name }} - {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Facility Information Dropdown -->
                                <div>
                                    <label for="facility_information_id"
                                        class="block text-sm font-medium text-gray-700">Facility Information *</label>
                                    <select name="facility_information_id" id="facility_information_id" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Facility --</option>
                                        @foreach ($facilities as $facility)
                                            <option value="{{ $facility->id }}" data-issuer="{{ $facility->issuer_id }}"
                                                @selected(old('facility_information_id') == $facility->id)>
                                                {{ $facility->facility_code }} - {{ $facility->facility_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="invoice_no" class="block text-sm font-medium text-gray-700">Invoice
                                        Number *</label>
                                    <input type="text" name="invoice_no" id="invoice_no"
                                        value="{{ old('invoice_no') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description
                                        *</label>
                                    <textarea name="description" id="description" rows="3" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description') }}</textarea>
                                </div>
                                <!-- Fee Amount 1 -->
                                <div>
                                    <label for="trustee_fee_amount_1" class="block text-sm font-medium text-gray-700">
                                        Fee Amount 1 (RM)
                                        <button type="button" data-tooltip-target="tooltip-fee-1"
                                            data-tooltip-placement="right"
                                            class="ml-1 text-gray-400 hover:text-gray-600">
                                            <svg class="inline w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M12 6v.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                            </svg>
                                        </button>
                                    </label>
                                    <input type="number" name="trustee_fee_amount_1" id="trustee_fee_amount_1"
                                        step="0.01" min="0" value="{{ old('trustee_fee_amount_1') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div id="tooltip-fee-1" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    <p>1. Bond/Sukuk Trustee Fee</p>
                                    <p>2. Escrow Agent Fee</p>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                                <!-- Fee Amount 2 -->
                                <div class="mt-4">
                                    <label for="trustee_fee_amount_2" class="block text-sm font-medium text-gray-700">
                                        Fee Amount 2 (RM)
                                        <button type="button" data-tooltip-target="tooltip-fee-2"
                                            data-tooltip-placement="right"
                                            class="ml-1 text-gray-400 hover:text-gray-600">
                                            <svg class="inline w-4 h-4" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M13 16h-1v-4h-1m1-4h.01M12 6v.01M12 20a8 8 0 100-16 8 8 0 000 16z" />
                                            </svg>
                                        </button>
                                    </label>
                                    <input type="number" name="trustee_fee_amount_2" id="trustee_fee_amount_2"
                                        step="0.01" min="0" value="{{ old('trustee_fee_amount_2') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div id="tooltip-fee-2" role="tooltip"
                                    class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-sm opacity-0 tooltip">
                                    <p>1. Security Trustee Fee</p>
                                    <p>2. Legal Documentation Fee</p>
                                    <p>3. Setup Fee</p>
                                    <p>4. Transaction Fee</p>
                                    <p>5. CDS Fee</p>
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>

                            </div>
                        </div>

                        <!-- Anniversary Period Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Anniversary Period</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="start_anniversary_date"
                                        class="block text-sm font-medium text-gray-700">Start Anniversary Date
                                        *</label>
                                    <input type="date" name="start_anniversary_date" id="start_anniversary_date"
                                        value="{{ old('start_anniversary_date') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="end_anniversary_date"
                                        class="block text-sm font-medium text-gray-700">End Anniversary Date *</label>
                                    <input type="date" name="end_anniversary_date" id="end_anniversary_date"
                                        value="{{ old('end_anniversary_date') }}" required
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="month"
                                        class="block text-sm font-medium text-gray-700">Month</label>
                                    <select name="month" id="month"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Month --</option>
                                        @foreach (['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] as $month)
                                            <option value="{{ $month }}" @selected(old('month') == $month)>
                                                {{ $month }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tracking Information Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Tracking Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="memo_to_fad" class="block text-sm font-medium text-gray-700">Memo to
                                        FAD Date</label>
                                    <input type="date" name="memo_to_fad" id="memo_to_fad"
                                        value="{{ old('memo_to_fad') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="date_letter_to_issuer"
                                        class="block text-sm font-medium text-gray-700">Date Letter to Issuer</label>
                                    <input type="date" name="date_letter_to_issuer" id="date_letter_to_issuer"
                                        value="{{ old('date_letter_to_issuer') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Reminder Dates Section -->
                        <div class="pb-6 border-b border-gray-200">
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Reminder Dates</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                                <div>
                                    <label for="first_reminder" class="block text-sm font-medium text-gray-700">First
                                        Reminder</label>
                                    <input type="date" name="first_reminder" id="first_reminder"
                                        value="{{ old('first_reminder') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="second_reminder"
                                        class="block text-sm font-medium text-gray-700">Second Reminder</label>
                                    <input type="date" name="second_reminder" id="second_reminder"
                                        value="{{ old('second_reminder') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="third_reminder" class="block text-sm font-medium text-gray-700">Third
                                        Reminder</label>
                                    <input type="date" name="third_reminder" id="third_reminder"
                                        value="{{ old('third_reminder') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                        <!-- Payment Information Section -->
                        <div>
                            <h3 class="mb-4 text-lg font-medium text-gray-900">Payment Information</h3>
                            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                                <div>
                                    <label for="payment_received"
                                        class="block text-sm font-medium text-gray-700">Payment Received Date</label>
                                    <input type="date" name="payment_received" id="payment_received"
                                        value="{{ old('payment_received') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="tt_cheque_no"
                                        class="block text-sm font-medium text-gray-700">TT/Cheque Number</label>
                                    <input type="text" name="tt_cheque_no" id="tt_cheque_no"
                                        value="{{ old('tt_cheque_no') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="memo_receipt_to_fad"
                                        class="block text-sm font-medium text-gray-700">Memo Receipt to FAD
                                        Date</label>
                                    <input type="date" name="memo_receipt_to_fad" id="memo_receipt_to_fad"
                                        value="{{ old('memo_receipt_to_fad') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="receipt_to_issuer"
                                        class="block text-sm font-medium text-gray-700">Receipt to Issuer Date</label>
                                    <input type="date" name="receipt_to_issuer" id="receipt_to_issuer"
                                        value="{{ old('receipt_to_issuer') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="receipt_no" class="block text-sm font-medium text-gray-700">Receipt
                                        Number</label>
                                    <input type="text" name="receipt_no" id="receipt_no"
                                        value="{{ old('receipt_no') }}"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <!-- New: Remark to Management -->
                                <div class="md:col-span-2">
                                    <label for="remark_to_management"
                                        class="block text-sm font-medium text-gray-700">Remark to Management</label>
                                    <textarea name="remark_to_management" id="remark_to_management" rows="3"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remark_to_management') }}</textarea>
                                </div>

                                <!-- New: Payment Status -->
                                <div>
                                    <label for="payment_status"
                                        class="block text-sm font-medium text-gray-700">Payment Status</label>
                                    <select name="payment_status" id="payment_status"
                                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">-- Select Status --</option>
                                        <option value="Paid"
                                            {{ old('payment_status') == 'Paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="Pending"
                                            {{ old('payment_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="Early Redemption"
                                            {{ old('payment_status') == 'Early Redemption' ? 'selected' : '' }}>Early
                                            Redemption</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('trustee-fee-m.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Trustee Fee
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const issuerFilter = document.getElementById('issuer_filter');
            const facilitySelect = document.getElementById('facility_information_id');
            const facilityOptions = Array.from(facilitySelect.options);

            // Filter facilities when issuer is selected
            issuerFilter.addEventListener('change', function() {
                const selectedIssuerId = this.value;

                // Reset facility dropdown
                facilitySelect.innerHTML = '<option value="">-- Select Facility --</option>';

                // Filter and add matching facilities
                facilityOptions.forEach(option => {
                    if (!selectedIssuerId || option.dataset.issuer === selectedIssuerId) {
                        facilitySelect.appendChild(option.cloneNode(true));
                    }
                });
            });
        });
    </script>
</x-app-layout>
