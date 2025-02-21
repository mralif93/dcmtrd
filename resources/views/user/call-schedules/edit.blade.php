<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Call Schedule') }}
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
                <form action="{{ route('call-schedules-info.update', $schedule) }}" method="POST" class="space-y-8 p-6">
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Row 1: Redemption & Call Price -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <!-- Redemption Selection -->
                            <div>
                                <label for="redemption_id" class="block text-sm font-medium text-gray-700">Redemption *</label>
                                <select name="redemption_id" id="redemption_id" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                               {{ $errors->has('redemption_id') ? 'border-red-300' : '' }}">
                                    @foreach($redemptions as $redemption)
                                        <option value="{{ $redemption->id }}" 
                                            @selected(old('redemption_id', $schedule->redemption_id) == $redemption->id)
                                            {{ $schedule->redemption_id == $redemption->id ? 'selected' : '' }}>
                                            {{ $redemption->bond->bond_sukuk_name }} - {{ $redemption->bond->sub_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('redemption_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Call Price -->
                            <div>
                                <label for="call_price" class="block text-sm font-medium text-gray-700">Call Price *</label>
                                <input type="number" name="call_price" id="call_price" 
                                    value="{{ old('call_price', $schedule->call_price) }}" 
                                    required 
                                    step="0.01"
                                    placeholder="Enter call price"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                           {{ $errors->has('call_price') ? 'border-red-300' : '' }}">
                                @error('call_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Start Date & End Date -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="start_date" class="block text-sm font-medium text-gray-700">Start Date *</label>
                                <input type="date" name="start_date" id="start_date" 
                                    value="{{ old('start_date', $schedule->start_date->format('Y-m-d')) }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                           {{ $errors->has('start_date') ? 'border-red-300' : '' }}">
                                @error('start_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label for="end_date" class="block text-sm font-medium text-gray-700">End Date *</label>
                                <input type="date" name="end_date" id="end_date" 
                                    value="{{ old('end_date', $schedule->end_date->format('Y-m-d')) }}" 
                                    required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500
                                           {{ $errors->has('end_date') ? 'border-red-300' : '' }}">
                                @error('end_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="flex justify-end gap-4 border-t border-gray-200 pt-6">
                        <a href="{{ route('call-schedules.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-medium text-gray-700 hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                            Cancel
                        </a>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Update Call Schedule
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>