<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit Bond') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="p-4 mb-6 border-l-4 border-green-400 bg-green-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
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
                <div class="p-4 mb-6 border-l-4 border-red-400 bg-red-50">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800">There were {{ $errors->count() }} errors with your submission</h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="pl-5 space-y-1 list-disc">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow sm:rounded-lg">
                <form action="{{ route('bonds.update', $bond) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <!-- Section: Security Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Security Information</h3>

                        <!-- Row 1: Bond Name, Sub Name -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="bond_sukuk_name" class="block text-sm font-medium text-gray-700">Bond/Sukuk Name *</label>
                                <input type="text" name="bond_sukuk_name" id="bond_sukuk_name"
                                    value="{{ old('bond_sukuk_name', $bond->bond_sukuk_name) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="sub_name" class="block text-sm font-medium text-gray-700">Sub Name</label>
                                <input type="text" name="sub_name" id="sub_name"
                                    value="{{ old('sub_name', $bond->sub_name) }}" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: ISIN Code, Stock Code -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code *</label>
                                <input type="text" name="isin_code" id="isin_code"
                                    value="{{ old('isin_code', $bond->isin_code) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code</label>
                                <input type="text" name="stock_code" id="stock_code"
                                    value="{{ old('stock_code', $bond->stock_code) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 3: Issuer, Category -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                <select name="issuer_id" id="issuer_id" required
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
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
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                    </div>

                    <!-- Section: Tenure & Dates -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Tenure & Dates</h3>

                        <!-- Row 1: Issue Date, Maturity Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date *</label>
                                <input type="date" name="issue_date" id="issue_date"
                                    value="{{ old('issue_date', optional($bond->issue_date)->format('Y-m-d')) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date *</label>
                                <input type="date" name="maturity_date" id="maturity_date"
                                    value="{{ old('maturity_date', optional($bond->maturity_date)->format('Y-m-d')) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Issue Tenure (Years), Residual Tenure (Years) -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="issue_tenure_years" class="block text-sm font-medium text-gray-700">Issue Tenure (Years) *</label>
                                <input type="number" step="0.01" name="issue_tenure_years" id="issue_tenure_years"
                                    value="{{ old('issue_tenure_years', $bond->issue_tenure_years) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="residual_tenure_years" class="block text-sm font-medium text-gray-700">Residual Tenure (Years) *</label>
                                <input type="number" step="0.01" name="residual_tenure_years" id="residual_tenure_years"
                                    value="{{ old('residual_tenure_years', $bond->residual_tenure_years) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Coupon Payment Dates -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Coupon Payment Dates</h3>

                        <!-- Row 1: Previous Coupon Payment Date, First Coupon Payment Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="prev_coupon_payment_date" class="block text-sm font-medium text-gray-700">Previous Coupon Payment Date</label>
                                <input type="date" name="prev_coupon_payment_date" id="prev_coupon_payment_date"
                                    value="{{ old('prev_coupon_payment_date', optional($bond->prev_coupon_payment_date)->format('Y-m-d')) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="first_coupon_payment_date" class="block text-sm font-medium text-gray-700">First Coupon Payment Date *</label>
                                <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date"
                                    value="{{ old('first_coupon_payment_date', optional($bond->first_coupon_payment_date)->format('Y-m-d')) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <!-- Row 2: Next Coupon Payment Date, Last Coupon Payment Date -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="next_coupon_payment_date" class="block text-sm font-medium text-gray-700">Next Coupon Payment Date *</label>
                                <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date"
                                    value="{{ old('next_coupon_payment_date', optional($bond->next_coupon_payment_date)->format('Y-m-d')) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last Coupon Payment Date</label>
                                <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date"
                                    value="{{ old('last_coupon_payment_date', optional($bond->last_coupon_payment_date)->format('Y-m-d')) }}"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Financial Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Financial Information</h3>

                        <!-- Row 1: Amount Issued, Amount Outstanding -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount Issued (RM'mil) *</label>
                                <input type="number" step="0.01" name="amount_issued" id="amount_issued"
                                    value="{{ old('amount_issued', $bond->amount_issued) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount Outstanding (RM'mil) *</label>
                                <input type="number" step="0.01" name="amount_outstanding" id="amount_outstanding"
                                    value="{{ old('amount_outstanding', $bond->amount_outstanding) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: Additional Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-medium text-gray-900">Additional Information</h3>

                        <!-- Row 1: Lead Arranger, Facility Agent -->
                        <div>
                            <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger *</label>
                            <input type="text" name="lead_arranger" id="lead_arranger"
                                value="{{ old('lead_arranger', $bond->lead_arranger) }}" 
                                class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Row 2: Facility Code, Approval Date/Time -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent *</label>
                                <input type="text" name="facility_agent" id="facility_agent"
                                    value="{{ old('facility_agent', $bond->facility_agent) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <div>
                                <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                <input type="text" name="facility_code" id="facility_code"
                                    value="{{ old('facility_code', $bond->facility_code) }}" 
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Section: System Information -->
                    <div class="pb-6 space-y-6">
                        <h3 class="mb-4 text-lg font-bold text-gray-900">System Informations</h3>

                        <!-- Row 1: Status, Approval Date/Time -->
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" id="status" class="block w-full mt-1 bg-gray-100 border-gray-300 rounded-md shadow-sm cursor-not-allowed" disabled>
                                    <option value="Pending" selected>Pending</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="approval_date_time" class="block text-sm font-medium text-gray-700">Approval Date/Time *</label>
                                <input type="datetime-local" name="approval_date_time" id="approval_date_time"
                                    value="{{ old('approval_date_time', optional($bond->approval_date_time)->format('Y-m-d\TH:i')) }}" required
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
                            Update Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>