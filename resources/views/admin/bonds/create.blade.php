<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Create New Bond') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Error Handling -->
            @if ($errors->any())
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex items-center">
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
                <form action="{{ route('bonds.store') }}" method="POST" class="p-6">
                    @csrf

                    <!-- Section: Security Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Security Information</h3>

                        <!-- Row 1: Issuer -->
                        <div>
                            <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                            <select name="issuer_id" id="issuer_id" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select an Issuer</option>
                                @foreach ($issuers as $issuer)
                                    <option value="{{ $issuer->id }}">{{ $issuer->issuer_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Row 2: Bond/Sukuk Name, Sub Name -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="bond_sukuk_name" class="block text-sm font-medium text-gray-700">Bond/Sukuk
                                    Name *</label>
                                <input type="text" name="bond_sukuk_name" id="bond_sukuk_name"
                                    value="{{ old('bond_sukuk_name') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sub_name" class="block text-sm font-medium text-gray-700">Sub Name</label>
                                <input type="text" name="sub_name" id="sub_name" value="{{ old('sub_name') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Principal, ISIN Code -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="principal" class="block text-sm font-medium text-gray-700">Principal
                                    *</label>
                                <input type="text" name="principal" id="principal"
                                    value="{{ old('principal_amount') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code
                                    *</label>
                                <input type="text" name="isin_code" id="isin_code" value="{{ old('isin_code') }}"
                                    required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 4: Islamic Concept, Stock Code -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic
                                    Concept *</label>
                                <input type="text" name="islamic_concept" id="islamic_concept"
                                    value="{{ old('islamic_concept') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code
                                    *</label>
                                <input type="text" name="stock_code" id="stock_code" value="{{ old('stock_code') }}"
                                    required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 5: Instrument Code, Category -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="instrument_code" class="block text-sm font-medium text-gray-700">Instrument
                                    Code *</label>
                                <input type="text" name="instrument_code" id="instrument_code"
                                    value="{{ old('instrument_code') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                <input type="text" name="category" id="category" value="{{ old('category') }}"
                                    required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 6: Issue Date, Maturity Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date
                                    *</label>
                                <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date') }}"
                                    required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date
                                    *</label>
                                <input type="date" name="maturity_date" id="maturity_date"
                                    value="{{ old('maturity_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 7: Coupon Rate, Coupon Type -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate
                                    (%) *</label>
                                <input type="number" step="0.01" name="coupon_rate" id="coupon_rate"
                                    value="{{ old('coupon_rate') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="coupon_type" class="block text-sm font-medium text-gray-700">Coupon Type
                                    *</label>
                                <select name="coupon_type" id="coupon_type" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Coupon Type</option>
                                    <option value="Fixed" @selected(old('coupon_type') == 'Fixed')>Fixed</option>
                                    <option value="Floating" @selected(old('coupon_type') == 'Floating')>Floating</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 8: Coupon Frequency, Day Count -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="coupon_frequency" class="block text-sm font-medium text-gray-700">Coupon
                                    Frequency *</label>
                                <select name="coupon_frequency" id="coupon_frequency" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Frequency</option>
                                    <option value="Monthly" @selected(old('coupon_frequency') == 'Monthly')>Monthly</option>
                                    <option value="Quarterly" @selected(old('coupon_frequency') == 'Quarterly')>Quarterly</option>
                                    <option value="Semi-Annually" @selected(old('coupon_frequency') == 'Semi-Annually')>Semi-Annually</option>
                                    <option value="Annually" @selected(old('coupon_frequency') == 'Annually')>Annually</option>
                                </select>
                            </div>
                            <div>
                                <label for="day_count" class="block text-sm font-medium text-gray-700">Day Count
                                    Convention *</label>
                                <select name="day_count" id="day_count" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Day Count</option>
                                    <option value="30/360" @selected(old('day_count') == '30/360')>30/360</option>
                                    <option value="Actual/360" @selected(old('day_count') == 'Actual/360')>Actual/360</option>
                                    <option value="Actual/365" @selected(old('day_count') == 'Actual/365')>Actual/365</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 9: Issue Tenure, Residual Tenure -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issue_tenure_years" class="block text-sm font-medium text-gray-700">Issue
                                    Tenure (Years) *</label>
                                <input type="number" step="0.0001" name="issue_tenure_years"
                                    id="issue_tenure_years" value="{{ old('issue_tenure_years') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="residual_tenure_years"
                                    class="block text-sm font-medium text-gray-700">Residual Tenure (Years) *</label>
                                <input type="number" step="0.0001" name="residual_tenure_years"
                                    id="residual_tenure_years" value="{{ old('residual_tenure_years') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 10: Sub Category -->
                        <div>
                            <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub
                                Category</label>
                            <input type="text" name="sub_category" id="sub_category"
                                value="{{ old('sub_category') }}"
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Coupon Payment Details -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Coupon Payment Details</h3>

                        <!-- Row 1: Coupon Accrual, Prev Coupon Payment Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="coupon_accrual" class="block text-sm font-medium text-gray-700">Coupon
                                    Accrual *</label>
                                <input type="date" name="coupon_accrual" id="coupon_accrual"
                                    value="{{ old('coupon_accrual') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="prev_coupon_payment_date"
                                    class="block text-sm font-medium text-gray-700">Prev Coupon Payment Date *</label>
                                <input type="date" name="prev_coupon_payment_date" id="prev_coupon_payment_date"
                                    value="{{ old('prev_coupon_payment_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: First Coupon Payment Date, Next Coupon Payment Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="first_coupon_payment_date"
                                    class="block text-sm font-medium text-gray-700">First Coupon Payment Date *</label>
                                <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date"
                                    value="{{ old('first_coupon_payment_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="next_coupon_payment_date"
                                    class="block text-sm font-medium text-gray-700">Next Coupon Payment Date *</label>
                                <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date"
                                    value="{{ old('next_coupon_payment_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Last Coupon Payment Date -->
                        <div>
                            <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last
                                Coupon Payment Date *</label>
                            <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date"
                                value="{{ old('last_coupon_payment_date') }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Latest Trading -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Latest Trading</h3>

                        <!-- Row 1: Last Traded Yield (%), Last Traded Price (RM) -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Last
                                    Traded Yield (%) *</label>
                                <input type="number" step="0.01" name="last_traded_yield" id="last_traded_yield"
                                    value="{{ old('last_traded_yield') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="last_traded_price" class="block text-sm font-medium text-gray-700">Last
                                    Traded Price (RM) *</label>
                                <input type="number" step="0.01" name="last_traded_price" id="last_traded_price"
                                    value="{{ old('last_traded_price') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Last Traded Amount (RM’mil), Last Traded Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="last_traded_amount" class="block text-sm font-medium text-gray-700">Last
                                    Traded Amount (RM’mil) *</label>
                                <input type="number" step="0.01" name="last_traded_amount"
                                    id="last_traded_amount" value="{{ old('last_traded_amount') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="last_traded_date" class="block text-sm font-medium text-gray-700">Last
                                    Traded Date *</label>
                                <input type="date" name="last_traded_date" id="last_traded_date"
                                    value="{{ old('last_traded_date') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Ratings -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Ratings</h3>

                        <!-- Row 1: Ratings -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Ratings *</label>
                            <input type="text" name="rating" id="rating" value="{{ old('rating') }}"
                                required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Issuance -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Issuance</h3>

                        <!-- Row 1: Amount Issued (RM’mil), Amount Outstanding (RM’mil) -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount
                                    Issued (RM’mil) *</label>
                                <input type="number" step="0.01" name="amount_issued" id="amount_issued"
                                    value="{{ old('amount_issued') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount
                                    Outstanding (RM’mil) *</label>
                                <input type="number" step="0.01" name="amount_outstanding"
                                    id="amount_outstanding" value="{{ old('amount_outstanding') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Info -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Info</h3>

                        <!-- Row 1: Lead Arranger -->
                        <div>
                            <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger
                                *</label>
                            <input type="text" name="lead_arranger" id="lead_arranger"
                                value="{{ old('lead_arranger') }}" required
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Facility Agent, Facility Code -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility
                                    Agent *</label>
                                <input type="text" name="facility_agent" id="facility_agent"
                                    value="{{ old('facility_agent') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility
                                    Code *</label>
                                <input type="text" name="facility_code" id="facility_code"
                                    value="{{ old('facility_code') }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: System Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">System Information</h3>

                        <!-- Row 1: Status, Approval Date/Time -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" id="status" required disabled
                                    class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed">
                                    <option value="Pending" selected>Pending</option>
                                </select>
                                <!-- Hidden input to still send 'Pending' value to the server -->
                                <input type="hidden" name="status" value="Pending">
                            </div>
                            <div>
                                <label for="approval_date_time"
                                    class="block text-sm font-medium text-gray-700">Approval Date/Time *</label>
                                <input type="datetime-local" name="approval_date_time" id="approval_date_time"
                                    value="{{ old('approval_date_time') }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('bonds.index') }}"
                            class="inline-flex items-center px-4 py-2 font-medium text-gray-700 bg-gray-200 border border-transparent rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                            class="inline-flex items-center px-4 py-2 font-medium text-white bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
