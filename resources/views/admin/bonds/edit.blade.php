<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Bond') }}
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
                <form action="{{ route('bonds.update', $bond) }}" method="POST" class="p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6 pb-6">
                        <!-- Core Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-4">
                                <div>
                                    <label for="bond_sukuk_name" class="block text-sm font-medium text-gray-700">Bond Name *</label>
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

                                <div>
                                    <label for="issuer_id" class="block text-sm font-medium text-gray-700">Issuer *</label>
                                    <select name="issuer_id" id="issuer_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select an Issuer</option>
                                        @foreach($issuers as $issuer)
                                            <option value="{{ $issuer->id }}" 
                                                @selected(old('issuer_id', $bond->issuer_id) == $issuer->id)>
                                                {{ $issuer->issuer_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="space-y-4">
                                <div>
                                    <label for="rating" class="block text-sm font-medium text-gray-700">Rating *</label>
                                    <select name="rating" id="rating" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['AAA','AA+','AA','AA-','A+','A','A-','BBB+','BBB','BBB-','BB+','BB','BB-','B+','B','B-','CCC','CC','C','D'] as $grade)
                                            <option value="{{ $grade }}" 
                                                @selected(old('rating', $bond->rating) == $grade)>
                                                {{ $grade }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-700">Category *</label>
                                    <select name="category" id="category" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select Category</option>
                                        @foreach(['Government','Corporate','Sukuk','Green Bonds','Islamic'] as $cat)
                                            <option value="{{ $cat }}" 
                                                @selected(old('category', $bond->category) == $cat)>
                                                {{ $cat }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                                    <select name="status" id="status" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        @foreach(['active','inactive','matured'] as $status)
                                            <option value="{{ $status }}" 
                                                @selected(old('status', $bond->status) == $status)>
                                                {{ ucfirst($status) }}
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
                                    <label for="last_traded_date" class="block text-sm font-medium text-gray-700">Last Traded Date *</label>
                                    <input type="date" name="last_traded_date" id="last_traded_date" 
                                        value="{{ old('last_traded_date', $bond->last_traded_date?->format('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_yield" class="block text-sm font-medium text-gray-700">Yield (%) *</label>
                                    <input type="number" step="0.01" name="last_traded_yield" id="last_traded_yield" 
                                        value="{{ old('last_traded_yield', $bond->last_traded_yield) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="last_traded_price" class="block text-sm font-medium text-gray-700">Price *</label>
                                    <input type="number" step="0.01" name="last_traded_price" id="last_traded_price" 
                                        value="{{ old('last_traded_price', $bond->last_traded_price) }}" required
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
                                        value="{{ old('last_traded_amount', $bond->last_traded_amount) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="o_s_amount" class="block text-sm font-medium text-gray-700">Outstanding Amount *</label>
                                    <input type="number" step="0.01" name="o_s_amount" id="o_s_amount" 
                                        value="{{ old('o_s_amount', $bond->o_s_amount) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="residual_tenure" class="block text-sm font-medium text-gray-700">Residual Tenure (Years) *</label>
                                    <input type="number" name="residual_tenure" id="residual_tenure" 
                                        value="{{ old('residual_tenure', $bond->residual_tenure) }}" required min="0" max="100"
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
                                        value="{{ old('facility_code', $bond->facility_code) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                
                                <div>
                                    <label for="approval_date_time" class="block text-sm font-medium text-gray-700">Approval Date/Time</label>
                                    <input type="datetime-local" name="approval_date_time" id="approval_date_time" 
                                        value="{{ old('approval_date_time', $bond->approval_date_time ? $bond->approval_date_time->format('Y-m-d\TH:i') : '') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
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