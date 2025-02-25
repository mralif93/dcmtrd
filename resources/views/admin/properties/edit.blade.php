<!-- resources/views/properties/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Property') }}: {{ $property->name }}
            </h2>
            <a href="{{ route('properties.show', $property) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Property
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
                    <form action="{{ route('properties.update', $property) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                    <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($portfolios as $id => $name)
                                            <option value="{{ $id }}" {{ old('portfolio_id', $property->portfolio_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('portfolio_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
                                    <input type="text" id="name" name="name" value="{{ old('name', $property->name) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="property_type" class="block text-sm font-medium text-gray-700">Property Type</label>
                                    <select id="property_type" name="property_type" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Apartment" {{ old('property_type', $property->property_type) == 'Apartment' ? 'selected' : '' }}>Apartment</option>
                                        <option value="Office" {{ old('property_type', $property->property_type) == 'Office' ? 'selected' : '' }}>Office</option>
                                        <option value="Retail" {{ old('property_type', $property->property_type) == 'Retail' ? 'selected' : '' }}>Retail</option>
                                        <option value="Mixed-Use" {{ old('property_type', $property->property_type) == 'Mixed-Use' ? 'selected' : '' }}>Mixed-Use</option>
                                    </select>
                                    @error('property_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Active" {{ old('status', $property->status) == 'Active' ? 'selected' : '' }}>Active</option>
                                        <option value="Under Renovation" {{ old('status', $property->status) == 'Under Renovation' ? 'selected' : '' }}>Under Renovation</option>
                                        <option value="For Sale" {{ old('status', $property->status) == 'For Sale' ? 'selected' : '' }}>For Sale</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Location Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Location Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div class="col-span-2">
                                    <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                    <input type="text" id="address" name="address" value="{{ old('address', $property->address) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                    <input type="text" id="city" name="city" value="{{ old('city', $property->city) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('city')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                    <input type="text" id="state" name="state" value="{{ old('state', $property->state) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('state')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('postal_code')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                    <input type="text" id="country" name="country" value="{{ old('country', $property->country) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('country')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Property Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Property Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="year_built" class="block text-sm font-medium text-gray-700">Year Built</label>
                                    <input type="number" id="year_built" name="year_built" value="{{ old('year_built', $property->year_built) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('year_built')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="square_footage" class="block text-sm font-medium text-gray-700">Square Footage</label>
                                    <input type="number" id="square_footage" name="square_footage" value="{{ old('square_footage', $property->square_footage) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('square_footage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="land_area" class="block text-sm font-medium text-gray-700">Land Area (sq ft)</label>
                                    <input type="number" id="land_area" name="land_area" value="{{ old('land_area', $property->land_area) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('land_area')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="number_of_floors" class="block text-sm font-medium text-gray-700">Number of Floors</label>
                                    <input type="number" id="number_of_floors" name="number_of_floors" value="{{ old('number_of_floors', $property->number_of_floors) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('number_of_floors')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="parking_spaces" class="block text-sm font-medium text-gray-700">Parking Spaces</label>
                                    <input type="number" id="parking_spaces" name="parking_spaces" value="{{ old('parking_spaces', $property->parking_spaces) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('parking_spaces')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="zoning_type" class="block text-sm font-medium text-gray-700">Zoning Type</label>
                                    <input type="text" id="zoning_type" name="zoning_type" value="{{ old('zoning_type', $property->zoning_type) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('zoning_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="building_class" class="block text-sm font-medium text-gray-700">Building Class</label>
                                    <select id="building_class" name="building_class" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="A" {{ old('building_class', $property->building_class) == 'A' ? 'selected' : '' }}>A</option>
                                        <option value="B" {{ old('building_class', $property->building_class) == 'B' ? 'selected' : '' }}>B</option>
                                        <option value="C" {{ old('building_class', $property->building_class) == 'C' ? 'selected' : '' }}>C</option>
                                    </select>
                                    @error('building_class')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="primary_use" class="block text-sm font-medium text-gray-700">Primary Use</label>
                                    <input type="text" id="primary_use" name="primary_use" value="{{ old('primary_use', $property->primary_use) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('primary_use')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="occupancy_rate" class="block text-sm font-medium text-gray-700">Occupancy Rate (%)</label>
                                    <input type="number" id="occupancy_rate" name="occupancy_rate" value="{{ old('occupancy_rate', $property->occupancy_rate) }}" min="0" max="100" step="0.1" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('occupancy_rate')
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
                                    <label for="purchase_price" class="block text-sm font-medium text-gray-700">Purchase Price</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="purchase_price" name="purchase_price" step="0.01" value="{{ old('purchase_price', $property->purchase_price) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('purchase_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="current_value" class="block text-sm font-medium text-gray-700">Current Value</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="current_value" name="current_value" step="0.01" value="{{ old('current_value', $property->current_value) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('current_value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="expected_roi" class="block text-sm font-medium text-gray-700">Expected ROI (%)</label>
                                    <input type="number" id="expected_roi" name="expected_roi" step="0.01" value="{{ old('expected_roi', $property->expected_roi) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('expected_roi')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="acquisition_date" class="block text-sm font-medium text-gray-700">Acquisition Date</label>
                                    <input type="date" id="acquisition_date" name="acquisition_date" value="{{ old('acquisition_date', $property->acquisition_date->format('Y-m-d')) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('acquisition_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="annual_property_tax" class="block text-sm font-medium text-gray-700">Annual Property Tax</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="annual_property_tax" name="annual_property_tax" step="0.01" value="{{ old('annual_property_tax', $property->annual_property_tax) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('annual_property_tax')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="insurance_cost" class="block text-sm font-medium text-gray-700">Insurance Cost (Annual)</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="insurance_cost" name="insurance_cost" step="0.01" value="{{ old('insurance_cost', $property->insurance_cost) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('insurance_cost')
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
                                    <label for="property_manager" class="block text-sm font-medium text-gray-700">Property Manager</label>
                                    <input type="text" id="property_manager" name="property_manager" value="{{ old('property_manager', $property->property_manager) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('property_manager')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="tax_parcel_id" class="block text-sm font-medium text-gray-700">Tax Parcel ID</label>
                                    <input type="text" id="tax_parcel_id" name="tax_parcel_id" value="{{ old('tax_parcel_id', $property->tax_parcel_id) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('tax_parcel_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-2">
                                    <label for="insurance_details" class="block text-sm font-medium text-gray-700">Insurance Details</label>
                                    <textarea id="insurance_details" name="insurance_details" rows="3" 
                                        class="mt-1 block w-full rounded-md border-gray-300">{{ old('insurance_details', $property->insurance_details) }}</textarea>
                                    @error('insurance_details')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_renovation_date" class="block text-sm font-medium text-gray-700">Last Renovation Date</label>
                                    <input type="date" id="last_renovation_date" name="last_renovation_date" 
                                        value="{{ old('last_renovation_date', $property->last_renovation_date ? $property->last_renovation_date->format('Y-m-d') : '') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('last_renovation_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('properties.show', $property) }}" 
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