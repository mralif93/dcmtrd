<!-- resources/views/admin/financial-reports/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Financial Report') }}
            </h2>
            <a href="{{ route('financial-reports.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Reports
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

            <!-- Pre-selected Information (if any) -->
            @if($selectedPortfolio)
                <div class="mb-6 p-4 bg-blue-50 border-l-4 border-blue-400">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Creating report for selected portfolio</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <div>Portfolio: {{ $selectedPortfolio->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('financial-reports.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Report Basics -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Report Basics</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                    <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300" 
                                        {{ $selectedPortfolio ? 'disabled' : '' }}>
                                        <option value="">Select Portfolio</option>
                                        @foreach($portfolios as $id => $name)
                                            <option value="{{ $id }}" {{ old('portfolio_id', $selectedPortfolio?->id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($selectedPortfolio)
                                        <input type="hidden" name="portfolio_id" value="{{ $selectedPortfolio->id }}">
                                    @endif
                                    @error('portfolio_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="report_type" class="block text-sm font-medium text-gray-700">Report Type</label>
                                    <select id="report_type" name="report_type" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($reportTypes as $key => $value)
                                            <option value="{{ $key }}" {{ old('report_type') == $key ? 'selected' : '' }}>
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('report_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fiscal_period" class="block text-sm font-medium text-gray-700">Fiscal Period</label>
                                    <input type="text" id="fiscal_period" name="fiscal_period" value="{{ old('fiscal_period') }}" 
                                        placeholder="E.g., Q1 2023, January 2023" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('fiscal_period')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="report_date" class="block text-sm font-medium text-gray-700">Report Date</label>
                                    <input type="date" id="report_date" name="report_date" value="{{ old('report_date', now()->format('Y-m-d')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('report_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Revenue Section -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Revenue</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="rental_revenue" class="block text-sm font-medium text-gray-700">Rental Revenue</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="rental_revenue" name="rental_revenue" 
                                            value="{{ old('rental_revenue', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('rental_revenue')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="other_revenue" class="block text-sm font-medium text-gray-700">Other Revenue</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="other_revenue" name="other_revenue" 
                                            value="{{ old('other_revenue', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('other_revenue')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Expenses Section -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Expenses</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="operating_expenses" class="block text-sm font-medium text-gray-700">Operating Expenses</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="operating_expenses" name="operating_expenses" 
                                            value="{{ old('operating_expenses', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('operating_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="maintenance_expenses" class="block text-sm font-medium text-gray-700">Maintenance Expenses</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="maintenance_expenses" name="maintenance_expenses" 
                                            value="{{ old('maintenance_expenses', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('maintenance_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="administrative_expenses" class="block text-sm font-medium text-gray-700">Administrative Expenses</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="administrative_expenses" name="administrative_expenses" 
                                            value="{{ old('administrative_expenses', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('administrative_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="utility_expenses" class="block text-sm font-medium text-gray-700">Utility Expenses</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="utility_expenses" name="utility_expenses" 
                                            value="{{ old('utility_expenses', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('utility_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="insurance_expenses" class="block text-sm font-medium text-gray-700">Insurance Expenses</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="insurance_expenses" name="insurance_expenses" 
                                            value="{{ old('insurance_expenses', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('insurance_expenses')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="property_tax" class="block text-sm font-medium text-gray-700">Property Tax</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="property_tax" name="property_tax" 
                                            value="{{ old('property_tax', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('property_tax')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Other Financial Data -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Other Financial Data</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="debt_service" class="block text-sm font-medium text-gray-700">Debt Service</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="debt_service" name="debt_service" 
                                            value="{{ old('debt_service', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('debt_service')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="capex" class="block text-sm font-medium text-gray-700">Capital Expenditures</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="capex" name="capex" 
                                            value="{{ old('capex', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('capex')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cash_flow" class="block text-sm font-medium text-gray-700">Cash Flow</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" step="0.01" id="cash_flow" name="cash_flow" 
                                            value="{{ old('cash_flow', '0.00') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('cash_flow')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Performance Metrics -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Performance Metrics</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="occupancy_rate" class="block text-sm font-medium text-gray-700">Occupancy Rate (%)</label>
                                    <input type="number" step="0.01" min="0" max="100" id="occupancy_rate" name="occupancy_rate" 
                                        value="{{ old('occupancy_rate', '0.00') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('occupancy_rate')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="debt_ratio" class="block text-sm font-medium text-gray-700">Debt Ratio (%)</label>
                                    <input type="number" step="0.01" min="0" id="debt_ratio" name="debt_ratio" 
                                        value="{{ old('debt_ratio', '0.00') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('debt_ratio')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <p class="mt-2 text-sm text-gray-500">Note: NOI, Net Income, Cap Rate, and ROI will be calculated automatically.</p>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('financial-reports.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create Report
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>