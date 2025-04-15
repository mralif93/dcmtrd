<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Financial Record') }}
            </h2>
            <a href="{{ route('property-m.index', $portfolioInfo) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-25 transition ease-in-out duration-150">
                &larr; Back to List
            </a>
        </div>
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('financials.store') }}" method="POST">
                        @csrf

                        <!-- Primary Information Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Primary Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Portfolio -->
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                    <select name="portfolio_id" id="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">Select Portfolio</option>
                                        @foreach($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" {{ old('portfolio_id') == $portfolio->id ? 'selected' : '' }}>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('portfolio_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Bank -->
                                <div>
                                    <label for="bank_id" class="block text-sm font-medium text-gray-700">Bank</label>
                                    <select name="bank_id" id="bank_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">Select Bank</option>
                                        @foreach($banks as $bank)
                                            <option value="{{ $bank->id }}" {{ old('bank_id') == $bank->id ? 'selected' : '' }}>
                                                {{ $bank->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('bank_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Financial Type -->
                                <div>
                                    <label for="financial_type_id" class="block text-sm font-medium text-gray-700">Financial Type</label>
                                    <select name="financial_type_id" id="financial_type_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">Select Financial Type</option>
                                        @foreach($financialTypes as $type)
                                            <option value="{{ $type->id }}" {{ old('financial_type_id') == $type->id ? 'selected' : '' }}>
                                                {{ $type->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('financial_type_id')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Purpose -->
                                <div>
                                    <label for="purpose" class="block text-sm font-medium text-gray-700">Purpose</label>
                                    <input id="purpose" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="purpose" value="{{ old('purpose') }}" required>
                                    @error('purpose')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Details Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Financial Details</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Tenure -->
                                <div>
                                    <label for="tenure" class="block text-sm font-medium text-gray-700">Tenure</label>
                                    <input id="tenure" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="tenure" value="{{ old('tenure') }}" required>
                                    @error('tenure')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Installment Date -->
                                <div>
                                    <label for="installment_date" class="block text-sm font-medium text-gray-700">Installment Date</label>
                                    <input id="installment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="installment_date" value="{{ old('installment_date') }}" required>
                                    @error('installment_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Profit Type -->
                                <div>
                                    <label for="profit_type" class="block text-sm font-medium text-gray-700">Profit Type</label>
                                    <select name="profit_type" id="profit_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        <option value="">Select Profit Type</option>
                                        <option value="fixed" {{ old('profit_type') == 'fixed' ? 'selected' : '' }}>Fixed</option>
                                        <option value="variable" {{ old('profit_type') == 'variable' ? 'selected' : '' }}>Variable</option>
                                    </select>
                                    @error('profit_type')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Profit Rate -->
                                <div>
                                    <label for="profit_rate" class="block text-sm font-medium text-gray-700">Profit Rate (%)</label>
                                    <input id="profit_rate" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="profit_rate" value="{{ old('profit_rate') }}" step="0.0001" min="0" required>
                                    @error('profit_rate')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Process Fee -->
                                <div>
                                    <label for="process_fee" class="block text-sm font-medium text-gray-700">Process Fee</label>
                                    <input id="process_fee" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="process_fee" value="{{ old('process_fee') }}" step="0.01" min="0" required>
                                    @error('process_fee')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Total Facility Amount -->
                                <div>
                                    <label for="total_facility_amount" class="block text-sm font-medium text-gray-700">Total Facility Amount</label>
                                    <input id="total_facility_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="total_facility_amount" value="{{ old('total_facility_amount') }}" step="0.01" min="0" required>
                                    @error('total_facility_amount')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Utilization Amount -->
                                <div>
                                    <label for="utilization_amount" class="block text-sm font-medium text-gray-700">Utilization Amount</label>
                                    <input id="utilization_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="utilization_amount" value="{{ old('utilization_amount') }}" step="0.01" min="0" required>
                                    @error('utilization_amount')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Outstanding Amount -->
                                <div>
                                    <label for="outstanding_amount" class="block text-sm font-medium text-gray-700">Outstanding Amount</label>
                                    <input id="outstanding_amount" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="outstanding_amount" value="{{ old('outstanding_amount') }}" step="0.01" min="0" required>
                                    @error('outstanding_amount')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Interest Monthly -->
                                <div>
                                    <label for="interest_monthly" class="block text-sm font-medium text-gray-700">Interest Monthly</label>
                                    <input id="interest_monthly" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="interest_monthly" value="{{ old('interest_monthly') }}" step="0.01" min="0" required>
                                    @error('interest_monthly')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Security Value Monthly -->
                                <div>
                                    <label for="security_value_monthly" class="block text-sm font-medium text-gray-700">Security Value Monthly</label>
                                    <input id="security_value_monthly" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="number" name="security_value_monthly" value="{{ old('security_value_monthly') }}" step="0.01" min="0" required>
                                    @error('security_value_monthly')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Contact Information Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Contact Information</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Facilities Agent -->
                                <div>
                                    <label for="facilities_agent" class="block text-sm font-medium text-gray-700">Facilities Agent</label>
                                    <input id="facilities_agent" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="facilities_agent" value="{{ old('facilities_agent') }}" required>
                                    @error('facilities_agent')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Agent Contact -->
                                <div>
                                    <label for="agent_contact" class="block text-sm font-medium text-gray-700">Agent Contact</label>
                                    <input id="agent_contact" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="agent_contact" value="{{ old('agent_contact') }}">
                                    @error('agent_contact')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Valuer -->
                                <div>
                                    <label for="valuer" class="block text-sm font-medium text-gray-700">Valuer</label>
                                    <input id="valuer" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="valuer" value="{{ old('valuer') }}" required>
                                    @error('valuer')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Associated Properties Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Associated Properties</h3>
                            
                            <div id="properties-container">
                                <div class="property-item p-4 bg-gray-50 rounded-md mb-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Property</label>
                                            <select name="property_ids[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                                <option value="">Select Property</option>
                                                @foreach($properties as $property)
                                                    <option value="{{ $property->id }}">
                                                        {{ $property->name }} ({{ $property->address }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Property Value</label>
                                            <input type="number" name="property_values[]" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Financed Amount</label>
                                            <input type="number" name="financed_amounts[]" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-3">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Security Value</label>
                                            <input type="number" name="security_values[]" step="0.01" min="0" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Valuation Date</label>
                                            <input type="date" name="valuation_dates[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Remarks</label>
                                            <input type="text" name="property_remarks[]" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        </div>
                                    </div>
                                    <div class="mt-3 flex justify-end">
                                        <button type="button" class="remove-property inline-flex items-center px-3 py-1 bg-red-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-400 focus:outline-none focus:border-red-600 focus:ring focus:ring-red-200 focus:ring-opacity-50 disabled:opacity-25 transition ease-in-out duration-150">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3">
                                <button type="button" id="add-property" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring-indigo-200 disabled:opacity-25 transition ease-in-out duration-150">
                                    Add Another Property
                                </button>
                            </div>
                        </div>

                        <!-- Prepared By Information -->
                        <div class="mb-8">
                            <input type="hidden" name="prepared_by" value="{{ Auth::id() }}">
                        </div>

                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('property-m.index', $portfolioInfo) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 active:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 disabled:opacity-25 transition ease-in-out duration-150">
                                Create Financial Record
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add Property
            document.getElementById('add-property').addEventListener('click', function() {
                const container = document.getElementById('properties-container');
                const propertyItems = container.querySelectorAll('.property-item');
                const newItem = propertyItems[0].cloneNode(true);
                
                // Clear input values
                newItem.querySelectorAll('input').forEach(input => {
                    input.value = '';
                });
                
                // Reset select
                newItem.querySelector('select').selectedIndex = 0;
                
                // Add remove event listener
                newItem.querySelector('.remove-property').addEventListener('click', function() {
                    if (container.querySelectorAll('.property-item').length > 1) {
                        this.closest('.property-item').remove();
                    }
                });
                
                container.appendChild(newItem);
            });
            
            // Initialize remove buttons
            document.querySelectorAll('.remove-property').forEach(button => {
                button.addEventListener('click', function() {
                    const container = document.getElementById('properties-container');
                    if (container.querySelectorAll('.property-item').length > 1) {
                        this.closest('.property-item').remove();
                    }
                });
            });

            // Filter properties by selected portfolio
            document.getElementById('portfolio_id').addEventListener('change', function() {
                const portfolioId = this.value;
                
                if (portfolioId) {
                    fetch(`/api/portfolios/${portfolioId}/properties`)
                        .then(response => response.json())
                        .then(data => {
                            document.querySelectorAll('select[name="property_ids[]"]').forEach(select => {
                                // Clear existing options except the first one
                                while (select.options.length > 1) {
                                    select.remove(1);
                                }
                                
                                // Add new options
                                data.forEach(property => {
                                    const option = new Option(
                                        `${property.name} (${property.address})`, 
                                        property.id
                                    );
                                    select.add(option);
                                });
                            });
                        })
                        .catch(error => {
                            console.error('Error fetching properties:', error);
                        });
                }
            });
        });
    </script>
    @endpush
</x-app-layout>