<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Create Property') }}
            </h2>
            <a href="{{ route('properties-info.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('properties-info.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-1 md:col-span-2">
                            <label for="portfolio_id" class="block text-sm font-medium text-gray-700">Portfolio</label>
                            <select id="portfolio_id" name="portfolio_id" class="mt-1 block w-full pl-3 pr-10 py-2 text-base rounded-md {{ $errors->has('portfolio_id') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }} sm:text-sm">
                                <option value="">Select Portfolio</option>
                                @foreach ($portfolios as $portfolio)
                                    <option value="{{ $portfolio->id }}" {{ old('portfolio_id') == $portfolio->id ? 'selected' : '' }}>
                                        {{ $portfolio->portfolio_name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('portfolio_id')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Property Name</label>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('name') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('name')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                            <input type="text" name="category" id="category" value="{{ old('category') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('category') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('category')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="batch_no" class="block text-sm font-medium text-gray-700">Batch No</label>
                            <input type="text" name="batch_no" id="batch_no" value="{{ old('batch_no') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('batch_no') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('batch_no')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="usage" class="block text-sm font-medium text-gray-700">Usage</label>
                            <input type="text" name="usage" id="usage" value="{{ old('usage') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('usage') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('usage')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="address" class="block text-sm font-medium text-gray-700">Address</label>
                            <input type="text" name="address" id="address" value="{{ old('address') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('address') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('address')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
                            <input type="text" name="city" id="city" value="{{ old('city') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('city') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('city')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="state" class="block text-sm font-medium text-gray-700">State</label>
                            <input type="text" name="state" id="state" value="{{ old('state') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('state') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('state')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="country" class="block text-sm font-medium text-gray-700">Country</label>
                            <input type="text" name="country" id="country" value="{{ old('country') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('country') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('country')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="postal_code" class="block text-sm font-medium text-gray-700">Postal Code</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('postal_code') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('postal_code')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="land_size" class="block text-sm font-medium text-gray-700">Land Size (m²)</label>
                            <input type="number" step="0.01" name="land_size" id="land_size" value="{{ old('land_size') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('land_size') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('land_size')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="gross_floor_area" class="block text-sm font-medium text-gray-700">Gross Floor Area (m²)</label>
                            <input type="number" step="0.01" name="gross_floor_area" id="gross_floor_area" value="{{ old('gross_floor_area') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('gross_floor_area') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('gross_floor_area')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="value" class="block text-sm font-medium text-gray-700">Value</label>
                            <input type="number" step="0.01" name="value" id="value" value="{{ old('value') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('value') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="ownership" class="block text-sm font-medium text-gray-700">Ownership</label>
                            <input type="text" name="ownership" id="ownership" value="{{ old('ownership') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('ownership') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('ownership')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="share_amount" class="block text-sm font-medium text-gray-700">Share Amount</label>
                            <input type="number" step="0.01" name="share_amount" id="share_amount" value="{{ old('share_amount') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('share_amount') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('share_amount')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="market_value" class="block text-sm font-medium text-gray-700">Market Value</label>
                            <input type="number" step="0.01" name="market_value" id="market_value" value="{{ old('market_value') }}" class="mt-1 block w-full shadow-sm sm:text-sm rounded-md {{ $errors->has('market_value') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }}">
                            @error('market_value')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base rounded-md {{ $errors->has('status') ? 'border-red-300 text-red-900 focus:outline-none focus:ring-red-500 focus:border-red-500' : 'border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500' }} sm:text-sm">
                                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end gap-4 border-t border-gray-200 mt-6 pt-6">
                        <a href="{{ route('properties-info.index') }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                        class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Create
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>