<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Unit') }}: {{ $unit->unit_number }}
            </h2>
            <a href="{{ route('units.show', $unit) }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Unit
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
                    <form action="{{ route('units.update', $unit) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <!-- Basic Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Basic Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="property_id" class="block text-sm font-medium text-gray-700">Property</label>
                                    <select id="property_id" name="property_id" class="mt-1 block w-full rounded-md border-gray-300">
                                        @foreach($properties as $id => $name)
                                            <option value="{{ $id }}" {{ old('property_id', $unit->property_id) == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('property_id')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_number" class="block text-sm font-medium text-gray-700">Unit Number</label>
                                    <input type="text" id="unit_number" name="unit_number" value="{{ old('unit_number', $unit->unit_number) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('unit_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="unit_type" class="block text-sm font-medium text-gray-700">Unit Type</label>
                                    <select id="unit_type" name="unit_type" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Studio" {{ old('unit_type', $unit->unit_type) == 'Studio' ? 'selected' : '' }}>Studio</option>
                                        <option value="1BR" {{ old('unit_type', $unit->unit_type) == '1BR' ? 'selected' : '' }}>1 Bedroom</option>
                                        <option value="2BR" {{ old('unit_type', $unit->unit_type) == '2BR' ? 'selected' : '' }}>2 Bedrooms</option>
                                        <option value="3BR" {{ old('unit_type', $unit->unit_type) == '3BR' ? 'selected' : '' }}>3 Bedrooms</option>
                                        <option value="4BR+" {{ old('unit_type', $unit->unit_type) == '4BR+' ? 'selected' : '' }}>4+ Bedrooms</option>
                                    </select>
                                    @error('unit_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="floor_number" class="block text-sm font-medium text-gray-700">Floor Number</label>
                                    <input type="number" id="floor_number" name="floor_number" value="{{ old('floor_number', $unit->floor_number) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('floor_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                    <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Available" {{ old('status', $unit->status) == 'Available' ? 'selected' : '' }}>Available</option>
                                        <option value="Occupied" {{ old('status', $unit->status) == 'Occupied' ? 'selected' : '' }}>Occupied</option>
                                        <option value="Maintenance" {{ old('status', $unit->status) == 'Maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    </select>
                                    @error('status')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="condition" class="block text-sm font-medium text-gray-700">Condition</label>
                                    <select id="condition" name="condition" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="Excellent" {{ old('condition', $unit->condition) == 'Excellent' ? 'selected' : '' }}>Excellent</option>
                                        <option value="Good" {{ old('condition', $unit->condition) == 'Good' ? 'selected' : '' }}>Good</option>
                                        <option value="Fair" {{ old('condition', $unit->condition) == 'Fair' ? 'selected' : '' }}>Fair</option>
                                        <option value="Poor" {{ old('condition', $unit->condition) == 'Poor' ? 'selected' : '' }}>Poor</option>
                                    </select>
                                    @error('condition')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Unit Details -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Unit Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="square_footage" class="block text-sm font-medium text-gray-700">Square Footage</label>
                                    <input type="number" id="square_footage" name="square_footage" value="{{ old('square_footage', $unit->square_footage) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('square_footage')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bedrooms" class="block text-sm font-medium text-gray-700">Bedrooms</label>
                                    <input type="number" id="bedrooms" name="bedrooms" value="{{ old('bedrooms', $unit->bedrooms) }}" min="0" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('bedrooms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="bathrooms" class="block text-sm font-medium text-gray-700">Bathrooms</label>
                                    <input type="number" id="bathrooms" name="bathrooms" value="{{ old('bathrooms', $unit->bathrooms) }}" min="0" step="0.5" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('bathrooms')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ceiling_height" class="block text-sm font-medium text-gray-700">Ceiling Height (ft)</label>
                                    <input type="number" id="ceiling_height" name="ceiling_height" value="{{ old('ceiling_height', $unit->ceiling_height) }}" step="0.1" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('ceiling_height')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="floor_type" class="block text-sm font-medium text-gray-700">Floor Type</label>
                                    <input type="text" id="floor_type" name="floor_type" value="{{ old('floor_type', $unit->floor_type) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('floor_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="view_type" class="block text-sm font-medium text-gray-700">View Type</label>
                                    <input type="text" id="view_type" name="view_type" value="{{ old('view_type', $unit->view_type) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('view_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="exposure" class="block text-sm font-medium text-gray-700">Exposure</label>
                                    <select id="exposure" name="exposure" class="mt-1 block w-full rounded-md border-gray-300">
                                        <option value="North" {{ old('exposure', $unit->exposure) == 'North' ? 'selected' : '' }}>North</option>
                                        <option value="South" {{ old('exposure', $unit->exposure) == 'South' ? 'selected' : '' }}>South</option>
                                        <option value="East" {{ old('exposure', $unit->exposure) == 'East' ? 'selected' : '' }}>East</option>
                                        <option value="West" {{ old('exposure', $unit->exposure) == 'West' ? 'selected' : '' }}>West</option>
                                    </select>
                                    @error('exposure')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_renovation" class="block text-sm font-medium text-gray-700">Last Renovation Date</label>
                                    <input type="date" id="last_renovation" name="last_renovation" 
                                        value="{{ old('last_renovation', $unit->last_renovation ? $unit->last_renovation->format('Y-m-d') : '') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('last_renovation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Financial Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Financial Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="base_rent" class="block text-sm font-medium text-gray-700">Base Rent</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="base_rent" name="base_rent" step="0.01" value="{{ old('base_rent', $unit->base_rent) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('base_rent')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="utility_cost" class="block text-sm font-medium text-gray-700">Utility Cost</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="utility_cost" name="utility_cost" step="0.01" value="{{ old('utility_cost', $unit->utility_cost) }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('utility_cost')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Amenities -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Amenities</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="furnished" class="flex items-center">
                                        <input type="checkbox" id="furnished" name="furnished" value="1" 
                                            {{ old('furnished', $unit->furnished) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Furnished</span>
                                    </label>
                                    @error('furnished')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="pets_allowed" class="flex items-center">
                                        <input type="checkbox" id="pets_allowed" name="pets_allowed" value="1" 
                                            {{ old('pets_allowed', $unit->pets_allowed) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Pets Allowed</span>
                                    </label>
                                    @error('pets_allowed')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="washer_dryer" class="flex items-center">
                                        <input type="checkbox" id="washer_dryer" name="washer_dryer" value="1" 
                                            {{ old('washer_dryer', $unit->washer_dryer) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Washer/Dryer</span>
                                    </label>
                                    @error('washer_dryer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="parking_included" class="flex items-center">
                                        <input type="checkbox" id="parking_included" name="parking_included" value="1" 
                                            {{ old('parking_included', $unit->parking_included) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <span class="ml-2">Parking Included</span>
                                    </label>
                                    @error('parking_included')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="heating_type" class="block text-sm font-medium text-gray-700">Heating Type</label>
                                    <input type="text" id="heating_type" name="heating_type" value="{{ old('heating_type', $unit->heating_type) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('heating_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="cooling_type" class="block text-sm font-medium text-gray-700">Cooling Type</label>
                                    <input type="text" id="cooling_type" name="cooling_type" value="{{ old('cooling_type', $unit->cooling_type) }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('cooling_type')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="mt-4">
                                <label for="appliances_included" class="block text-sm font-medium text-gray-700">Appliances Included</label>
                                <textarea id="appliances_included" name="appliances_included" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300">{{ old('appliances_included', $unit->appliances_included) }}</textarea>
                                <p class="mt-1 text-xs text-gray-500">Enter as JSON: {"appliance": true/false}</p>
                                @error('appliances_included')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                          <a href="{{ route('units.show', $unit) }}" 
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