<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bond') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
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

            <!-- Error Handling -->
            @if($errors->any())
                <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-400">
                    <div class="flex items-center">
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
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Edit Bond</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Update bond information using the form below.
                    </p>
                </div>
                
                <form action="{{ route('bond-m.update', $bond) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section: Security Information -->
                    <div class="space-y-6 pb-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Security Information</h3>

                        <!-- Row 1: Issuer -->
                        <div>
                            <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                            <select name="issuer_id" id="issuer_id" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Select an Issuer</option>
                                @foreach($issuers as $issuer)
                                    <option value="{{ $issuer->id }}" @selected(old('issuer_id', $bond->issuer_id) == $issuer->id)>
                                        {{ $issuer->issuer_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Row 2: Bond/Sukuk Name, Sub Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bond_sukuk_name" class="block text-sm font-medium text-gray-700">Bond/Sukuk Name *</label>
                                <input type="text" name="bond_sukuk_name" id="bond_sukuk_name"
                                    value="{{ old('bond_sukuk_name', $bond->bond_sukuk_name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sub_name" class="block text-sm font-medium text-gray-700">Sub Name</label>
                                <input type="text" name="sub_name" id="sub_name"
                                    value="{{ old('sub_name', $bond->sub_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Principal, ISIN Code -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="principal" class="block text-sm font-medium text-gray-700">Principal</label>
                                <input type="text" name="principal" id="principal" 
                                    value="{{ old('principal', $bond->principal) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code</label>
                                <input type="text" name="isin_code" id="isin_code"
                                    value="{{ old('isin_code', $bond->isin_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 4: Islamic Concept, Stock Code -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic Concept</label>
                                <input type="text" name="islamic_concept" id="islamic_concept" 
                                    value="{{ old('islamic_concept', $bond->islamic_concept) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code</label>
                                <input type="text" name="stock_code" id="stock_code"
                                    value="{{ old('stock_code', $bond->stock_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 5: Instrument Code, Category -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="instrument_code" class="block text-sm font-medium text-gray-700">Instrument Code</label>
                                <input type="text" name="instrument_code" id="instrument_code" 
                                    value="{{ old('instrument_code', $bond->instrument_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <select name="category" id="category"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Category</option>
                                    @foreach(['Government', 'Corporate', 'Sukuk', 'Green Bonds', 'Islamic'] as $cat)
                                        <option value="{{ $cat }}" @selected(old('category', $bond->category) == $cat)>
                                            {{ $cat }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 6: Issue Date, Maturity Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date</label>
                                <input type="date" name="issue_date" id="issue_date"
                                    value="{{ old('issue_date', optional($bond->issue_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date</label>
                                <input type="date" name="maturity_date" id="maturity_date"
                                    value="{{ old('maturity_date', optional($bond->maturity_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 7: Coupon Rate, Coupon Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate (%)</label>
                                <input type="number" step="0.0001" name="coupon_rate" id="coupon_rate"
                                    value="{{ old('coupon_rate', $bond->coupon_rate) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 4 decimal places</p>
                            </div>
                            <div>
                                <label for="coupon_type" class="block text-sm font-medium text-gray-700">Coupon Type</label>
                                <select name="coupon_type" id="coupon_type"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Coupon Type</option>
                                    <option value="Fixed" @selected(old('coupon_type', $bond->coupon_type) == 'Fixed')>Fixed</option>
                                    <option value="Floating" @selected(old('coupon_type', $bond->coupon_type) == 'Floating')>Floating</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 8: Coupon Frequency, Day Count -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="coupon_frequency" class="block text-sm font-medium text-gray-700">Coupon Frequency</label>
                                <select name="coupon_frequency" id="coupon_frequency"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Frequency</option>
                                    <option value="Monthly" @selected(old('coupon_frequency', $bond->coupon_frequency) == 'Monthly')>Monthly</option>
                                    <option value="Quarterly" @selected(old('coupon_frequency', $bond->coupon_frequency) == 'Quarterly')>Quarterly</option>
                                    <option value="Semi-Annually" @selected(old('coupon_frequency', $bond->coupon_frequency) == 'Semi-Annually')>Semi-Annually</option>
                                    <option value="Annually" @selected(old('coupon_frequency', $bond->coupon_frequency) == 'Annually')>Annually</option>
                                </select>
                            </div>
                            <div>
                                <label for="day_count" class="block text-sm font-medium text-gray-700">Day Count Convention</label>
                                <select name="day_count" id="day_count"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Day Count</option>
                                    <option value="30/360" @selected(old('day_count', $bond->day_count) == '30/360')>30/360</option>
                                    <option value="Actual/360" @selected(old('day_count', $bond->day_count) == 'Actual/360')>Actual/360</option>
                                    <option value="Actual/365" @selected(old('day_count', $bond->day_count) == 'Actual/365')>Actual/365</option>
                                </select>
                            </div>
                        </div>

                        <!-- Row 9: Issue Tenure, Residual Tenure -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="issue_tenure_years" class="block text-sm font-medium text-gray-700">Issue Tenure (Years)</label>
                                <input type="number" step="0.0001" name="issue_tenure_years" id="issue_tenure_years"
                                    value="{{ old('issue_tenure_years', $bond->issue_tenure_years) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 4 decimal places</p>
                            </div>
                            <div>
                                <label for="residual_tenure_years" class="block text-sm font-medium text-gray-700">Residual Tenure (Years)</label>
                                <input type="number" step="0.0001" name="residual_tenure_years" id="residual_tenure_years"
                                    value="{{ old('residual_tenure_years', $bond->residual_tenure_years) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 4 decimal places</p>
                            </div>
                        </div>

                        <!-- Row 10: Sub Category -->
                        <div>
                            <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub Category</label>
                            <input type="text" name="sub_category" id="sub_category"
                                value="{{ old('sub_category', $bond->sub_category) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Coupon Payment Details -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Coupon Payment Details</h3>

                        <!-- Row 1: Coupon Accrual, Prev Coupon Payment Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="coupon_accrual" class="block text-sm font-medium text-gray-700">Coupon Accrual</label>
                                <input type="date" name="coupon_accrual" id="coupon_accrual"
                                    value="{{ old('coupon_accrual', optional($bond->coupon_accrual)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="prev_coupon_payment_date" class="block text-sm font-medium text-gray-700">Prev Coupon Payment Date</label>
                                <input type="date" name="prev_coupon_payment_date" id="prev_coupon_payment_date"
                                    value="{{ old('prev_coupon_payment_date', optional($bond->prev_coupon_payment_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: First Coupon Payment Date, Next Coupon Payment Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="first_coupon_payment_date" class="block text-sm font-medium text-gray-700">First Coupon Payment Date</label>
                                <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date"
                                    value="{{ old('first_coupon_payment_date', optional($bond->first_coupon_payment_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="next_coupon_payment_date" class="block text-sm font-medium text-gray-700">Next Coupon Payment Date</label>
                                <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date"
                                    value="{{ old('next_coupon_payment_date', optional($bond->next_coupon_payment_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Last Coupon Payment Date -->
                        <div>
                            <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last Coupon Payment Date</label>
                            <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date"
                                value="{{ old('last_coupon_payment_date', optional($bond->last_coupon_payment_date)->format('Y-m-d')) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Latest Trading -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Latest Trading</h3>

                        <!-- Row 1: Last Traded Yield (%), Last Traded Price (RM) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Last Traded Yield (%)</label>
                                <input type="number" step="0.01" name="last_traded_yield" id="last_traded_yield"
                                    value="{{ old('last_traded_yield', $bond->last_traded_yield) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 2 decimal places</p>
                            </div>
                            <div>
                                <label for="last_traded_price" class="block text-sm font-medium text-gray-700">Last Traded Price (RM)</label>
                                <input type="number" step="0.01" name="last_traded_price" id="last_traded_price"
                                    value="{{ old('last_traded_price', $bond->last_traded_price) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 2 decimal places</p>
                            </div>
                        </div>

                        <!-- Row 2: Last Traded Amount (RM'mil), Last Traded Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="last_traded_amount" class="block text-sm font-medium text-gray-700">Last Traded Amount (RM'mil)</label>
                                <input type="number" step="0.01" name="last_traded_amount" id="last_traded_amount"
                                    value="{{ old('last_traded_amount', $bond->last_traded_amount) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 2 decimal places</p>
                            </div>
                            <div>
                                <label for="last_traded_date" class="block text-sm font-medium text-gray-700">Last Traded Date</label>
                                <input type="date" name="last_traded_date" id="last_traded_date"
                                    value="{{ old('last_traded_date', optional($bond->last_traded_date)->format('Y-m-d')) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Ratings -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Ratings</h3>

                        <!-- Row 1: Ratings -->
                        <div>
                            <label for="rating" class="block text-sm font-medium text-gray-700">Ratings</label>
                            <input type="text" name="rating" id="rating"
                                value="{{ old('rating', $bond->rating) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Issuance -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Issuance</h3>

                        <!-- Row 1: Amount Issued (RM'mil), Amount Outstanding (RM'mil) -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount Issued (RM'mil)</label>
                                <input type="number" step="0.01" name="amount_issued" id="amount_issued"
                                    value="{{ old('amount_issued', $bond->amount_issued) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 2 decimal places</p>
                            </div>
                            <div>
                                <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount Outstanding (RM'mil)</label>
                                <input type="number" step="0.01" name="amount_outstanding" id="amount_outstanding"
                                    value="{{ old('amount_outstanding', $bond->amount_outstanding) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <p class="mt-1 text-xs text-gray-500">Up to 2 decimal places</p>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Info -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">Additional Info</h3>

                        <!-- Row 1: Lead Arranger -->
                        <div>
                            <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger</label>
                            <input type="text" name="lead_arranger" id="lead_arranger"
                                value="{{ old('lead_arranger', $bond->lead_arranger) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Facility Agent, Facility Code -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent</label>
                                <input type="text" name="facility_agent" id="facility_agent"
                                    value="{{ old('facility_agent', $bond->facility_agent) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code</label>
                                <input type="text" name="facility_code" id="facility_code"
                                    value="{{ old('facility_code', $bond->facility_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: System Information -->
                    <div class="space-y-6 py-6 border-b border-gray-200">
                        <h3 class="text-lg font-medium text-gray-900">System Information</h3>

                        <!-- Row 1: Status, Approval Date/Time -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <div class="mt-1 text-sm text-gray-600">{{ $bond->status }}</div>
                                <!-- Hidden input to preserve the value -->
                                <input type="hidden" name="status" value="{{ $bond->status }}">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Approval Date/Time</label>
                                <div class="mt-1 text-sm text-gray-600">{{ optional($bond->approval_datetime)->format('d/m/Y H:i A') }}</div>
                                <!-- Hidden input to preserve the value -->
                                <input type="hidden" name="approval_datetime" value="{{ optional($bond->approval_datetime)->format('Y-m-d\TH:i') }}">
                            </div>
                        </div>

                        <!-- Row 2: System Metadata -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Created At</label>
                                <div class="mt-1 text-sm text-gray-600">{{ $bond->created_at->format('d/m/Y H:i A') }}</div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <div class="mt-1 text-sm text-gray-600">{{ $bond->updated_at->format('d/m/Y H:i A') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Remarks Section (Optional) -->
                    <div class="space-y-6 py-6">
                        <h3 class="text-lg font-medium text-gray-900">Remarks</h3>
                        <div>
                            <label for="remarks" class="block text-sm font-medium text-gray-700">Additional Remarks</label>
                            <textarea name="remarks" id="remarks" rows="3"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('remarks', $bond->remarks) }}</textarea>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 pt-6 border-t border-gray-200">
                        <a href="{{ route('bond-m.details', $bond->issuer) }}"
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 9 9 0 01-18 0z"/>
                            </svg>
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Update Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>