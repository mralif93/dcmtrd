<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trading Activity') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Error Handling -->
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('trading-m.update', $trading) }}" method="POST" class="p-6">
                    @csrf 
                    @method('PUT')
                    <div class="space-y-6 pb-6">
                        <!-- Basic Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h3>
                            <div>
                                <label for="bond_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                <select name="bond_id" id="bond_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('bond_id') ? 'border-red-300' : '' }}">
                                    <option value="">-- Select a Bond --</option>
                                    @foreach($bonds as $bond)
                                        <option value="{{ $bond->id }}" 
                                            @selected(old('bond_id', $trading->bond_id) == $bond->id)>
                                            {{ $bond->bond_sukuk_name }} - {{ $bond->sub_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bond_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Trading Details Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Trading Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="trade_date" class="block text-sm font-medium text-gray-700">Trade Date *</label>
                                    <input type="date" name="trade_date" id="trade_date" 
                                        value="{{ old('trade_date', $trading->trade_date->format('Y-m-d')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('trade_date') ? 'border-red-300' : '' }}">
                                    @error('trade_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="input_time" class="block text-sm font-medium text-gray-700">Trade Time *</label>
                                    <input type="time" name="input_time" id="input_time" step="1" 
                                        value="{{ old('input_time', $trading->input_time?->format('H:i:s')) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('input_time') ? 'border-red-300' : '' }}">
                                    @error('input_time')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information Section -->
                        <div class="border-b border-gray-200 pb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing Information</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount (RM million)</label>
                                    <input type="number" step="0.01" name="amount" id="amount" 
                                        value="{{ old('amount', $trading->amount) }}"
                                        placeholder="Enter amount in millions"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('amount') ? 'border-red-300' : '' }}">
                                    @error('amount')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                                    <input type="number" step="0.0001" name="price" id="price" 
                                        value="{{ old('price', $trading->price) }}"
                                        placeholder="Enter price per unit"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('price') ? 'border-red-300' : '' }}">
                                    @error('price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="yield" class="block text-sm font-medium text-gray-700">Yield (%)</label>
                                    <input type="number" step="0.01" name="yield" id="yield" 
                                        value="{{ old('yield', $trading->yield) }}"
                                        placeholder="Enter yield percentage"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('yield') ? 'border-red-300' : '' }}">
                                    @error('yield')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label for="value_date" class="block text-sm font-medium text-gray-700">Value Date</label>
                                    <input type="date" name="value_date" id="value_date" 
                                        value="{{ old('value_date', $trading->value_date?->format('Y-m-d')) }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('value_date') ? 'border-red-300' : '' }}">
                                    @error('value_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- System Information -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">System Information</h3>
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $trading->created_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        {{ $trading->updated_at->format('M j, Y H:i') }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('bond-m.show', $trading->bond) }}" 
                           class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Trading Activity
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>