<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create New Bond') }}
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
                <form action="{{ route('bonds.store') }}" method="POST" class="p-6">
                    @csrf

                    <div class="space-y-6 pb-6">
                        <!-- Core Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="bond_sukuk_name" class="block text-sm font-medium text-gray-700">Bond Name *</label>
                                    <input type="text" name="bond_sukuk_name" id="bond_sukuk_name" 
                                        value="{{ old('bond_sukuk_name') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="sub_name" class="block text-sm font-medium text-gray-700">Sub Name</label>
                                    <input type="text" name="sub_name" id="sub_name" 
                                        value="{{ old('sub_name') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <select name="issuer_id" id="issuer_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select an Issuer</option>
                                        @foreach($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" @selected(old('issuer_id') == $issuer->id)>
                                                {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating *</label>
                                    <input type="text" name="rating" id="rating" required
                                        value="{{ old('rating') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" />
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <select name="category" id="category" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Category</option>
                                        @foreach(['Government','Corporate','Sukuk','Green Bonds','Islamic'] as $cat)
                                            <option value="{{ $cat }}" @selected(old('category') == $cat)>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="sub_category" class="block text-sm font-medium text-gray-700">Sub Category</label>
                                    <input type="text" name="sub_category" id="sub_category" 
                                        value="{{ old('sub_category') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="isin_code" class="block text-sm font-medium text-gray-700">ISIN Code *</label>
                                    <input type="text" name="isin_code " id="isin_code" 
                                        value="{{ old('isin_code') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="stock_code" class="block text-sm font-medium text-gray-700">Stock Code *</label>
                                    <input type="text" name="stock_code" id="stock_code" 
                                        value="{{ old('stock_code') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="instrument_code" class="block text-sm font-medium text-gray-700">Instrument Code *</label>
                                    <input type="text" name="instrument_code" id="instrument_code" 
                                        value="{{ old('instrument_code') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

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
                                    <label for="coupon_rate" class="block text-sm font-medium text-gray-700">Coupon Rate (%) *</label>
                                    <input type="number" step="0.01" name="coupon_rate" id="coupon_rate" 
                                        value="{{ old('coupon_rate') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="coupon_type" class="block text-sm font-medium text-gray-700">Coupon Type *</label>
                                    <select name="coupon_type" id="coupon_type" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Coupon Type</option>
                                        @foreach(['Fixed', 'Floating'] as $type)
                                            <option value="{{ $type }}" @selected(old('coupon_type') == $type)>
                                                {{ $type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="coupon_frequency" class="block text-sm font-medium text-gray-700">Coupon Frequency *</label>
                                    <select name="coupon_frequency" id="coupon_frequency" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Frequency</option>
                                        @foreach(['Monthly', 'Quarterly', 'Semi-Annually', 'Annually'] as $frequency)
                                            <option value="{{ $frequency }}" @selected(old('coupon_frequency') == $frequency)>
                                                {{ $frequency }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="day_count" class="block text-sm font-medium text-gray-700">Day Count Convention *</label>
                                    <select name="day_count" id="day_count" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Day Count</option>
                                        @foreach(['30/360', 'Actual/360', 'Actual/365'] as $dayCount)
                                            <option value="{{ $dayCount }}" @selected(old('day_count') == $dayCount)>
                                                {{ $dayCount }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Trading Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Trading Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for ="last_traded_date" class="block text-sm font-medium text-gray-700">Last Traded Date *</label>
                                    <input type="date" name="last_traded_date" id="last_traded_date" 
                                        value="{{ old('last_traded_date') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Yield (%) *</label>
                                    <input type="number" step="0.01" name="last_traded_yield" id="last_traded_yield" 
                                        value="{{ old('last_traded_yield') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_price" class="block text-sm font-medium text-gray-700">Price *</label>
                                    <input type="number" step="0.01" name="last_traded_price" id="last_traded_price" 
                                        value="{{ old('last_traded_price') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="last_traded_amount" class="block text-sm font-medium text-gray-700">Trade Amount *</label>
                                    <input type="number" step="0.01" name="last_traded_amount" id="last_traded_amount" 
                                        value="{{ old('last_traded_amount') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="o_s_amount" class="block text-sm font-medium text-gray-700">Outstanding Amount *</label>
                                    <input type="number" step="0.01" name="o_s_amount" id="o_s_amount" 
                                        value="{{ old('o_s_amount') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="principal" class="block text-sm font-medium text-gray-700">Principal Amount *</label>
                                    <input type="number" step="0.01" name="principal" id="principal" 
                                        value="{{ old('principal') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Additional Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="facility_code" class="block text-sm font-medium text-gray-700">Facility Code *</label>
                                    <input type="text" name="facility_code" id="facility_code" 
                                        value="{{ old('facility_code') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="approval_date_time" class="block text-sm font-medium text-gray-700">Approval Date/Time</label>
                                    <input type="datetime-local" name="approval_date_time" id="approval_date_time" 
                                        value="{{ old('approval_date_time') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="first_coupon_payment_date" class="block text-sm font-medium text-gray-700">First Coupon Payment Date</label>
                                    <input type="date" name="first_coupon_payment_date" id="first_coupon_payment_date" 
                                        value="{{ old('first_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo -500">
                                </div>

                                <div>
                                    <label for="next_coupon_payment_date" class="block text-sm font-medium text-gray-700">Next Coupon Payment Date</label>
                                    <input type="date" name="next_coupon_payment_date" id="next_coupon_payment_date" 
                                        value="{{ old('next_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="last_coupon_payment_date" class="block text-sm font-medium text-gray-700">Last Coupon Payment Date</label>
                                    <input type="date" name="last_coupon_payment_date" id="last_coupon_payment_date" 
                                        value="{{ old('last_coupon_payment_date') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="coupon_accrual" class="block text-sm font-medium text-gray-700">Coupon Accrual *</label>
                                    <input type="number" step="0.01" name="coupon_accrual" id="coupon_accrual" 
                                        value="{{ old('coupon_accrual') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="amount_issued" class="block text-sm font-medium text-gray-700">Amount Issued *</label>
                                    <input type="number" step="0.01" name="amount_issued" id="amount_issued" 
                                        value="{{ old('amount_issued') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="amount_outstanding" class="block text-sm font-medium text-gray-700">Amount Outstanding *</label>
                                    <input type="number" step="0.01" name="amount_outstanding" id="amount_outstanding" 
                                        value="{{ old('amount_outstanding') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>

                                <div>
                                    <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Last Traded Yield</label>
                                    <input type="number" step="0.01" name="last_traded_yield" id="last_traded_yield" 
                                        value="{{ old('last_traded_yield') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('bonds.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray- 300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Create Bond
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>