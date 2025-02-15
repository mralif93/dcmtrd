<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bond Information') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-6">
                <p class="mt-2 text-lg text-gray-600">Updating details for: <span class="font-semibold text-indigo-600">{{ $bondInfo->isin_code }}</span></p>
            </div>

            @if ($errors->any())
                <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <h3 class="text-red-800 font-medium mb-2">Please fix these errors:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('bond-info.update', $bondInfo) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="bg-white shadow rounded-lg p-6">
                    <!-- Core Information Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Core Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Bond</label>
                                <select name="bond_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @foreach($bonds as $bond)
                                        <option value="{{ $bond->id }}" {{ $bond->id == old('bond_id', $bondInfo->bond_id) ? 'selected' : '' }}>
                                            {{ $bond->bond_sukuk_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">ISIN Code</label>
                                <input type="text" name="isin_code" value="{{ old('isin_code', $bondInfo->isin_code) }}" 
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" maxlength="12">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Stock Code</label>
                                <input type="text" name="stock_code" value="{{ old('stock_code', $bondInfo->stock_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" maxlength="10">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Instrument Code</label>
                                <input type="text" name="instrument_code" value="{{ old('instrument_code', $bondInfo->instrument_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" maxlength="20">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Category</label>
                                <input type="text" name="category" value="{{ old('category', $bondInfo->category) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Sub Category</label>
                                <input type="text" name="sub_category" value="{{ old('sub_category', $bondInfo->sub_category) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Dates & Tenure Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Dates & Tenure</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Issue Date</label>
                                <input type="date" name="issue_date" value="{{ old('issue_date', $bondInfo->issue_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Maturity Date</label>
                                <input type="date" name="maturity_date" value="{{ old('maturity_date', $bondInfo->maturity_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Issue Tenure (Years)</label>
                                <input type="number" step="0.1" name="issue_tenure_years" value="{{ old('issue_tenure_years', $bondInfo->issue_tenure_years) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Residual Tenure (Years)</label>
                                <input type="number" step="0.1" name="residual_tenure_years" value="{{ old('residual_tenure_years', $bondInfo->residual_tenure_years) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Details Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Coupon Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Coupon Rate (%)</label>
                                <input type="number" step="0.0001" name="coupon_rate" value="{{ old('coupon_rate', $bondInfo->coupon_rate) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Coupon Type</label>
                                <input type="text" name="coupon_type" value="{{ old('coupon_type', $bondInfo->coupon_type) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Coupon Frequency</label>
                                <input type="text" name="coupon_frequency" value="{{ old('coupon_frequency', $bondInfo->coupon_frequency) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Day Count</label>
                                <input type="text" name="day_count" value="{{ old('day_count', $bondInfo->day_count) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Payment Dates Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Payment Dates</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Coupon Accrual</label>
                                <input type="date" name="coupon_accrual" value="{{ old('coupon_accrual', $bondInfo->coupon_accrual) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Previous Coupon Date</label>
                                <input type="date" name="prev_coupon_payment_date" value="{{ old('prev_coupon_payment_date', $bondInfo->prev_coupon_payment_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">First Coupon Date</label>
                                <input type="date" name="first_coupon_payment_date" value="{{ old('first_coupon_payment_date', $bondInfo->first_coupon_payment_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Next Coupon Date</label>
                                <input type="date" name="next_coupon_payment_date" value="{{ old('next_coupon_payment_date', $bondInfo->next_coupon_payment_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Last Coupon Date</label>
                                <input type="date" name="last_coupon_payment_date" value="{{ old('last_coupon_payment_date', $bondInfo->last_coupon_payment_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Trading Information Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Trading Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Last Traded Yield</label>
                                <input type="number" step="0.0001" name="last_traded_yield" value="{{ old('last_traded_yield', $bondInfo->last_traded_yield) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Last Traded Price</label>
                                <input type="number" step="0.0001" name="last_traded_price" value="{{ old('last_traded_price', $bondInfo->last_traded_price) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Last Traded Amount</label>
                                <input type="number" step="0.01" name="last_traded_amount" value="{{ old('last_traded_amount', $bondInfo->last_traded_amount) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Last Traded Date</label>
                                <input type="date" name="last_traded_date" value="{{ old('last_traded_date', $bondInfo->last_traded_date?->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Issuance Details Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Issuance Details</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Amount Issued</label>
                                <input type="number" step="0.01" name="amount_issued" value="{{ old('amount_issued', $bondInfo->amount_issued) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Amount Outstanding</label>
                                <input type="number" step="0.01" name="amount_outstanding" value="{{ old('amount_outstanding', $bondInfo->amount_outstanding) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Additional Info Section -->
                    <div class="border-b border-gray-200 pb-6 mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Additional Info</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2 col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Lead Arranger</label>
                                <input type="text" name="lead_arranger" value="{{ old('lead_arranger', $bondInfo->lead_arranger) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2 col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Facility Agent</label>
                                <input type="text" name="facility_agent" value="{{ old('facility_agent', $bondInfo->facility_agent) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>

                            <div class="space-y-2 col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Facility Code</label>
                                <input type="text" name="facility_code" value="{{ old('facility_code', $bondInfo->facility_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('bond-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            Save Changes
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>