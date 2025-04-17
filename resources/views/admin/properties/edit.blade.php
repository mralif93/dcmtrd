<!-- resources/views/properties/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Edit Property') }}
            </h2>
            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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
                    <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $property->name }}</h3>

                    <form action="{{ route('properties.update', $property) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Portfolio Selection -->
                            <div class="col-span-1">
                                <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                                <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                                    <option value="">Select Portfolio</option>
                                    @foreach($portfolios as $id => $name)
                                        <option value="{{ $id }}" {{ old('portfolio_id', $property->portfolio_id) == $id ? 'selected' : '' }}>{{ $name }}</option>
                                    @endforeach
                                </select>
                                @error('portfolio_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Basic Property Information -->
                            <div class="col-span-1">
                                <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                                <input id="category" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="category" value="{{ old('category', $property->category) }}" required>
                                @error('category')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="batch_no" class="block text-sm font-medium text-gray-700">Batch Number</label>
                                <input id="batch_no" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="batch_no" value="{{ old('batch_no', $property->batch_no) }}" required>
                                @error('batch_no')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
                                <input id="name" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="name" value="{{ old('name', $property->name) }}" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address Information -->
                            <div class="col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                                <input id="address" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="address" value="{{ old('address', $property->address) }}" required>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                                <input id="city" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="city" value="{{ old('city', $property->city) }}" required>
                                @error('city')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                                <input id="state" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="state" value="{{ old('state', $property->state) }}" required>
                                @error('state')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                                <input id="country" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="country" value="{{ old('country', $property->country) }}" required>
                                @error('country')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                                <input id="postal_code" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="postal_code" value="{{ old('postal_code', $property->postal_code) }}" required>
                                @error('postal_code')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Property Details -->
                            <div class="col-span-1">
                                <label for="land_size" class="block text-sm font-medium text-gray-700">Land Size (sqm)</label>
                                <input id="land_size" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="land_size" value="{{ old('land_size', $property->land_size) }}" required>
                                @error('land_size')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="gross_floor_area" class="block text-sm font-medium text-gray-700">Gross Floor Area (sqm)</label>
                                <input id="gross_floor_area" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="gross_floor_area" value="{{ old('gross_floor_area', $property->gross_floor_area) }}" required>
                                @error('gross_floor_area')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="usage" class="block text-sm font-medium text-gray-700">Usage</label>
                                <input id="usage" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="usage" value="{{ old('usage', $property->usage) }}" required>
                                @error('usage')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Financial Details -->
                            <div class="col-span-1">
                                <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                                <input id="value" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="value" value="{{ old('value', $property->value) }}" required>
                                @error('value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="ownership" class="block text-sm font-medium text-gray-700">Ownership</label>
                                <input id="ownership" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="ownership" value="{{ old('ownership', $property->ownership) }}" required>
                                @error('ownership')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="share_amount" class="block text-sm font-medium text-gray-700">Share Amount</label>
                                <input id="share_amount" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="share_amount" value="{{ old('share_amount', $property->share_amount) }}" required>
                                @error('share_amount')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="col-span-1">
                                <label for="market_value" class="block text-sm font-medium text-gray-700">Market Value</label>
                                <input id="market_value" type="number" step="0.01" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="market_value" value="{{ old('market_value', $property->market_value) }}" required>
                                @error('market_value')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="col-span-1">
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <option value="active" {{ old('status', $property->status) === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="pending" {{ old('status', $property->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="rejected" {{ old('status', $property->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                    <option value="inactive" {{ old('status', $property->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                    <option value="under_maintenance" {{ old('status', $property->status) === 'under_maintenance' ? 'selected' : '' }}>Under Maintenance</option>
                                    <option value="for_sale" {{ old('status', $property->status) === 'for_sale' ? 'selected' : '' }}>For Sale</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <a href="{{ route('properties.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400 active:bg-gray-500 focus:outline-none focus:border-gray-500 focus:shadow-outline-gray transition ease-in-out duration-150 mr-3">
                                Cancel
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                Update Property
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>