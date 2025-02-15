<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Bond Information') }}
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('bond-info.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-6">
                        <!-- Core Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4 pb-6">
                                <div>
                                    <label for="bond_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                    <select name="bond_id" id="bond_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a Bond</option>
                                        @foreach($bonds as $bond)
                                            <option value="{{ $bond->id }}" @selected(old('bond_id') == $bond->id)>
                                                {{ $bond->bond_sukuk_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code *</label>
                                    <input type="text" name="isin_code" id="isin_code" 
                                        value="{{ old('isin_code') }}" required maxlength="12"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code *</label>
                                    <input type="text" name="stock_code" id="stock_code" 
                                        value="{{ old('stock_code') }}" required maxlength="10"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="islamic_concept" class="block text-sm font-medium text-gray-700">Islamic Concept *</label>
                                    <select name="islamic_concept" id="islamic_concept" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="Yes" @selected(old('islamic_concept') == 'Yes')>Yes</option>
                                        <option value="No" @selected(old('islamic_concept') == 'No')>No</option>
                                    </select>
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <input type="text" name="category" id="category" 
                                        value="{{ old('category') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub Category</label>
                                    <input type="text" name="sub_category" id="sub_category" 
                                        value="{{ old('sub_category') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Dates & Tenure -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Dates & Tenure</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Issue Date *</label>
                                    <input type="date" name="issue_date" id="issue_date" 
                                        value="{{ old('issue_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="maturity_date" class="block text-sm font-medium text-gray-700">Maturity Date *</label>
                                    <input type="date" name="maturity_date" id="maturity_date" 
                                        value="{{ old('maturity_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="issue_tenure_years" class="block text-sm font-medium text-gray-700">Issue Tenure (Years) *</label>
                                    <input type="number" step="0.1" name="issue_tenure_years" id="issue_tenure_years" 
                                        value="{{ old('issue_tenure_years') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="residual_tenure_years" class="block text-sm font-medium text-gray-700">Residual Tenure (Years) *</label>
                                    <input type="number" step="0.1" name="residual_tenure_years" id="residual_tenure_years" 
                                        value="{{ old('residual_tenure_years') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Coupon Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Coupon Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate (%) *</label>
                                    <input type="number" step="0.0001" name="coupon_rate" id="coupon_rate" 
                                        value="{{ old('coupon_rate') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="coupon_type" class="block text-sm font-medium text-gray-700">Coupon Type *</label>
                                    <input type="text" name="coupon_type" id="coupon_type" 
                                        value="{{ old('coupon_type') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="coupon_frequency" class="block text-sm font-medium text-gray-700">Coupon Frequency *</label>
                                    <input type="text" name="coupon_frequency" id="coupon_frequency" 
                                        value="{{ old('coupon_frequency') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="day_count" class="block text-sm font-medium text-gray-700">Day Count *</label>
                                    <input type="text" name="day_count" id="day_count" 
                                        value="{{ old('day_count') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Payment Dates -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Payment Dates</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="prev_coupon_payment_date" class="block text-sm font-medium text-gray-700">Previous Coupon Date</label>
                                    <input type="date" name="prev_coupon_payment_date" id="prev_coupon_payment_date" 
                                        value="{{ old('prev_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="first_coupon_payment_date" class="block text-sm font-medium text-gray-700">First Coupon Date</label>
                                    <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date" 
                                        value="{{ old('first_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="next_coupon_payment_date" class="block text-sm font-medium text-gray-700">Next Coupon Date</label>
                                    <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date" 
                                        value="{{ old('next_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last Coupon Date</label>
                                    <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date" 
                                        value="{{ old('last_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="coupon_accrual" class="block text-sm font-medium text-gray-700">Coupon Accrual Date</label>
                                    <input type="date" name="coupon_accrual" id="coupon_accrual" 
                                        value="{{ old('coupon_accrual') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Trading Information -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Trading Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                                <div>
                                    <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Last Traded Yield (%)</label>
                                    <input type="number" step="0.0001" name="last_traded_yield" id="last_traded_yield" 
                                        value="{{ old('last_traded_yield') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_price" class="block text-sm font-medium text-gray-700">Last Traded Price</label>
                                    <input type="number" step="0.01" name="last_traded_price" id="last_traded_price" 
                                        value="{{ old('last_traded_price') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_amount" class="block text-sm font-medium text-gray-700">Last Traded Amount</label>
                                    <input type="number" step="0.01" name="last_traded_amount" id="last_traded_amount" 
                                        value="{{ old('last_traded_amount') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_date" class="block text-sm font-medium text-gray-700">Last Traded Date</label>
                                    <input type="date" name="last_traded_date" id="last_traded_date" 
                                        value="{{ old('last_traded_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Issuance Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Issuance Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount Issued</label>
                                    <input type="number" step="0.01" name="amount_issued" id="amount_issued" 
                                        value="{{ old('amount_issued') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount Outstanding</label>
                                    <input type="number" step="0.01" name="amount_outstanding" id="amount_outstanding" 
                                        value="{{ old('amount_outstanding') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Info -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="lead_arranger" class="block text-sm font-medium text-gray-700">Lead Arranger</label>
                                    <input type="text" name="lead_arranger" id="lead_arranger" 
                                        value="{{ old('lead_arranger') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="facility_agent" class="block text-sm font-medium text-gray-700">Facility Agent</label>
                                    <input type="text" name="facility_agent" id="facility_agent" 
                                        value="{{ old('facility_agent') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code</label>
                                    <input type="text" name="facility_code" id="facility_code" 
                                        value="{{ old('facility_code') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('bond-info.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus ```html
                        -gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Bond Information
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>