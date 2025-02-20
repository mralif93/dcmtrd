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
                <form action="{{ route('bonds.update', $bond) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section: Security Information -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Security Information</h3>

                        <!-- Row 1: Bond Name, Sub Name -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="bond_name" class="block text-sm font-medium text-gray-700">Bond Name *</label>
                                <input type="text" name="bond_name" id="bond_name"
                                    value="{{ old('bond_name', $bond->bond_name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sub_name" class="block text-sm font-medium text-gray-700">Sub Name</label>
                                <input type="text" name="sub_name" id="sub_name"
                                    value="{{ old('sub_name', $bond->sub_name) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: ISIN Code, Stock Code -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code *</label>
                                <input type="text" name="isin_code" id="isin_code"
                                    value="{{ old('isin_code', $bond->isin_code) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code</label>
                                <input type="text" name="stock_code" id="stock_code"
                                    value="{{ old('stock_code', $bond->stock_code) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Issuer, Category -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                <select name="category" id="category" required
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

                        <!-- Row 4: Sub Category -->
                        <div>
                            <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub Category</label>
                            <input type="text" name="sub_category" id="sub_category"
                                value="{{ old('sub_category', $bond->sub_category) }}"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Tenure & Dates -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Tenure & Dates</h3>

                        <!-- Row 1: Issue Date, Maturity Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date *</label>
                                <input type="date" name="issue_date" id="issue_date"
                                    value="{{ old('issue_date', $bond->issue_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date *</label>
                                <input type="date" name="maturity_date" id="maturity_date"
                                    value="{{ old('maturity_date', $bond->maturity_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Issue Tenure, Residual Tenure -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="issue_tenure" class="block text-sm font-medium text-gray-700">Issue Tenure (Years) *</label>
                                <input type="number" step="0.01" name="issue_tenure" id="issue_tenure"
                                    value="{{ old('issue_tenure', $bond->issue_tenure) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="residual_tenure" class="block text-sm font-medium text-gray-700">Residual Tenure (Years) *</label>
                                <input type="number" step="0.01" name="residual_tenure" id="residual_tenure"
                                    value="{{ old('residual_tenure', $bond->residual_tenure) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Coupon Details -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Coupon Details</h3>

                        <!-- Row 1: Coupon Rate, Coupon Type -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate (%) *</label>
                                <input type="number" step="0.01" name="coupon_rate" id="coupon_rate"
                                    value="{{ old('coupon_rate', $bond->coupon_rate) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="coupon_type" class="block text-sm font-medium text-gray-700">Coupon Type *</label>
                                <select name="coupon_type" id="coupon_type" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Coupon Type</option>
                                    @foreach(['Fixed', 'Floating', 'Zero Coupon'] as $type)
                                        <option value="{{ $type }}" @selected(old('coupon_type', $bond->coupon_type) == $type)>
                                            {{ $type }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Row 2: Frequency, Day Count Convention -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="coupon_frequency" class="block text-sm font-medium text-gray-700">Frequency *</label>
                                <select name="coupon_frequency" id="coupon_frequency" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Frequency</option>
                                    @foreach(['Annual', 'Semi-Annual', 'Quarterly', 'Monthly'] as $frequency)
                                        <option value="{{ $frequency }}" @selected(old('coupon_frequency', $bond->coupon_frequency) == $frequency)>
                                            {{ $frequency }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label for="day_count_convention" class="block text-sm font-medium text-gray-700">Day Count Convention *</label>
                                <select name="day_count_convention" id="day_count_convention" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="">Select Day Count</option>
                                    @foreach(['30/360', 'Actual/360', 'Actual/365', 'Actual/Actual'] as $dayCount)
                                        <option value="{{ $dayCount }}" @selected(old('day_count_convention', $bond->day_count_convention) == $dayCount)>
                                            {{ $dayCount }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Section: Coupon Payment Dates -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Coupon Payment Dates</h3>

                        <!-- Row 1: Previous, First, Next, Last Coupon Payment Dates -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="prev_coupon_payment_date" class="block text-sm font-medium text-gray-700">Previous Coupon Payment Date</label>
                                <input type="date" name="prev_coupon_payment_date" id="prev_coupon_payment_date"
                                    value="{{ old('prev_coupon_payment_date', $bond->prev_coupon_payment_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="first_coupon_payment_date" class="block text-sm font-medium text-gray-700">First Coupon Payment Date *</label>
                                <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date"
                                    value="{{ old('first_coupon_payment_date', $bond->first_coupon_payment_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="next_coupon_payment_date" class="block text-sm font-medium text-gray-700">Next Coupon Payment Date *</label>
                                <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date"
                                    value="{{ old('next_coupon_payment_date', $bond->next_coupon_payment_date) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last Coupon Payment Date</label>
                                <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date"
                                    value="{{ old('last_coupon_payment_date', $bond->last_coupon_payment_date) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Financial Information -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Information</h3>

                        <!-- Row 1: Principal Amount, Amount Issued, Amount Outstanding -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="principal_amount" class="block text-sm font-medium text-gray-700">Principal Amount *</label>
                                <input type="number" step="0.01" name="principal_amount" id="principal_amount"
                                    value="{{ old('principal_amount', $bond->principal_amount) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount Issued *</label>
                                <input type="number" step="0.01" name="amount_issued" id="amount_issued"
                                    value="{{ old('amount_issued', $bond->amount_issued) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount Outstanding *</label>
                                <input type="number" step="0.01" name="amount_outstanding" id="amount_outstanding"
                                    value="{{ old('amount_outstanding', $bond->amount_outstanding) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Information -->
                    <div class="space-y-6 pb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>

                        <!-- Row 1: Lead Arranger, Facility Agent, Facility Code -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger *</label>
                                <input type="text" name="lead_arranger" id="lead_arranger"
                                    value="{{ old('lead_arranger', $bond->lead_arranger) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent *</label>
                                <input type="text" name="facility_agent" id="facility_agent"
                                    value="{{ old('facility_agent', $bond->facility_agent) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                <input type="text" name="facility_code" id="facility_code"
                                    value="{{ old('facility_code', $bond->facility_code) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Approval Date/Time -->
                        <div>
                            <label for="approval_date_time" class="block text-sm font-medium text-gray-700">Approval Date/Time *</label>
                            <input type="datetime-local" name="approval_date_time" id="approval_date_time"
                                value="{{ old('approval_date_time', $bond->approval_date_time) }}" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('bonds.index') }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>