<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Property') }}
            </h2>
            <a href="{{ route('property-m.index', $portfolioInfo) }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150">
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

                    <form action="{{ route('property-m.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="grid grid-cols-1 gap-6">
                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4">Portfolio Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Portfolio -->
                                <div class="col-span-2">
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-500">Portfolio</label>
                                    <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                                        <option value="">Select Portfolio</option>
                                        @foreach ($portfolios as $portfolio)
                                            <option value="{{ $portfolio->id }}" {{ old('portfolio_id', $portfolioInfo->id) == $portfolio->id ? 'selected' : '' }}>
                                                {{ $portfolio->portfolio_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('portfolio_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Basic Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Property Name -->
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-500">Property Name</label>
                                    <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Category -->
                                <div>
                                    <label for="category" class="block text-sm font-medium text-gray-500">Category</label>
                                    <input type="text" name="category" id="category" value="{{ old('category') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('category')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Batch No -->
                                <div>
                                    <label for="batch_no" class="block text-sm font-medium text-gray-500">Batch No</label>
                                    <input type="text" name="batch_no" id="batch_no" value="{{ old('batch_no') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('batch_no')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Usage -->
                                <div>
                                    <label for="usage" class="block text-sm font-medium text-gray-500">Usage</label>
                                    <input type="text" name="usage" id="usage" value="{{ old('usage') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('usage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Location Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Address -->
                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-500">Address</label>
                                    <input type="text" name="address" id="address" value="{{ old('address') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- City -->
                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-500">City</label>
                                    <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- State -->
                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-500">State</label>
                                    <input type="text" name="state" id="state" value="{{ old('state') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Country -->
                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-500">Country</label>
                                    <input type="text" name="country" id="country" value="{{ old('country') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Postal Code -->
                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-500">Postal Code</label>
                                    <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Property Measurements</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Land Size -->
                                <div>
                                    <label for="land_size" class="block text-sm font-medium text-gray-500">Land Size (m²)</label>
                                    <input type="number" step="0.01" name="land_size" id="land_size" value="{{ old('land_size') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('land_size')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Gross Floor Area -->
                                <div>
                                    <label for="gross_floor_area" class="block text-sm font-medium text-gray-500">Gross Floor Area (m²)</label>
                                    <input type="number" step="0.01" name="gross_floor_area" id="gross_floor_area" value="{{ old('gross_floor_area') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('gross_floor_area')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Financial Information</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Value -->
                                <div>
                                    <label for="value" class="block text-sm font-medium text-gray-500">Value (RM)</label>
                                    <input type="number" step="0.01" name="value" id="value" value="{{ old('value') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Market Value -->
                                <div>
                                    <label for="market_value" class="block text-sm font-medium text-gray-500">Market Value (RM)</label>
                                    <input type="number" step="0.01" name="market_value" id="market_value" value="{{ old('market_value') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('market_value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ownership -->
                                <div>
                                    <label for="ownership" class="block text-sm font-medium text-gray-500">Ownership</label>
                                    <input type="text" name="ownership" id="ownership" value="{{ old('ownership') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('ownership')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Share Amount -->
                                <div>
                                    <label for="share_amount" class="block text-sm font-medium text-gray-500">Share Amount (RM)</label>
                                    <input type="number" step="0.01" name="share_amount" id="share_amount" value="{{ old('share_amount') }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    @error('share_amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-span-1">
                                <h3 class="text-lg font-medium text-gray-900 border-b pb-2 mb-4 mt-4">Documentation</h3>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Master Lease Agreement -->
                                <div>
                                    <label for="master_lease_agreement" class="block text-sm font-medium text-gray-500">Master Lease Agreement</label>
                                    <input type="file" name="master_lease_agreement" id="master_lease_agreement" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Upload PDF files only</p>
                                    @error('master_lease_agreement')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Valuation Report -->
                                <div>
                                    <label for="valuation_report" class="block text-sm font-medium text-gray-500">Valuation Report</label>
                                    <input type="file" name="valuation_report" id="valuation_report" accept=".pdf" class="mt-1 block w-full text-sm text-gray-500
                                    file:mr-4 file:py-2 file:px-4
                                    file:rounded-md file:border-0
                                    file:text-sm file:font-semibold
                                    file:bg-indigo-50 file:text-indigo-700
                                    hover:file:bg-indigo-100">
                                    <p class="text-xs text-gray-500 mt-1">Upload PDF files only</p>
                                    @error('valuation_report')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>


                        </div>

                        <div class="border-t border-gray-200 py-4 mt-6">
                            <div class="flex justify-end gap-4">
                                <a href="{{ route('property-m.index', $portfolioInfo) }}" 
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
                                    Create Property
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>