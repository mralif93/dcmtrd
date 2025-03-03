<!-- resources/views/financials/edit.blade.php -->

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Financial Record') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                            <ul class="list-disc pl-5">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('financials.update', $financial->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Portfolio -->
                            <div>
                                <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                <select name="portfolio_id" id="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Portfolio</option>
                                    @foreach($portfolios as $portfolio)
                                        <option value="{{ $portfolio->id }}" {{ (old('portfolio_id', $financial->portfolio_id) == $portfolio->id) ? 'selected' : '' }}>
                                            {{ $portfolio->portfolio_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Bank -->
                            <div>
                                <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank</label>
                                <select name="bank_id" id="bank_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Bank</option>
                                    @foreach($banks as $bank)
                                        <option value="{{ $bank->id }}" {{ (old('bank_id', $financial->bank_id) == $bank->id) ? 'selected' : '' }}>
                                            {{ $bank->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Financial Type -->
                            <div>
                                <label for="financial_type_id" class="block text-sm font-medium text-gray-700">Financial Type</label>
                                <select name="financial_type_id" id="financial_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Financial Type</option>
                                    @foreach($financialTypes as $type)
                                        <option value="{{ $type->id }}" {{ (old('financial_type_id', $financial->financial_type_id) == $type->id) ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Purpose -->
                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                                <input id="purpose" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="purpose" value="{{ old('purpose', $financial->purpose) }}" required>
                            </div>

                            <!-- Tenure -->
                            <div>
                                <label for="tenure" class="block text-sm font-medium text-gray-700">Tenure</label>
                                <input id="tenure" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="tenure" value="{{ old('tenure', $financial->tenure) }}" required>
                            </div>

                            <!-- Installment Date -->
                            <div>
                                <label for="installment_date" class="block text-sm font-medium text-gray-700">Installment Date</label>
                                <input id="installment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="date" name="installment_date" value="{{ old('installment_date', $financial->installment_date) }}" required>
                            </div>

                            <!-- Profit Type -->
                            <div>
                                <label for="profit_type" class="block text-sm font-medium text-gray-700">Profit Type</label>
                                <select name="profit_type" id="profit_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Profit Type</option>
                                    <option value="fixed" {{ (old('profit_type', $financial->profit_type) == 'fixed') ? 'selected' : '' }}>Fixed</option>
                                    <option value="variable" {{ (old('profit_type', $financial->profit_type) == 'variable') ? 'selected' : '' }}>Variable</option>
                                </select>
                            </div>

                            <!-- Profit Rate -->
                            <div>
                                <label for="profit_rate" class="block text-sm font-medium text-gray-700">Profit Rate (%)</label>
                                <input id="profit_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="profit_rate" value="{{ old('profit_rate', $financial->profit_rate) }}" step="0.0001" min="0" required>
                            </div>

                            <!-- Process Fee -->
                            <div>
                                <label for="process_fee" class="block text-sm font-medium text-gray-700">Process Fee</label>
                                <input id="process_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="process_fee" value="{{ old('process_fee', $financial->process_fee) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Total Facility Amount -->
                            <div>
                                <label for="total_facility_amount" class="block text-sm font-medium text-gray-700">Total Facility Amount</label>
                                <input id="total_facility_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="total_facility_amount" value="{{ old('total_facility_amount', $financial->total_facility_amount) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Utilization Amount -->
                            <div>
                                <label for="utilization_amount" class="block text-sm font-medium text-gray-700">Utilization Amount</label>
                                <input id="utilization_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="utilization_amount" value="{{ old('utilization_amount', $financial->utilization_amount) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Outstanding Amount -->
                            <div>
                                <label for="outstanding_amount" class="block text-sm font-medium text-gray-700">Outstanding Amount</label>
                                <input id="outstanding_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="outstanding_amount" value="{{ old('outstanding_amount', $financial->outstanding_amount) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Interest Monthly -->
                            <div>
                                <label for="interest_monthly" class="block text-sm font-medium text-gray-700">Interest Monthly</label>
                                <input id="interest_monthly" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="interest_monthly" value="{{ old('interest_monthly', $financial->interest_monthly) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Security Value Monthly -->
                            <div>
                                <label for="security_value_monthly" class="block text-sm font-medium text-gray-700">Security Value Monthly</label>
                                <input id="security_value_monthly" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="security_value_monthly" value="{{ old('security_value_monthly', $financial->security_value_monthly) }}" step="0.01" min="0" required>
                            </div>

                            <!-- Facilities Agent -->
                            <div>
                                <label for="facilities_agent" class="block text-sm font-medium text-gray-700">Facilities Agent</label>
                                <input id="facilities_agent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="facilities_agent" value="{{ old('facilities_agent', $financial->facilities_agent) }}" required>
                            </div>

                            <!-- Agent Contact -->
                            <div>
                                <label for="agent_contact" class="block text-sm font-medium text-gray-700">Agent Contact</label>
                                <input id="agent_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="agent_contact" value="{{ old('agent_contact', $financial->agent_contact) }}">
                            </div>

                            <!-- Valuer -->
                            <div>
                                <label for="valuer" class="block text-sm font-medium text-gray-700">Valuer</label>
                                <input id="valuer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="valuer" value="{{ old('valuer', $financial->valuer) }}" required>
                            </div>

                            <!-- Status -->
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="active" {{ old('status', $financial->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status', $financial->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="pending" {{ old('status', $financial->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('financials.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>