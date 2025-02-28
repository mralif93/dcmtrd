<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create New Tenant') }}
            </h2>
            <a href="{{ route('tenants.index') }}" 
                class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Back to Tenants
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
                    <form action="{{ route('tenants.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Personal Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Personal Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="first_name" class="block text-sm font-medium text-gray-700">First Name</label>
                                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('first_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="last_name" class="block text-sm font-medium text-gray-700">Last Name</label>
                                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('last_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                                    <input type="email" id="email" name="email" value="{{ old('email') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
                                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="date_of_birth" class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('date_of_birth')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="ssn" class="block text-sm font-medium text-gray-700">SSN (Last 4 digits)</label>
                                    <input type="text" id="ssn" name="ssn" value="{{ old('ssn') }}" placeholder="XXXX" maxlength="4"
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('ssn')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Employment Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Employment Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="occupation" class="block text-sm font-medium text-gray-700">Occupation</label>
                                    <input type="text" id="occupation" name="occupation" value="{{ old('occupation') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('occupation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="employer" class="block text-sm font-medium text-gray-700">Employer</label>
                                    <input type="text" id="employer" name="employer" value="{{ old('employer') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('employer')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="employer_phone" class="block text-sm font-medium text-gray-700">Employer Phone</label>
                                    <input type="text" id="employer_phone" name="employer_phone" value="{{ old('employer_phone') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('employer_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="annual_income" class="block text-sm font-medium text-gray-700">Annual Income</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="annual_income" name="annual_income" step="0.01" value="{{ old('annual_income') }}" 
                                            class="mt-1 block w-full pl-7 rounded-md border-gray-300">
                                    </div>
                                    @error('annual_income')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Emergency Contact -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Emergency Contact</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="emergency_contact_name" class="block text-sm font-medium text-gray-700">Name</label>
                                    <input type="text" id="emergency_contact_name" name="emergency_contact_name" value="{{ old('emergency_contact_name') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('emergency_contact_name')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="emergency_contact_phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                    <input type="text" id="emergency_contact_phone" name="emergency_contact_phone" value="{{ old('emergency_contact_phone') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('emergency_contact_phone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="emergency_contact_relation" class="block text-sm font-medium text-gray-700">Relationship</label>
                                    <input type="text" id="emergency_contact_relation" name="emergency_contact_relation" value="{{ old('emergency_contact_relation') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('emergency_contact_relation')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Information -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Vehicle Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="vehicle_make" class="block text-sm font-medium text-gray-700">Make</label>
                                    <input type="text" id="vehicle_make" name="vehicle_make" value="{{ old('vehicle_make') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="vehicle_model" class="block text-sm font-medium text-gray-700">Model</label>
                                    <input type="text" id="vehicle_model" name="vehicle_model" value="{{ old('vehicle_model') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="vehicle_year" class="block text-sm font-medium text-gray-700">Year</label>
                                    <input type="number" id="vehicle_year" name="vehicle_year" value="{{ old('vehicle_year') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="vehicle_color" class="block text-sm font-medium text-gray-700">Color</label>
                                    <input type="text" id="vehicle_color" name="vehicle_color" value="{{ old('vehicle_color') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>

                                <div>
                                    <label for="license_plate" class="block text-sm font-medium text-gray-700">License Plate</label>
                                    <input type="text" id="license_plate" name="license_plate" value="{{ old('license_plate') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                </div>
                            </div>
                        </div>

                        <!-- Background Check & Status -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Background Check & Status</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="background_check_date" class="block text-sm font-medium text-gray-700">Background Check Date</label>
                                    <input type="date" id="background_check_date" name="background_check_date" value="{{ old('background_check_date') }}" 
                                        class="mt-1 block w-full rounded-md border-gray-300">
                                    @error('background_check_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="flex items-center space-x-6 mt-6">
                                    <div>
                                        <label for="pets" class="inline-flex items-center">
                                            <input type="checkbox" id="pets" name="pets" value="1" 
                                                {{ old('pets') ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2">Has Pets</span>
                                        </label>
                                    </div>

                                    <div>
                                        <label for="active_status" class="inline-flex items-center">
                                            <input type="checkbox" id="active_status" name="active_status" value="1" 
                                                {{ old('active_status', '1') == '1' ? 'checked' : '' }}
                                                class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <span class="ml-2">Active Status</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Additional Notes</h3>
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700">Notes</label>
                                <textarea id="notes" name="notes" rows="3" 
                                    class="mt-1 block w-full rounded-md border-gray-300">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex justify-end space-x-4">
                            <a href="{{ route('tenants.index') }}" 
                                class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                Cancel
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Create
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>