<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Trading Activity') }}
        </h2>
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

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <form action="{{ route('trading-activities.update', $activity) }}" method="POST" class="space-y-8 p-6">
                    @csrf @method('PUT')

                    <div class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Bond Selection -->
                            <div class="space-y-4">
                                <div>
                                    <label for="bond_info_id" class="block text-sm font-medium text-gray-700">Bond *</label>
                                    <select name="bond_info_id" id="bond_info_id" required
                                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                        <option value="">Select a Bond</option>
                                        @foreach($bonds as $bond)
                                            <option value="{{ $bond->id }}" @selected($activity->bond_info_id == $bond->id)>
                                                {{ $bond->isin_code }} - {{ $bond->stock_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <!-- Trade Date/Time -->
                            <div class="space-y-4">
                                <div>
                                    <label for="trade_date" class="block text-sm font-medium text-gray-700">Trade Date *</label>
                                    <input type="date" name="trade_date" id="trade_date" 
                                        value="{{ $activity->trade_date->format('Y-m-d') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="input_time" class="block text-sm font-medium text-gray-700">Trade Time *</label>
                                    <input type="time" name="input_time" id="input_time" 
                                        value="{{ $activity->input_time->format('H:i') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Pricing Information -->
                        <div class="border-t border-gray-200 pt-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Pricing Details</h3>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div>
                                    <label for="amount" class="block text-sm font-medium text-gray-700">Amount (RM million) *</label>
                                    <input type="number" step="0.01" name="amount" id="amount" 
                                        value="{{ old('amount', $activity->amount) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
                                    <input type="number" step="0.0001" name="price" id="price" 
                                        value="{{ old('price', $activity->price) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                                <div>
                                    <label for="yield" class="block text-sm font-medium text-gray-700">Yield (%) *</label>
                                    <input type="number" step="0.01" name="yield" id="yield" 
                                        value="{{ old('yield', $activity->yield) }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                </div>
                            </div>
                        </div>

                        <!-- Value Date -->
                        <div class="border-t border-gray-200 pt-6">
                            <div>
                                <label for="value_date" class="block text-sm font-medium text-gray-700">Value Date *</label>
                                <input type="date" name="value_date" id="value_date" 
                                    value="{{ old('value_date', $activity->value_date->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('trading-activities.index') }}" 
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