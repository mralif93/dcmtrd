<!-- resources/views/financials/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Financial Record') }}
            </h2>
            <a href="{{ route('property-m.index', $financial->portfolio) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
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

                    <form method="POST" action="{{ route('financials-info.update', $financial) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Basic Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Portfolio -->
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-500">Portfolio</label>
                                    <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a portfolio</option>
                                        @foreach($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" {{ old('portfolio_id', $financial->portfolio_id) == $portfolio->id ? 'selected' : '' }}>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('portfolio_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bank -->
                                <div>
                                    <label for="bank_id" class="block text-sm font-medium text-gray-500">Bank</label>
                                    <select id="bank_id" name="bank_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank_id', $financial->bank_id) == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Financial Type -->
                                <div>
                                    <label for="financial_type_id" class="block text-sm font-medium text-gray-500">Financial Type</label>
                                    <select id="financial_type_id" name="financial_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select a type</option>
                                        @foreach($financialTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('financial_type_id', $financial->financial_type_id) == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('financial_type_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Purpose -->
                                <div>
                                    <label for="purpose" class="block text-sm font-medium text-gray-500">Purpose</label>
                                    <input id="purpose" type="text" name="purpose" value="{{ old('purpose', $financial->purpose) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('purpose')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tenure -->
                                <div>
                                    <label for="tenure" class="block text-sm font-medium text-gray-500">Tenure</label>
                                    <input id="tenure" type="text" name="tenure" value="{{ old('tenure', $financial->tenure) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('tenure')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Installment Date -->
                                <div>
                                    <label for="installment_date" class="block text-sm font-medium text-gray-500">Installment Date</label>
                                    <input id="installment_date" type="date" name="installment_date" value="{{ old('installment_date', $financial->installment_date->format('Y-m-d')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('installment_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Financial Details</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Profit Type -->
                                <div>
                                    <label for="profit_type" class="block text-sm font-medium text-gray-500">Profit Type</label>
                                    <input id="profit_type" type="text" name="profit_type" value="{{ old('profit_type', $financial->profit_type) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('profit_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Profit Rate -->
                                <div>
                                    <label for="profit_rate" class="block text-sm font-medium text-gray-500">Profit Rate (%)</label>
                                    <input id="profit_rate" type="number" name="profit_rate" value="{{ old('profit_rate', $financial->profit_rate) }}" step="0.0001" min="0" max="100" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('profit_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Process Fee -->
                                <div>
                                    <label for="process_fee" class="block text-sm font-medium text-gray-500">Process Fee</label>
                                    <input id="process_fee" type="number" name="process_fee" value="{{ old('process_fee', $financial->process_fee) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('process_fee')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Amount Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Total Facility Amount -->
                                <div>
                                    <label for="total_facility_amount" class="block text-sm font-medium text-gray-500">Total Facility Amount</label>
                                    <input id="total_facility_amount" type="number" name="total_facility_amount" value="{{ old('total_facility_amount', $financial->total_facility_amount) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('total_facility_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Utilization Amount -->
                                <div>
                                    <label for="utilization_amount" class="block text-sm font-medium text-gray-500">Utilization Amount</label>
                                    <input id="utilization_amount" type="number" name="utilization_amount" value="{{ old('utilization_amount', $financial->utilization_amount) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('utilization_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Outstanding Amount -->
                                <div>
                                    <label for="outstanding_amount" class="block text-sm font-medium text-gray-500">Outstanding Amount</label>
                                    <input id="outstanding_amount" type="number" name="outstanding_amount" value="{{ old('outstanding_amount', $financial->outstanding_amount) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('outstanding_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Interest Monthly -->
                                <div>
                                    <label for="interest_monthly" class="block text-sm font-medium text-gray-500">Monthly Interest</label>
                                    <input id="interest_monthly" type="number" name="interest_monthly" value="{{ old('interest_monthly', $financial->interest_monthly) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('interest_monthly')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Security Value Monthly -->
                                <div>
                                    <label for="security_value_monthly" class="block text-sm font-medium text-gray-500">Monthly Security Value</label>
                                    <input id="security_value_monthly" type="number" name="security_value_monthly" value="{{ old('security_value_monthly', $financial->security_value_monthly) }}" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('security_value_monthly')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Contact Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Facilities Agent -->
                                <div>
                                    <label for="facilities_agent" class="block text-sm font-medium text-gray-500">Facilities Agent</label>
                                    <input id="facilities_agent" type="text" name="facilities_agent" value="{{ old('facilities_agent', $financial->facilities_agent) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('facilities_agent')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Agent Contact -->
                                <div>
                                    <label for="agent_contact" class="block text-sm font-medium text-gray-500">Agent Contact</label>
                                    <input id="agent_contact" type="text" name="agent_contact" value="{{ old('agent_contact', $financial->agent_contact) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('agent_contact')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Valuer -->
                                <div>
                                    <label for="valuer" class="block text-sm font-medium text-gray-500">Valuer</label>
                                    <input id="valuer" type="text" name="valuer" value="{{ old('valuer', $financial->valuer) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                    @error('valuer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-500">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="active" {{ old('status', $financial->status) == 'active' ? 'selected' : '' }}>Active</option>
                                        <option value="inactive" {{ old('status', $financial->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                        <option value="pending" {{ old('status', $financial->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('property-m.index', $financial->portfolio) }}" 
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
                                    Update Financial
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>