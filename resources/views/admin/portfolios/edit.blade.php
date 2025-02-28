<!-- resources/views/portfolios/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Portfolio') }}: {{ $portfolio->name }}
            </h2>
            <a href="{{ route('portfolios.show', $portfolio) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Portfolio
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
                <div class="p-6">
                    <form action="{{ route('portfolios.update', $portfolio) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Portfolio Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $portfolio->name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="type" class="block text-sm font-medium text-gray-700">Portfolio Type</label>
                                    <select id="type" name="type" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Residential" {{ old('type', $portfolio->type) == 'Residential' ? 'selected' : '' }}>Residential</option>
                                        <option value="Commercial" {{ old('type', $portfolio->type) == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                        <option value="Mixed-Use" {{ old('type', $portfolio->type) == 'Mixed-Use' ? 'selected' : '' }}>Mixed-Use</option>
                                    </select>
                                    @error('type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('description', $portfolio->description) }}</textarea>
                                    @error('description')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="foundation_date" class="block text-sm font-medium text-gray-700">Foundation Date</label>
                                    <input type="date" id="foundation_date" name="foundation_date" 
                                        value="{{ old('foundation_date', $portfolio->foundation_date->format('Y-m-d')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('foundation_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="fiscal_year_end" class="block text-sm font-medium text-gray-700">Fiscal Year End</label>
                                    <input type="date" id="fiscal_year_end" name="fiscal_year_end" 
                                        value="{{ old('fiscal_year_end', $portfolio->fiscal_year_end->format('Y-m-d')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('fiscal_year_end')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Financial Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="total_assets" class="block text-sm font-medium text-gray-700">Total Assets</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="total_assets" name="total_assets" step="0.01" 
                                            value="{{ old('total_assets', $portfolio->total_assets) }}"
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('total_assets')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="market_cap" class="block text-sm font-medium text-gray-700">Market Cap</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="market_cap" name="market_cap" step="0.01" 
                                            value="{{ old('market_cap', $portfolio->market_cap) }}"
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('market_cap')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="available_funds" class="block text-sm font-medium text-gray-700">Available Funds</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="available_funds" name="available_funds" step="0.01" 
                                            value="{{ old('available_funds', $portfolio->available_funds) }}"
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('available_funds')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="target_return" class="block text-sm font-medium text-gray-700">Target Return (%)</label>
                                    <input type="number" id="target_return" name="target_return" step="0.01" 
                                        value="{{ old('target_return', $portfolio->target_return) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('target_return')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="currency" class="block text-sm font-medium text-gray-700">Currency</label>
                                    <select id="currency" name="currency" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="USD" {{ old('currency', $portfolio->currency) == 'USD' ? 'selected' : '' }}>USD</option>
                                        <option value="EUR" {{ old('currency', $portfolio->currency) == 'EUR' ? 'selected' : '' }}>EUR</option>
                                        <option value="GBP" {{ old('currency', $portfolio->currency) == 'GBP' ? 'selected' : '' }}>GBP</option>
                                        <option value="CAD" {{ old('currency', $portfolio->currency) == 'CAD' ? 'selected' : '' }}>CAD</option>
                                    </select>
                                    @error('currency')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="risk_profile" class="block text-sm font-medium text-gray-700">Risk Profile</label>
                                    <select id="risk_profile" name="risk_profile" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Low" {{ old('risk_profile', $portfolio->risk_profile) == 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ old('risk_profile', $portfolio->risk_profile) == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="High" {{ old('risk_profile', $portfolio->risk_profile) == 'High' ? 'selected' : '' }}>High</option>
                                    </select>
                                    @error('risk_profile')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Management Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Management Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="management_company" class="block text-sm font-medium text-gray-700">Management Company</label>
                                    <input type="text" id="management_company" name="management_company" 
                                        value="{{ old('management_company', $portfolio->management_company) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('management_company')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="portfolio_manager" class="block text-sm font-medium text-gray-700">Portfolio Manager</label>
                                    <input type="text" id="portfolio_manager" name="portfolio_manager" 
                                        value="{{ old('portfolio_manager', $portfolio->portfolio_manager) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('portfolio_manager')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="legal_entity_type" class="block text-sm font-medium text-gray-700">Legal Entity Type</label>
                                    <select id="legal_entity_type" name="legal_entity_type" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="LLC" {{ old('legal_entity_type', $portfolio->legal_entity_type) == 'LLC' ? 'selected' : '' }}>LLC</option>
                                        <option value="Corporation" {{ old('legal_entity_type', $portfolio->legal_entity_type) == 'Corporation' ? 'selected' : '' }}>Corporation</option>
                                        <option value="Partnership" {{ old('legal_entity_type', $portfolio->legal_entity_type) == 'Partnership' ? 'selected' : '' }}>Partnership</option>
                                    </select>
                                    @error('legal_entity_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tax_id" class="block text-sm font-medium text-gray-700">Tax ID</label>
                                    <input type="text" id="tax_id" name="tax_id" value="{{ old('tax_id', $portfolio->tax_id) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('tax_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="investment_strategy" class="block text-sm font-medium text-gray-700">Investment Strategy</label>
                                    <select id="investment_strategy" name="investment_strategy" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Growth" {{ old('investment_strategy', $portfolio->investment_strategy) == 'Growth' ? 'selected' : '' }}>Growth</option>
                                        <option value="Income" {{ old('investment_strategy', $portfolio->investment_strategy) == 'Income' ? 'selected' : '' }}>Income</option>
                                        <option value="Value-Add" {{ old('investment_strategy', $portfolio->investment_strategy) == 'Value-Add' ? 'selected' : '' }}>Value-Add</option>
                                        <option value="Opportunistic" {{ old('investment_strategy', $portfolio->investment_strategy) == 'Opportunistic' ? 'selected' : '' }}>Opportunistic</option>
                                    </select>
                                    @error('investment_strategy')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="active_status" class="inline-flex items-center mt-6">
                                        <input type="checkbox" id="active_status" name="active_status" value="1" 
                                            {{ old('active_status', $portfolio->active_status) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Active Portfolio</span>
                                    </label>
                                    @error('active_status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                        <a href="{{ route('portfolios.show', $portfolio) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Update
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>